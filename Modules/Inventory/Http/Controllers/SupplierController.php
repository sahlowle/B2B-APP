<?php

namespace Modules\Inventory\Http\Controllers;

use App\Models\{Country, Vendor};
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\SupplierListDataTable;
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
    public function index(SupplierListDataTable $dataTable)
    {
        $data['vendors'] = Vendor::where('status', 'Active')->get();

        return $dataTable->render('inventory::supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $data['countries'] = Country::getAll();
        $data['vendors'] = Vendor::where('status', 'Active')->get();

        return view('inventory::supplier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(SupplierStoreRequest $request)
    {

        if (empty($request->vendor_id) && isset($request->api)) {
            return response()->json([
                'status' => false,
                'message' =>  __('Please select a vendor first!'),
            ]);
        }

        $supplier = Supplier::store($request->all());

        if ($supplier) {

            if (isset($request->api)) {
                return response()->json([
                    'status' => true,
                    'response' =>  $supplier,
                    'message' => __('The :x has been successfully saved.', ['x' => __('Supplier')]),
                ]);
            }

            return redirect()->route('supplier.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Supplier')]));
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
        $data['supplier'] = Supplier::find($id);
        $data['vendors'] = Vendor::where('status', 'Active')->get();

        return view('inventory::supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(SupplierUpdateRequest $request, $id)
    {
        if (Supplier::updateLocation($request->only('name', 'company_name', 'vendor_id', 'parent_id', 'address', 'country', 'state', 'city', 'zip', 'phone', 'email', 'status'), $id)) {
            return redirect()->route('supplier.index')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Supplier')]));
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
        $status = Supplier::remove($id);

        if (isset($status['type']) && $status['type'] == 'success') {
            return redirect()->back()->withSuccess($status['message']);
        }

        return redirect()->back()->withErrors($status['message']);
    }
}
