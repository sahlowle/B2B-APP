<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\StockManagement;
use DB;

class VendorInventoryDataTable extends DataTable
{
    private $committed = 0;

    private $unAvailable = 0;

    /*
   * DataTable Ajax
   *
   * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
   */
    public function ajax(): JsonResponse
    {
        $stocks = $this->query();

        return datatables()
            ->of($stocks)
            ->editColumn('product', function ($stocks) {
                return wrapIt($stocks->product?->name, 20);
            })->editColumn('unavailable', function ($stocks) {
                $this->unAvailable = abs($stocks->unAvailable()['total_unavailable']);

                return $this->unAvailable;
            })->editColumn('available', function ($stocks) {
                return formatCurrencyAmount($stocks->available);
            })->editColumn('committed', function ($stocks) {
                $this->committed = abs($stocks->commited());

                return formatCurrencyAmount($this->committed);
            })->editColumn('on_hand', function ($stocks) {
                return formatCurrencyAmount($this->unAvailable + $this->committed + $stocks->available);
            })->editColumn('incoming', function ($stocks) {
                return formatCurrencyAmount($stocks->incoming());
            })->addColumn('action', function ($stocks) {
                $str = '';

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\InventoryController@adjust')) {
                    $str = '<a title="' . __('Adjust') . '" href="' . route('vendor.inventory.adjust', ['product_id' => $stocks->product_id, 'location_id' => $stocks->location_id]) . '" class="action-icon adjust_page"><i class="fas fa-pen-square"></i></a>&nbsp;';
                }

                return $str;
            })
            ->rawColumns(['product', 'unavailable', 'available', 'committed', 'on_hand', 'incoming', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {

        $vendorId = auth()->user()->vendor()->vendor_id;
        $stocks = StockManagement::select('*', DB::raw('sum(quantity) as available'))
            ->whereIn('type', stockKeyword())
            ->whereHas('location', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('location')
            ->whereHas('product', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->groupBy('product_id')
            ->filter();

        return $this->applyScopes($stocks);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'product', 'name' => 'product_id', 'title' => __('Product'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'unavailable', 'name' => 'quantity', 'title' => __('Unavailable'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'committed', 'name' => 'quantity', 'title' => __('Committed'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'available', 'name' => 'quantity', 'title' => __('Available'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'on_hand', 'name' => 'quantity', 'title' => __('On Hand'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'incoming', 'name' => 'quantity', 'title' => __('Incoming'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Adjust'), 'width' => '12%',
                'className' => 'text-right align-middle',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Inventory\Http\Controllers\Vendor\InventoryController@adjust']),
                'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
