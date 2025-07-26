<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Resources\AjaxSelectSearchResource;
use App\Models\{Country, Currency, Vendor};
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\PurchaseListDataTable;
use Modules\Inventory\Entities\{Location, Purchase, Supplier};
use Modules\Inventory\Http\Requests\PurchaseRequest;
use Modules\Inventory\Services\PurchaseService;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(PurchaseListDataTable $dataTable)
    {
        $data['vendors'] = Vendor::where('status', 'Active')->get();

        return $dataTable->render('inventory::purchase.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $data['vendors'] = Vendor::where('status', 'Active')->get();
        $data['currencies'] = Currency::get();
        $data['countries'] = Country::getAll();

        return view('inventory::purchase.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(PurchaseRequest $request)
    {
        $purchaseHelper = PurchaseService::getInstance($request, $request->vendor_id);

        $response = $purchaseHelper->purchaseStore();

        if ($response['status']) {
            return redirect()->route('purchase.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Purchase')]));
        }

        return redirect()->back()->withErrors($response['message']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['purchaseDetails'] = Purchase::find($id);
        $data['vendors'] = Vendor::where('status', 'Active')->get();
        $data['currencies'] = Currency::get();

        return view('inventory::purchase.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(PurchaseRequest $request, $id)
    {

        $purchaseHelper = PurchaseService::getInstance($request, $request->vendor_id);

        $response = $purchaseHelper->updatePurchase($id);

        if ($response['status']) {
            return redirect()->route('purchase.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Purchase')]));
        }

        return redirect()->back()->withErrors($response['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $status = Purchase::remove($id);

        if (isset($status['type']) && $status['type'] == 'success') {
            return redirect()->back()->withSuccess($status['message']);
        }

        return redirect()->back()->withErrors($status['message']);
    }

    /**
     * product search
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $purchaseHelper = PurchaseService::getInstance($request, $request->vendorId);

        return $purchaseHelper->search();
    }

    /**
     * find supplier
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findSupplier(Request $request)
    {
        $vendorId = auth()->user()->role()->type == 'admin' ? $request->vendorId : auth()->user()->vendor()->vendor_id;
        $result = Supplier::whereLike('name', $request->q)->where('vendor_id', $vendorId)->active()->limit(10)->get();

        return AjaxSelectSearchResource::collection($result);
    }

    /**
     * find location
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findLocation(Request $request)
    {
        $vendorId = auth()->user()->role()->type == 'admin' ? $request->vendorId : auth()->user()->vendor()->vendor_id;

        $result = Location::whereLike('name', $request->q)->where('vendor_id', $vendorId);

        if (isset($request->from_location_id)) {
            $result->where('id', '!=', $request->from_location_id);
        }

        if (isset($request->to_location_id)) {
            $result->where('id', '!=', $request->to_location_id);
        }

        $result = $result->active()->limit(10)->get();

        return AjaxSelectSearchResource::collection($result);
    }

    /**
     * find vendor
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findVendor(Request $request)
    {
        $result = Vendor::whereLike('name', $request->q)->where('status', 'Active')->limit(10)->get();

        return AjaxSelectSearchResource::collection($result);
    }

    public function receive($id)
    {
        $data['purchase'] = Purchase::find($id);

        if ($data['purchase']->status == 'Received') {
            abort(404);
        }

        return view('inventory::purchase.receive', $data);
    }

    /**
     * receive/reject store
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function receiveStore(Request $request, $id)
    {
        $purchaseHelper = PurchaseService::getInstance($request);

        $response = $purchaseHelper->receiveReject($id);

        if ($response['status']) {
            return redirect()->route('purchase.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Purchase')]));
        }

        return redirect()->back()->withErrors($response['message']);
    }
}
