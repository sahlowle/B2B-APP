<?php

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Modules\Subscription\DataTables\GenerateLinkDataTable;
use Modules\Subscription\DataTables\PackageDataTable;
use Modules\Subscription\Services\PackageService;
use Modules\Subscription\Services\Mail\PrivatePlanMailService;
use Modules\Subscription\Entities\{
    Package,
    PackageMeta
};
use Modules\Subscription\Http\Requests\{
    PackageStoreRequest,
    PackageUpdateRequest
};
use Modules\Subscription\Notifications\PrivatePlanNotification;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PackageDataTable $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function index(PackageDataTable $dataTable)
    {
        // $data['users'] = User::select('id', 'name', 'email')->where('status', 'Active')->get();

        $data = [];

        return $dataTable->render('subscription::package.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        do_action('before_admin_create_plan');
        
        $features = PackageService::features();
        $data['features'] = miniCollection($features, true);

        return view('subscription::package.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PackageStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PackageStoreRequest $request)
    {
        $response = (new PackageService)->store($request->all());
        $this->setSessionValue($response);

        return redirect()->route('package.index');
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $data['package'] = Package::find($id);

        if (is_null($data['package'])) {
            return redirect()->route('package.index')->withFail(__('The :x is not found.', ['x' => __('Plan')]));
        }

        $data['features'] = PackageService::editFeature($data['package']);

        return view('subscription::package.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        do_action('before_admin_edit_plan');
        
        $data['package'] = Package::find($id);

        if (is_null($data['package'])) {
            return redirect()->route('package.index')->withFail(__('The :x is not found.', ['x' => __('Plan')]));
        }

        $mainFeatures = PackageService::features();
        $savedFeatures = PackageService::editFeature($data['package'], false);

        foreach ($mainFeatures as $key => &$subArray) {
            foreach ($subArray as $subKey => &$value) {
                if (isset($savedFeatures[$key][$subKey])) {
                    $value = $savedFeatures[$key][$subKey];
                }
            }
        }
        
        $data['features'] = miniCollection($mainFeatures, true);

        $data['defaultFeatures'] = PackageService::features();

        return view('subscription::package.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PackageUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PackageUpdateRequest $request, $id)
    {
        $response = (new PackageService)->update($request->all(), $id);
        $this->setSessionValue($response);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = (new PackageService)->delete($id);
        $this->setSessionValue($response);

        return back();
    }

    /**
     * Get Package Info
     *
     * @param int $id
     * @return Response
     */
    public function getInfo($id)
    {
        $package = Package::with('metadata')->find($id);

        if (is_null($package)) {
            return response()->json([
                'data' => []
            ]);
        }

        $package['duration'] = $package->duration;

        return response()->json($package);
    }

    /**
     * Display a listing of the resource.
     *
     * @param PackageDataTable $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function generateLinkIndex(GenerateLinkDataTable $dataTable, $id)
    {
        $package = Package::find($id);

        if (!$package || ($package && !$package->is_private)) {
            return redirect()->route('package.index')->withErrors(__('This is not a private plan.'));
        }

        $data['id'] = $id;
        $data['users'] = User::select('id', 'name', 'email')->where('status', 'Active')->get();

        return $dataTable->with(['id' => $id])->render('subscription::package.generate-link', $data);
    }

    /**
     * Generate link for private plan
     *
     * @param Request $request
     * @return Response
     */
    public function generateLink(Request $request)
    {
        if (empty($request->plan_id)) {
            return back()->withErrors(__(':x does not exist.', ['x' => __('Plan')]));
        }

        $data['plan_id'] = $request->plan_id;
        if (!empty($request->email)) {
            $data['email'] = $request->email;
        } else {
            $data['alternative'] = \Str::random(25);
        }

        $data['unique_code'] = uniqid();

        $encrypt = techEncrypt(json_encode($data));

        try {
            PackageMeta::insert([
                'package_id' => $request->plan_id,
                'key' => 'generate_link' . $data['unique_code'],
                'value' => $encrypt
            ]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        if ($request->send_mail && validateEmail($request->email)) {
            $request['link'] = $encrypt;
            
            User::where('email', $request->email)->first()?->notify(
                new PrivatePlanNotification($request)
            );
        }

        return back()->withSuccess(__('The link has been successfully generated'));
    }

    /**
     * Destroy Link
     *
     * @param int $id (Plan Meta Id)
     * @return Response
     */
    public function destroyLink($id)
    {
        $response = PackageMeta::where('id', $id)->delete();

        if ($response) {
            return back()->withSuccess(__('The link has been successfully removed.'));
        }

        return back()->withErrors(__('Failed to delete :x, please try again.', ['x' => __('Link')]));
    }
}
