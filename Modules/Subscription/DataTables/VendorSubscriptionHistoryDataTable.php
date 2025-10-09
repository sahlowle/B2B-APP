<?php

/**
 * @package VendorSubscriptionHistoryDataTable
 * @author TechVillage <support@techvill.org>
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-05-2023
 */

namespace Modules\Subscription\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Subscription\Entities\PackageSubscription;
use Modules\Subscription\Entities\SubscriptionDetails;

class VendorSubscriptionHistoryDataTable extends DataTable
{
    /*
    * DataTable Ajax
    *
    * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
    */
    public function ajax(): JsonResponse
    {
        $subscription = $this->query();
        return datatables()
            ->of($subscription)
            ->editColumn('code', function ($subscription) {
                return $subscription->code;
            })
            ->editColumn('package', function ($subscription) {
                if ($subscription->package?->name) {
                    return trimWords($subscription->package?->name, 30);
                }
                return __('Unknown');
            })

            ->editColumn('activation_date', function ($subscription) {
                return timeZoneFormatDate($subscription->activation_date);
            })
            ->editColumn('next_billing_date', function ($subscription) {
                return timeZoneFormatDate($subscription->next_billing_date);
            })
            ->editColumn('billing_price', function ($subscription) {
                return formatNumber($subscription->billing_price);
            })->editColumn('billing_cycle', function ($subscription) {
                return ucfirst($subscription->billing_cycle);
            })->editColumn('payment_status', function ($subscription) {
                return ucfirst($subscription->payment_status);
            })->editColumn('status', function ($subscription) {
                return statusBadges(lcfirst($subscription->status));
            })->addColumn('action', function ($subscription) {

                $str = '';
                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\Vendor\SubscriptionController@invoice'])) {
                    $str .= '<a title="' . __('Invoice') . '" href="' . route('vendor.subscription.invoice', ['id' => $subscription->id]) . '" class="action-icon"><i class="feather icon-eye"></i></a>&nbsp';
                }

                return $str;
            })
            ->rawColumns(['package', 'code', 'activation_date', 'next_billing_date', 'billing_price', 'billing_cycle', 'payment_status', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $subscriptionPayments = SubscriptionDetails::where('user_id', auth()->user()->id)->with('user', 'package')->filter();
        return $this->applyScopes($subscriptionPayments);
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
            ->addColumn(['data' => 'code', 'name' => 'package.code', 'title' => __('Subscription Code'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'package', 'name' => 'package.name', 'title' => __('Plan'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'activation_date', 'name' => 'activation_date', 'title' => __('Activation Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'next_billing_date', 'name' => 'next_billing_date', 'title' => __('Next Billing'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'billing_price', 'name' => 'billing_price', 'title' => __('Price'), 'width' => '5%', 'className' => 'align-middle'])
            ->addColumn(['data' => 'billing_cycle', 'name' => 'billing_cycle', 'title' => __('Cycle'), 'width' => '5%', 'className' => 'align-middle'])
            ->addColumn(['data' => 'payment_status', 'name' => 'payment_status', 'title' => __('Payment Status'), 'className' => 'align-middle text-center'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'width' => '5%', 'className' => 'align-middle'])

            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '5%',
                'visible' => $this->hasPermission(['Modules\Subscription\Http\Controllers\Vendor\SubscriptionController@invoice']),
                'orderable' => false, 'searchable' => false
            ])

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
