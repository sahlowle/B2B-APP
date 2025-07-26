<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 17-08-2021
 *
 * @modified 29-09-2021
 * @modified 15-03-2023
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\VendorListDataTable;
use App\Exports\VendorListExport;
use App\Services\Mail\UserMailService;
use Modules\Shop\Http\Models\Shop;
use Modules\Commission\Http\Models\Commission;
use App\Http\Resources\AjaxSelectSearchResource;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\{
    StoreVendorRequest,
    UpdateVendorRequest
};
use App\Models\{
    Role,
    User,
    Vendor,
    VendorUser,
};
use Excel;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Location;

class VendorController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * Vendor List
     *
     * @return mixed
     */
    public function index(VendorListDataTable $dataTable)
    {

        return $dataTable->render('admin.vendors.index');
    }

    /**
     * Vendor create
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['roles'] = Role::getAll()->where('type', 'vendor');
        $data['commission'] = Commission::getAll()->first();

        return view('admin.vendors.create', $data);
    }

    /**
     * Store vendor
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVendorRequest $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        if ($this->c_p_c()) {
            Session::flush();

            return view('errors.installer-error', ['message' => __(strrev('x: morf edoc esahcrup ruoy yfirev esaelP .eussi noitadilav esnecil gnicaf si tcudorp sihT'), ['x' => '<a style="color:#fcca19" href="' . route('purchase-code-check', ['bypass' => 'purchase_code']) . '">' . __('here') . '</a>'])]);
        }

        do_action('before_vendor_create');

        try {
            DB::beginTransaction();

            $vendor = Vendor::withTrashed()->where('email', $request->email)->first();
            $vendorId = $vendor?->id;
            if (! $vendor) {
                $vendorId = (new Vendor())->store($request->vendor_data);
                $request['vendor_id'] = $vendorId;
                $alias = cleanedUrl($request->alias);
                $request->merge(['alias' => $alias]);
                (new Shop())->store($request->only('vendor_id', 'name', 'email', 'website', 'alias', 'phone', 'address'));
            } else {
                $vendor->restore();
            }

            if (isset($request->user_id)) {
                $user = User::find($request->user_id);
            } else {
                $user = User::where('email', $request->email)->first();
            }

            if (! $user) {
                // Store user information
                $id = (new User())->store($request->only('name', 'email', 'phone', 'password', 'activation_code', 'status'));
                $user = User::find($id);
            }

            if ($user->roles()->first()?->type !== 'admin') {
                $user->roles()->sync($request->role_ids);
            }

            $user->vendors()->sync($vendorId);

            if (isset($request->send_mail) && $request->status != 'Inactive' && ! empty($request['email'])) {
                $emailResponse = (new UserMailService())->send($request);

                if ($emailResponse['status'] == false) {
                    throw new \Exception(__('Email is not send.'));
                }
            }

            Location::store([
                'name' => $request->name,
                'slug' => $request->alias,
                'parent_id' => null,
                'vendor_id' => $vendorId,
                'status' => 'Active',
                'is_default' => 1,
            ]);

            \DB::commit();

            do_action('after_vendor_create', ['vendor_id' => $vendorId, 'user' => $user]);

            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Vendor')]), 'success');

        } catch (\Exception $e) {
            \DB::rollBack();
            $response['status'] = 'fail';
            $response['message'] = $e->getMessage();
        }

        $this->setSessionValue($response);

        return redirect()->route('vendors.index');
    }

    /**
     * Edit vendor
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $vendor = Vendor::getAll()->where('id', $id)->first();

        if (empty($vendor)) {
            $response = $this->messageArray(__(':x does not exist.', ['x' => __('Vendor')]), 'fail');
            $this->setSessionValue($response);

            return redirect()->route('vendors.index');
        }

        $data['user'] = User::whereHas('vendors', function ($q) use ($id) {
            $q->where('vendor_id', $id);
        })->whereHas('roles', function ($q) {
            $q->whereNull('vendor_id');
        })->first();

        $data['commission'] = Commission::getAll()->first();
        $data['vendors'] = $vendor;
        $data['shops'] = Shop::getAll()->where('vendor_id', $id);
        $data['shop_exist'] = isset($request->shop) && ! empty($request->shop) ? $request->shop : null;

        return view('admin.vendors.edit', $data);
    }

    /**
     * Update Vendor
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'vendors');

        if ($result['status'] === false) {
            $response['message'] = $result['message'];
            $this->setSessionValue($response);

            return redirect()->route('vendors.index');
        }

        (new Vendor())->updateVendor($request->data, $id);


        if (isset($request->user_id)) {
            VendorUser::where('user_id', $request->user_id)->delete();

            $user = User::find($request->user_id);
            $user->vendors()->sync($id);

            if ($user->roles()->first()->type !== 'admin') {
                $vendorRole = Role::getAll()->where('type', 'vendor')->first();
                $user->roles()->sync($vendorRole->id);
            }
        }

        $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Vendor')]), 'success');
        $this->setSessionValue($response);

        if ($request->shop) {
            return redirect()->route('shop.index');
        }

        return redirect()->route('vendors.index');
    }

    /**
     * Remove Vendor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'vendors');

            if ($result['status'] === true) {
                $response = (new Vendor())->remove($id);
            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);

        return redirect()->route('vendors.index');
    }

    /**
     * Vendor list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['vendors'] = Vendor::getAll();

        return printPDF($data, 'vendors_lists' . time() . '.pdf', 'admin.vendors.list_pdf', view('admin.vendors.list_pdf', $data), 'pdf');
    }

    /**
     * Vendor list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new VendorListExport(), 'vendor_lists' . time() . '.csv');
    }

    /**
     * Find vendors
     *
     * @return json
     */
    public function findVendor(Request $request)
    {
        $vendors = Vendor::whereLike('name', $request->q)->limit(10)->get();

        return AjaxSelectSearchResource::collection($vendors);
    }

    public function c_p_c()
    {
        if (! g_e_v()) {
            return true;
        }
        if (! g_c_v()) {
            try {
                $d_ = g_d();
                $e_ = g_e_v();
                $e_ = explode('.', $e_);
                $c_ = md5($d_ . $e_[1]);
                if ($e_[0] == $c_) {
                    p_c_v();

                    return false;
                }

                return true;
            } catch (\Exception $e) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find users
     *
     * @return array
     */
    public function findVendorAssignUsers(Request $request)
    {
        // Fetch users who do not have a vendorUser relationship and match the query, limited to 20 results
        return User::select('id', 'name', 'email')
            ->doesntHave('vendorUser')
            ->where('status', 'Active')
            ->whereLike('name', $request->q)
            ->limit(20)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $user->fileUrl(),
                ];
            });
    }
}
