<?php

namespace Modules\Inventory\Http\Controllers\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\VendorTransferDataTable;
use Modules\Inventory\Entities\{Location, Transfer};
use Modules\Inventory\Http\Requests\TransferRequest;
use Modules\Inventory\Services\TransferService;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(VendorTransferDataTable $dataTable)
    {
        $data['locations'] = Location::where('vendor_id', auth()->user()->vendor()->vendor_id)->get();

        return $dataTable->render('inventory::vendor.transfer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('inventory::vendor.transfer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(TransferRequest $request)
    {
        $transferHelper = TransferService::getInstance($request, auth()->user()->vendor()->vendor_id, $request->from_location_id);

        $response = $transferHelper->transferStore();

        if ($response['status']) {
            return redirect()->route('vendor.transfer.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Transfer')]));
        }

        return redirect()->back()->withErrors($response['message']);
    }

    /**
     * search
     *
     * @return \Illuminate\Http\JsonResponse\
     */
    public function search(Request $request)
    {
        $transferHelper = TransferService::getInstance($request, auth()->user()->vendor()->vendor_id, $request->fromLocationId);

        return $transferHelper->search();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->isApplicable($id);

        $data['transferDetails'] = Transfer::find($id);

        return view('inventory::vendor.transfer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(TransferRequest $request, $id)
    {
        $this->isApplicable($id);

        $transferHelper = TransferService::getInstance($request, auth()->user()->vendor()->vendor_id);

        $response = $transferHelper->updateTransfer($id);

        if ($response['status']) {
            return redirect()->route('vendor.transfer.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Transfer')]));
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
        $this->isApplicable($id);

        $status = Transfer::remove($id);

        if (isset($status['type']) && $status['type'] == 'success') {
            return redirect()->back()->withSuccess($status['message']);
        }

        return redirect()->back()->withErrors($status['message']);
    }

    public function receive($id)
    {

        $this->isApplicable($id);

        $data['transfer'] = Transfer::find($id);

        if ($data['transfer']->status == 'Received') {
            abort(404);
        }

        return view('inventory::vendor.transfer.receive', $data);
    }

    /**
     * receive/reject store
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function receiveStore(Request $request, $id)
    {
        $this->isApplicable($id);

        $transferHelper = TransferService::getInstance($request);

        $response = $transferHelper->receiveReject($id);

        if ($response['status']) {
            return redirect()->route('vendor.transfer.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Transfer')]));
        }

        return redirect()->back()->withErrors($response['message']);
    }

    protected function isApplicable($id = null)
    {
        $transfer = Transfer::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id);

        if (! $transfer->exists()) {
            abort(404);
        }

        return true;
    }
}
