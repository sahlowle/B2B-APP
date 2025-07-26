<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 20-01-2022
 */

namespace App\DataTables;

use App\Models\Order;
use App\Services\CustomFieldService;
use App\Services\Order\InvoiceService;
use Illuminate\Http\JsonResponse;

class VendorOrderDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     */
    public function ajax(): JsonResponse
    {
        $totalAmount = 0;
        $orders = $this->query();

        $dt = datatables()
            ->of($orders)

            ->editColumn('customer', function ($orders) {
                if (! is_null(optional($orders->user)->id)) {
                    return wrapIt(optional($orders->user)->name, 10, ['columns' => 2]);
                }

                return wrapIt(__('Guest'), 10, ['columns' => 2]);
            })->editColumn('total', function ($orders) {
                return formatNumber($orders->vendorProductPrice(session()->get('vendorId'), $orders->id) + $orders->vendorProductShippingTax(session()->get('vendorId'), $orders->id) + InvoiceService::totalCustomAmount($orders, true), optional($orders->currency)->symbol);
            })->editColumn('total_quantity', function ($orders) {
                return formatCurrencyAmount($orders->getTotalVendorProduct(session()->get('vendorId'), $orders->id));
            })->editColumn('reference', function ($orders) {
                return '<a href="' . route('vendorOrder.view', ['id' => $orders->id]) . '">' . $orders->reference . '</a>';
            })->editColumn('status', function ($orders) {
                return '<span class="f-w-600 f-12 text-muted text-uppercase">' . optional($orders->orderStatus)->name . '</span>';
            })->addColumn('created_at', function ($orders) {
                return $orders->format_created_at;
            })->editColumn('payment_status', function ($orders) {
                return statusBadges($orders->vendorPaymentStatus());
            });

        CustomFieldService::dataTableBody($dt, 'orders');

        $dt->addColumn('action', function ($orders) {
            $confirmDel = isActive('BulkPayment') ? 'confirm-delete' : '';

            $view = '<a title="' . __('Show') . '" href="' . route('vendorOrder.view', ['id' => $orders->id]) . '" class="action-icon view-order ' . $confirmDel . '" data-id=' . $orders->id . ' data-payment=' . $orders->vendorPaymentStatus() . '><i class="feather icon-eye"></i></a>';

            $str = '';
            if (auth()->user()?->hasPermission('App\Http\Controllers\Vendor\VendorOrderController@view')) {
                $str .= $view;
            }

            return $str;
        })

            ->rawColumns(['customer', 'total', 'total_quantity', 'reference', 'status', 'created_at', 'payment_status', 'action']);

        return $dt->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $vendorId = session()->get('vendorId');
        $orders = Order::select('orders.id', 'user_id', 'reference', 'order_date', 'currency_id', 'other_discount_amount', 'other_discount_type', 'orders.shipping_charge', 'orders.tax_charge', 'total', 'paid', 'total_quantity', 'order_status_id', 'payment_status', 'orders.created_at')
            ->when(isActive('Pos') && version_compare(module('Pos')->get('version'), '2.0', '>='), function ($query) {
                return $query->addSelect('channel');
            })
            ->whereHas('orderDetails', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->orWhere('note', auth()->user()->id)
            ->with('customFieldValues', 'orderDetails:id,product_id,order_id,vendor_id,shop_id,price,quantity,discount_amount,discount_type,order_status_id', 'user:id,name', 'orderStatus:id,slug,name')
            ->filter();

        return $this->applyScopes($orders);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        $builder = $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false, 'className' => 'text-left align-middle'])

            ->addColumn(['data' => 'reference', 'name' => 'reference', 'title' => __('Invoice'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'customer', 'name' => 'user.name', 'title' => __('Customer'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'total_quantity', 'name' => 'total_quantity', 'title' => __('Products'), 'orderable' => false, 'className' => 'align-middle'])

            ->addColumn(['data' => 'total', 'name' => 'total', 'title' => __('Total'), 'className' => 'align-middle']);

        if (isActive('Pos') && version_compare(module('Pos')->get('version'), '2.0', '>=')) {
            $builder->addColumn(['data' => 'channel', 'name' => 'channel', 'title' => __('Channel'), 'className' => 'align-middle']);
        }

        $builder->addColumn(['data' => 'status', 'name' => 'orderStatus.name', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'payment_status', 'name' => 'payment_status', 'title' => __('Payment Status'), 'className' => 'align-middle']);

        CustomFieldService::dataTableHeader($builder, 'orders');

        $builder->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created at'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '4%',
                'visible' => auth()->user()?->hasAnyPermission(['App\Http\Controllers\Vendor\VendorOrderController@view']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])

            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));

        return $builder;
    }

    public function setViewData()
    {
        $statusCounts = Order::join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->whereHas('orderDetails', function ($q) {
                $q->where('vendor_id', session('vendorId'));
            })->orWhere('note', auth()->user()->id)
            ->selectRaw('order_statuses.name, COUNT(*) as count')
            ->groupBy('order_statuses.name')
            ->pluck('count', 'order_statuses.name');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
