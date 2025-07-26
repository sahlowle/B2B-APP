<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\Purchase;

class VendorPurchaseDataTable extends DataTable
{
    /*
   * DataTable Ajax
   *
   * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
   */
    public function ajax(): JsonResponse
    {
        $purchases = $this->query();

        return datatables()
            ->of($purchases)
            ->editColumn('reference', function ($purchases) {
                return '<a href="' . route('vendor.purchase.edit', ['id' => $purchases->id]) . '">' . wrapIt($purchases->reference, 10, ['columns' => 4]) . '</a>';
            })->editColumn('supplier', function ($purchases) {
                return wrapIt(optional($purchases->supplier)->name, 20, ['columns' => 4]);
            })->editColumn('location', function ($purchases) {
                return wrapIt(optional($purchases->location)->name, 15, ['columns' => 4]);
            })->editColumn('arrival_date', function ($purchases) {
                return formatDate($purchases->arrival_date);
            })->editColumn('status', function ($purchases) {
                return statusBadges(lcfirst($purchases->status));
            })->editColumn('total_amount', function ($purchases) {
                return formatNumber($purchases->total_amount, $purchases->currency->symbol);
            })->addColumn('action', function ($purchases) {
                $str = '';

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\PurchaseController@receive')) {
                    if ($purchases->status != 'Received') {
                        $str .= '<a title="' . __('Receive Inventory') . '" href="' . route('vendor.purchase.receive', ['id' => $purchases->id]) . '" class="action-icon"><i class="fas fa-cart-plus"></i></a>&nbsp;';
                    }
                }

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\PurchaseController@edit')) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('vendor.purchase.edit', ['id' => $purchases->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\PurchaseController@destroy')) {
                    $str .= '<form method="post" action="' . route('vendor.purchase.destroy', ['id' => $purchases->id]) . '" id="delete-purchase-' . $purchases->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $purchases->id . ' data-delete="purchase" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Supplier')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </button>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['reference', 'supplier', 'location', 'arrival_date', 'status', 'action', 'total_amount'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $purchases = Purchase::select('id', 'reference', 'supplier_id', 'location_id', 'vendor_id', 'currency_id', 'arrival_date', 'total_amount', 'status')->where('vendor_id', auth()->user()->vendor()->vendor_id)->with('location', 'supplier', 'currency', 'vendor')->filter();

        return $this->applyScopes($purchases);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false])
            ->addColumn(['data' => 'reference', 'name' => 'reference', 'title' => __('Reference'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'location', 'name' => 'location_id', 'title' => __('Location'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'supplier', 'name' => 'supplier_id', 'title' => __('Supplier'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'arrival_date', 'name' => 'arrival_date', 'title' => __('Arrival Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'total_amount', 'name' => 'total_amount', 'title' => __('Total Amount'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'className' => 'text-right align-middle',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Inventory\Http\Controllers\Vendor\PurchaseController@receive', 'Modules\Inventory\Http\Controllers\Vendor\PurchaseController@edit', 'Modules\Inventory\Http\Controllers\Vendor\PurchaseController@destroy']),
                'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }

    public function setViewData()
    {
        $statusCounts = $this->query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
