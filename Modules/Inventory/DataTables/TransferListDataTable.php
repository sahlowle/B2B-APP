<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\Transfer;

class TransferListDataTable extends DataTable
{
    /*
   * DataTable Ajax
   *
   * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
   */
    public function ajax(): JsonResponse
    {
        $transfer = $this->query();

        return datatables()
            ->of($transfer)
            ->editColumn('reference', function ($transfer) {
                return '<a href="' . route('transfer.edit', ['id' => $transfer->id]) . '">' . wrapIt($transfer->reference, 10, ['columns' => 4]) . '</a>';
            })->editColumn('vendor', function ($transfer) {
                return wrapIt($transfer->vendor?->name, 15, ['columns' => 4]);
            })->editColumn('from_location', function ($transfer) {
                return wrapIt($transfer->fromLocation?->name, 15, ['columns' => 4]);
            })->editColumn('to_location', function ($transfer) {
                return wrapIt($transfer->toLocation?->name, 15, ['columns' => 4]);
            })->editColumn('arrival_date', function ($transfer) {
                return formatDate($transfer->arrival_date);
            })->editColumn('status', function ($transfer) {
                return statusBadges(lcfirst($transfer->status));
            })->editColumn('quantity', function ($transfer) {
                return formatCurrencyAmount($transfer->quantity);
            })->addColumn('action', function ($transfer) {
                $str = '';

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\TransferController@receive')) {
                    if ($transfer->status != 'Received') {
                        $str .= '<a title="' . __('Receive Inventory') . '" href="' . route('transfer.receive', ['id' => $transfer->id]) . '" class="action-icon"><i class="fas fa-cart-plus"></i></a>&nbsp;';
                    }
                }

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\TransferController@edit')) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('transfer.edit', ['id' => $transfer->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\TransferController@destroy')) {
                    $str .= '<form method="post" action="' . route('transfer.destroy', ['id' => $transfer->id]) . '" id="delete-purchase-' . $transfer->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $transfer->id . ' data-delete="purchase" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Transfer')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </button>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['reference', 'vendor', 'from_location', 'to_location', 'arrival_date', 'status', 'action', 'quantity'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $transfer = Transfer::select('id', 'reference', 'to_location_id', 'from_location_id', 'vendor_id', 'arrival_date', 'quantity', 'status')->with('fromLocation', 'toLocation', 'vendor')->filter();

        return $this->applyScopes($transfer);
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
            ->addColumn(['data' => 'vendor', 'name' => 'vendor_id', 'title' => __('Vendor'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'from_location', 'name' => 'from_location_id', 'title' => __('Origin'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'to_location', 'name' => 'to_location_id', 'title' => __('Destination'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'quantity', 'name' => 'quantity', 'title' => __('Quantity'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'arrival_date', 'name' => 'arrival_date', 'title' => __('Arrival Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'className' => 'text-right align-middle',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Inventory\Http\Controllers\TransferController@receive', 'Modules\Inventory\Http\Controllers\TransferController@edit', 'Modules\Inventory\Http\Controllers\TransferController@destroy']),
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
