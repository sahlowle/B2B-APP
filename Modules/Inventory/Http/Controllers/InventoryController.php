<?php

namespace Modules\Inventory\Http\Controllers;

use App\Models\{Preference, Product, Vendor};
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\DataTables\{InventoryListDataTable, TransactionListDataTable};
use Modules\Inventory\Entities\{Location, StockManagement};

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(InventoryListDataTable $dataTable)
    {
        $data['vendors'] = Vendor::where('status', 'Active')->get();
        $data['locations'] = Location::get();

        return $dataTable->render('inventory::stock.index', $data);
    }

    /**
     * adjust
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adjust(Request $request)
    {

        if ($request->isMethod('GET')) {
            $data['product'] = Product::find($request->product_id);
            $data['location'] = Location::find($request->location_id);
            $stock = StockManagement::getStock($data['product']->id, $data['product']->vendor_id, $data['location']->id);

            if (! isset($stock[0])) {
                abort(403);
            }

            $data['stock'] = $stock[0];

            return view('inventory::stock.adjust', $data);
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
            return redirect()->route('inventory.index')->withSuccess(__('Stock update successfully.'));
        }

        return redirect()->back()->withErrors(__('Something went wrong, please try again.'));
    }

    /**
     * settings
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|void
     */
    public function settings(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('inventory::settings.setting');
        }

        $i = 0;

        foreach ($request->except('_token') as $key => $value) {
            $preference[$i]['category'] = 'inventory_module';
            $preference[$i]['field'] = $key;
            $preference[$i]['value'] = $value;
            $i++;
        }

        if (Preference::store($preference)) {
            return redirect()->back()->withSuccess(__('The :x has been successfully saved.', ['x' => __('Settings')]));
        }
    }

    /**
     * transaction
     *
     * @return mixed
     */
    public function transaction(TransactionListDataTable $dataTable)
    {
        return $dataTable->render('inventory::stock.transaction');
    }
}
