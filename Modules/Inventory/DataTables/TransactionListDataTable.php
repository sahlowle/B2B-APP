<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\Log;

class TransactionListDataTable extends DataTable
{
    /*
   * DataTable Ajax
   *
   * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
   */
    public function ajax(): JsonResponse
    {
        $logs = $this->query();

        return datatables()
            ->of($logs)
            ->editColumn('location', function ($logs) {
                if (! empty($logs->location_id) && $logs->location?->name) {
                    return '<a href="' . route('location.edit', ['id' => $logs->location_id]) . '">' . wrapIt($logs->location->name, 15, ['columns' => 7]) . '</a>';
                }
            })->editColumn('purchase', function ($logs) {
                if (! empty($logs->purchase_id) && $logs->purchase?->reference) {
                    return '<a href="' . route('purchase.edit', ['id' => $logs->purchase_id]) . '">' . wrapIt($logs->purchase->reference, 20, ['columns' => 7]) . '</a>';
                }
            })->editColumn('product', function ($logs) {
                if (! empty($logs->product_id) && $logs->product?->name) {
                    return '<a href="' . route('product.edit', ['code' => $logs->product->code]) . '">' . wrapIt($logs->product->name, 15, ['columns' => 7]) . '</a>';
                }
            })->editColumn('supplier', function ($logs) {
                if (! empty($logs->supplier_id) && $logs->supplier?->name) {
                    return '<a href="' . route('supplier.edit', ['id' => $logs->supplier_id]) . '">' . wrapIt($logs->supplier->name, 20, ['columns' => 7]) . '</a>';
                }
            })->editColumn('currency', function ($logs) {
                return wrapIt($logs->currency?->name, 20, ['columns' => 7]);
            })->editColumn('order', function ($logs) {
                if (! empty($logs->order_id) && $logs->order?->reference) {
                    return '<a href="' . route('order.view', ['id' => $logs->order_id]) . '">' . wrapIt($logs->order->reference, 20, ['columns' => 7]) . '</a>';
                }
            })->editColumn('transfer', function ($logs) {
                if (! empty($logs->transfer_id) && $logs->transfer?->reference) {
                    return '<a href="' . route('transfer.edit', ['id' => $logs->transfer_id]) . '">' . wrapIt($logs->transfer->reference, 20, ['columns' => 7]) . '</a>';
                }
            })->editColumn('quantity', function ($logs) {
                return formatCurrencyAmount($logs->quantity);
            })->editColumn('transaction_type', function ($logs) {

                if (! empty($logs->product_id) && $logs->quantity < 0) {
                    return str_replace('_', ' ', ucfirst($logs->transaction_type)) . ' (' . __('Stock out') . ')';
                } elseif (! empty($logs->product_id) && $logs->quantity > 0) {
                    return str_replace('_', ' ', ucfirst($logs->transaction_type)) . ' (' . __('Stock in') . ')';
                }

                return str_replace('_', ' ', ucfirst($logs->transaction_type));
            })->editColumn('price', function ($logs) {
                return ! empty($logs->price) ? formatCurrencyAmount($logs->price) : null;
            })->editColumn('log_type', function ($logs) {
                return str_replace('_', ' ', ucfirst($logs->log_type));
            })->editColumn('note', function ($logs) {
                return $logs->note;
            })->editColumn('created_at', function ($logs) {
                return $logs->format_created_at;
            })
            ->rawColumns(['location', 'purchase', 'product', 'supplier', 'currency', 'order', 'quantity', 'transaction_type', 'price', 'log_type', 'note', 'transfer', 'created_at'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $logs = Log::select('*')->orderBy('id', 'DESC')->filter();

        return $this->applyScopes($logs);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'location', 'name' => 'location_id', 'title' => __('Location'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'purchase', 'name' => 'purchase_id', 'title' => __('Purchase'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'product', 'name' => 'product_id', 'title' => __('Product'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'supplier', 'name' => 'supplier_id', 'title' => __('Supplier'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'currency', 'name' => 'currency_id', 'title' => __('Currency'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'order', 'name' => 'order_id', 'title' => __('Order'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'transfer', 'name' => 'transfer_id', 'title' => __('Transfer'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'quantity', 'name' => 'quantity', 'title' => __('Quantity'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'transaction_type', 'name' => 'transaction_type', 'title' => __('Transaction Type'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'price', 'name' => 'price', 'title' => __('Price'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'log_type', 'name' => 'log_type', 'title' => __('Log Type'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'note', 'name' => 'note', 'title' => __('Note'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created At'), 'className' => 'align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }

    public function setViewData()
    {
        $statusCounts = $this->query()
            ->selectRaw('log_type, COUNT(*) as count')
            ->groupBy('log_type')
            ->pluck('count', 'log_type');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
