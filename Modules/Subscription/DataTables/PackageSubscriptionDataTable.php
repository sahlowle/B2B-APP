<?php

/**
 * @package PackageSubscriptionDataTable
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 20-02-2023
 */

namespace Modules\Subscription\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Subscription\Entities\PackageSubscription;

class PackageSubscriptionDataTable extends DataTable
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

            ->addColumn('package', function ($subscription) {
                if (!is_null($subscription->package?->id)) {
                    return '<a target="_blank" href="' . route('package.edit', ['id' => $subscription?->package?->id]) . '">' . trimWords($subscription?->package?->name, 30) . '</a>';
                }
                return wrapIt(__('Unknown'), 10, ['columns' => 2]);
            })
            ->editColumn('user', function ($subscription) {
                if (!is_null($subscription->user?->id)) {
                    return '<a target="_blank" href="' . route('users.edit', ['id' => $subscription->user->id]) . '">' . trimWords($subscription->user->name, 20) . '</a>';
                }
                return wrapIt(__('Unknown'), 10, ['columns' => 2]);
            })
            ->editColumn('activation_date', function ($subscription) {
                return timeZoneFormatDate($subscription->activation_date);
            })
            ->editColumn('next_billing_date', function ($subscription) {
                return timeZoneFormatDate($subscription->next_billing_date);
            })->addColumn('billing_cycle', function ($subscription) {
                return ucfirst($subscription->billing_cycle);
            })->editColumn('status', function ($subscription) {
                return statusBadges(lcfirst($subscription->status));
            })->addColumn('action', function ($subscription) {

                $str = '';
                $expired = subscription('isExpired', $subscription->user_id);
                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageSubscriptionController@payment'])) {
                    $str .= '<a title="' . __('Payment') . '" target="blank" href="' . route('package.subscription.payment', ['code' => $subscription->code]) . '" class="action-icon"><i class="feather icon-credit-card"></i></a>&nbsp';
                }
                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageSubscriptionController@notification'])) {
                    $str .= '<a title="' . __('Mail') . '"
                        href="javascript:void(0)"
                        class="action-icon mail-modal"
                        data-bs-toggle="modal"
                        data-bs-target="#mail_modal"
                        data-last-sent-mail="' . ($subscription->last_mail_sent ? formatDate($subscription->last_mail_sent) : __('Never')) . '"
                        data-mail-type="' . ($expired ? __('Expire') : __('Remaining')) . '"
                        data-schedule-dates=' . \json_encode($expired ? subscriptionAlertDates($subscription, 'expire', true) : subscriptionAlertDates($subscription, 'remaining', true)) . '
                        data-schedule-db-dates=' . \json_encode($expired ? subscriptionAlertDates($subscription, 'expire') : subscriptionAlertDates($subscription, 'remaining')) . '
                        id="' . $subscription->id . '">
                        <i class="feather icon-mail"></i></a>&nbsp';
                }
                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageSubscriptionController@edit'])) {
                    $str .= '<a title="' . __('Edit :x', ['x' => __('Subscription')]) . '" href="' . route('package.subscription.edit', ['id' => $subscription->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp';
                }
                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageSubscriptionController@destroy'])) {
                    $str .= '<form method="post" action="' . route('package.subscription.destroy', ['id' => $subscription->id]) . '" id="delete-package-subscription-' . $subscription->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <a title="' . __('Delete :x', ['x' => __('Subscription')]) . '" class="action-icon confirm-delete" data-id=' . $subscription->id . ' data-label="Delete" data-delete="package-subscription" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Subscription')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                }

                return $str;
            })

            ->rawColumns(['code', 'package', 'user', 'activation_date', 'next_billing_date', 'billing_cycle', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $subscriptions = PackageSubscription::select([
            'package_subscriptions.id',
            'package_subscriptions.code',
            'package_subscriptions.user_id',
            'package_subscriptions.package_id',
            'package_subscriptions.activation_date',
            'package_subscriptions.billing_cycle',
            'package_subscriptions.status',
        ])->with('user:id,name', 'package:id,name')->filter();
        return $this->applyScopes($subscriptions);
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
            ->addColumn(['data' => 'code', 'name' => 'code', 'title' => __('Code'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'package', 'name' => 'package.name', 'title' => __('Plan'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'user', 'name' => 'user.name', 'title' => __('Customer'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'activation_date', 'name' => 'activation_date', 'title' => __('Activation Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'next_billing_date', 'name' => 'next_billing_date', 'title' => __('Next Billing'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'billing_cycle', 'name' => 'package_subscriptions.billing_cycle', 'title' => __('Billing Cycle'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle text-center'])

            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%', 'className' => 'align-middle text-right',
                'visible' => $this->hasPermission(['Modules\Subscription\Http\Controllers\PackageSubscriptionController@edit', 'Modules\Subscription\Http\Controllers\PackageSubscriptionController@destroy']),
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
