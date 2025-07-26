<?php

namespace Modules\Inventory\Http\Controllers\Vendor;

use App\Models\Country;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\VendorSupplierDataTable;
use Modules\Inventory\Entities\Supplier;
use Modules\Inventory\Http\Requests\SupplierStoreRequest;
use Modules\Inventory\Http\Requests\SupplierUpdateRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(VendorSupplierDataTable $dataTable)
    {
        return $dataTable->render('inventory::vendor.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $data['countries'] = Country::getAll();

        return view('inventory::vendor.supplier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(SupplierStoreRequest $request)
    {
        $request['vendor_id'] = auth()->user()->vendor()->vendor_id;
        $supplier = Supplier::store($request->all());

        if ($supplier) {

            if (isset($request->api)) {
                return response()->json([
                    'status' => true,
                    'response' =>  $supplier,
                    'message' => __('The :x has been successfully saved.', ['x' => __('Supplier')]),
                ]);
            }

            return redirect()->route('vendor.supplier.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Supplier')]));
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
        $data['supplier'] = Supplier::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id)->first();

        if (empty($data['supplier'])) {
            abort(404);
        }

        return view('inventory::vendor.supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(SupplierUpdateRequest $request, $id)
    {

        $supplier = Supplier::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id)->first();

        if (empty($supplier)) {
            abort(404);
        }

        if (Supplier::updateLocation($request->only('name', 'company_name', 'vendor_id', 'parent_id', 'address', 'country', 'state', 'city', 'zip', 'phone', 'email', 'status'), $id)) {
            return redirect()->route('vendor.supplier.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Supplier')]));
        }

        return redirect()->back()->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $supplier = Supplier::where('id', $id)->where('vendor_id', auth()->user()->vendor()->vendor_id)->first();

        if (empty($supplier)) {
            abort(404);
        }

        $status = Supplier::remove($id);

        if (isset($status['type']) && $status['type'] == 'success') {
            return redirect()->back()->withSuccess($status['message']);
        }

        return redirect()->back()->withErrors($status['message']);
    }
}
