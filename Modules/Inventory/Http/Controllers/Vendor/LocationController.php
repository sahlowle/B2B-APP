<?php

namespace Modules\Inventory\Http\Controllers\Vendor;

use App\Models\{Country, Product};
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\VendorLocationDataTable;
use Modules\Inventory\Entities\{Location, StockManagement};
use Modules\Inventory\Http\Requests\{LocationStoreRequest, LocationUpdateRequest};

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(VendorLocationDataTable $dataTable)
    {
        return $dataTable->render('inventory::vendor.location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $data['countries'] = Country::getAll();

        do_action('before_vendor_create_location');

        return view('inventory::vendor.location.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(LocationStoreRequest $request)
    {
        $request['vendor_id'] = auth()->user()->vendor()->vendor_id;

        $location = Location::store($request->all());

        if ($location) {

            do_action('after_vendor_create_location', $location);

            if (isset($request->api)) {
                return response()->json([
                    'status' => true,
                    'response' =>  $location,
                    'message' => __('The :x has been successfully saved.', ['x' => __('Location')]),
                ]);
            }

            return redirect()->route('vendor.location.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Location')]));
        }

        return redirect()->back()->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['location'] = Location::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id)->first();

        if (empty($data['location'])) {
            abort(404);
        }

        return view('inventory::vendor.location.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(LocationUpdateRequest $request, $id)
    {

        $location = Location::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id)->first();

        if (empty($location)) {
            abort(404);
        }

        $update = Location::updateLocation($request->only('name', 'slug', 'vendor_id', 'parent_id', 'address', 'country', 'state', 'city', 'zip', 'phone', 'email', 'status', 'is_default'), $id);

        if ($update['status']) {
            return redirect()->route('vendor.location.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Location')]));
        }

        return redirect()->back()->withErrors($update['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $location = Location::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id)->first();

        if (empty($location)) {
            abort(404);
        }

        $status = Location::remove($id);

        do_action('after_vendor_delete_location');

        if (isset($status['type']) && $status['type'] == 'success') {
            return redirect()->back()->withSuccess($status['message']);
        }

        return redirect()->back()->withErrors($status['message']);
    }

    /**
     * vendor location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vendorLocation(Request $request)
    {
        if ($request->product_id == '') {
            $data['isInitialize'] = 1;
            $data['locations'] = Location::select('id', 'vendor_id', 'name')->where('vendor_id', $request->vendor_id)->active()->get();
        } else {
            $product = Product::find($request->product_id);
            $data = StockManagement::getVendorLocationStock($request->product_id, $request->vendor_id, true);
        }

        if (isset($data['locations']) && count($data['locations']) > 0 || isset($data['stocks']) && count($data['stocks']) > 0) {
            return response()->json(
                [
                    'status' => 1,
                    'data' =>  $data,
                    'message' =>  __('All of locations stock will be initialize.'),
                ]
            );
        }

        return response()->json(
            [
                'status' => 0,
                'message' =>  __('Location not found! Please create location for this vendor.'),
            ]
        );
    }
}
