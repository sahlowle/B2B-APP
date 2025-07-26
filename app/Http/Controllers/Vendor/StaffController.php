<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 02-11-2023
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\Vendor\StaffListDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Staff\{
    StoreStaffRequest,
    UpdateStaffRequest
};
use App\Models\{
    Role,
    User
};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StaffController extends Controller
{
    /**
     * Role List
     */
    public function index(StaffListDataTable $dataTable)
    {
        $vendorId = session('vendorId') ?: auth()->user()->vendor()->vendor_id;
        $data = [
            'list_menu' => 'staff',
            'statuses'  => User::getStatuses(),
            'roles'     => Role::getAll()->where('vendor_id', $vendorId),
        ];

        return $dataTable->render('vendor.staff.index', $data);
    }

    /**
     * Create
     */
    public function create(): View
    {
        $vendorId = session('vendorId') ?: auth()->user()->vendor()->vendor_id;
        $data['list_menu'] = 'staff';
        $data['roles'] = Role::where(['type' => 'vendor', 'vendor_id' => $vendorId])->get();
        do_action('before_vendor_create_staff');

        return view('vendor.staff.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $id = (new User())->store($request->only('name', 'email', 'password', 'status'));

            if (empty($id)) {
                throw new \Exception(__('An error has occurred. Please attempt the action again.'));
            }

            $user = User::find($id);
            $user->roles()->sync($request->role_ids);
            $user->vendors()->sync([session('vendorId') ?: auth()->user()->vendor()->vendor_id]);
            $user->setMeta('description', $request->description);
            $user->save();

            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Staff Info')]);
            do_action('after_vendor_create_staff', $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $data['message'] = $e->getMessage();
        }

        $this->setSessionValue($data);

        return redirect()->route('vendor.staffs.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View|RedirectResponse
    {
        $vendorId = session('vendorId') ?: auth()->user()->vendor()->vendor_id;
        $data['list_menu'] = 'staff';
        $data['staff'] = User::getAll()->where('id', $id)->first();

        if (! $data['staff']) {
            return redirect()->back()->withFail(__('Staff does not exist.'));
        }

        $data['roleIds'] = $data['staff']->roles()->pluck('id')->toArray();
        $data['roles'] = Role::where(['type' => 'vendor', 'vendor_id' => $vendorId])->get();

        return view('vendor.staff.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, $id): RedirectResponse
    {

        try {
            DB::beginTransaction();

            $userStore = (new user())->updateUser($request->data, $id);

            if (! $userStore) {
                throw new \Exception(__('An error has occurred. Please attempt the action again.'));
            }

            $user = User::find($id);
            $user->roles()->sync($request->role_ids);

            DB::commit();
            $response['status'] = 'success';
            $response['message'] = __('The :x has been successfully saved.', ['x' => __('Staff Info')]);
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage();
        }

        $this->setSessionValue($response);

        return to_route('vendor.staffs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $result = $this->checkExistence($id, 'users');

        if ($result['status'] != true) {
            $response['message'] = $result['message'];
        }

        $response = (new User())->remove($id);

        if ($response['status'] == 'success') {
            do_action('after_vendor_delete_staff');
            $response['message'] = __('The :x has been successfully deleted.', ['x' => __('Staff')]);
        }

        $this->setSessionValue($response);

        return to_route('vendor.staffs.index');
    }
}
