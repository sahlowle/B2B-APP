<?php

namespace Modules\Inventory\Http\Controllers\Vendor;

use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\{VendorInventoryDataTable, VendorTransactionDataTable};
use Modules\Inventory\Entities\{Location, StockManagement};

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(VendorInventoryDataTable $dataTable)
    {
        $data['locations'] = Location::where('vendor_id', auth()->user()->vendor()->vendor_id)->get();

        return $dataTable->render('inventory::vendor.stock.index', $data);
    }

    /**
     * adjust
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adjust(Request $request)
    {
        $vendorId = auth()->user()->vendor()->vendor_id;

        $data['product'] = Product::find($request->product_id);

        if ($data['product']->vendor_id != $vendorId) {
            abort(404);
        }

        if ($request->isMethod('GET')) {

            $data['location'] = Location::find($request->location_id);
            $stock = StockManagement::getStock($data['product']->id, $data['product']->vendor_id, $data['location']->id);

            if (! isset($stock[0])) {
                abort(403);
            }

            $data['stock'] = $stock[0];

            return view('inventory::vendor.stock.adjust', $data);
        }

        $data = [];

        if ($request->adjust_type == 'unavailable' || $request->adjust_type == 'available') {
            $data = [
                'product_id' => $request->product_id,
                'location_id' => $request->location_id,
                'adjust_type' => $request->adjust_type,
                'reason' => $request->reason,
                'adjust_by' => $request->adjust_type == 'unavailable' ? -($request->quantity) : $request->quantity,
            ];
        } else {
            $data = [
                'product_id' => $request->product_id,
                'location_id' => $request->location_id,
                'adjust_type' => $request->adjust_type,
                'reason' => $request->reason,
                'adjust_by' => $request->quantity,
            ];
        }

        if ($data['adjust_by'] != 0 && StockManagement::adjust($data, null, false)) {
            return redirect()->route('vendor.inventory.index')->withSuccess(__('Stock update successfully.'));
        }

        return redirect()->back()->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * transaction
     *
     * @return mixed
     */
    public function transaction(VendorTransactionDataTable $dataTable)
    {
        return $dataTable->render('inventory::vendor.stock.transaction');
    }
}
