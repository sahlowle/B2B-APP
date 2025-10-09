<?php

/**
 * @package PackageDataTable
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 20-02-2023
 */

namespace Modules\Subscription\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Modules\Subscription\Entities\Package;

class PackageDataTable extends DataTable
{
    /*
    * DataTable Ajax
    *
    * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
    */
    public function ajax(): JsonResponse
    {
        $package = $this->query();
        return DataTables::eloquent($package)

            ->editColumn('user', function ($package) {
                if (!is_null($package->user?->id)) {
                    return '<a target="_blank" href="' . route('users.edit', ['id' => $package->user->id]) . '">' . trimWords($package->user->name, 25) . '</a>';
                }
                return wrapIt(__('Guest'), 25);
            })
            ->editColumn('name', function ($package) {
                return trimWords($package->name, 30);
            })
            ->editColumn('is_private', function ($package) {
                return $package->is_private ? __('No') : __('Yes');
            })->editColumn('sale_price', function ($package) {
                $price = '<div>';
                foreach ($package->sale_price as $key => $value) {
                    if ($package->billing_cycle[$key]) {
                        $price .=  formatNumber($value) . "<br>";
                    }
                }
                $price .= '</div>';
                return $price;
            })
            ->editColumn('discount_price', function ($package) {
                $price = '<div>';
                foreach ($package->discount_price as $key => $value) {
                    if ($package->billing_cycle[$key]) {
                        $price .= ($value ? formatNumber($value) : __('Unavailable')) . "<br>";
                    }
                }
                $price .= '</div>';
                return $price;
            })->editColumn('billing_cycle', function ($package) {
                $cycle = '<div>';
                foreach ($package->billing_cycle as $key => $value) {
                    if ($value) {
                        $cycle .= ucfirst($key) . "<br>";
                    }
                }
                $cycle .= '</div>';
                return $cycle;
            })->editColumn('status', function ($package) {
                return statusBadges(lcfirst($package->status));
            })->addColumn('action', function ($package) {
                $str = '';
                if ($package->is_private) {
                    $str = '<a data-bs-toggle="tooltip" title="' . __('Link Generate') . '"
                        href="' . route('package.generate.link.index', ['id' => $package->id]) . '"
                        class="action-icon pr-5">
                        <i class="feather icon-link-2"></i></a>&nbsp';
                }

                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageController@edit'])) {
                    $str .= '<a data-bs-toggle="tooltip" title="' . __('Edit :x', ['x' => __('Plan')]) . '" href="' . route('package.edit', ['id' => $package->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp';
                }
                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageController@destroy'])) {
                    $str .= '<form method="post" action="' . route('package.destroy', ['id' => $package->id]) . '" id="delete-package-' . $package->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <a title="' . __('Delete :x', ['x' => __('Plan')]) . '" class="action-icon confirm-delete" type="button" data-id=' . $package->id . ' data-label="Delete" data-delete="package" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Plan')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                }
                return $str;
            })

            ->rawColumns(['name', 'is_private', 'user', 'sale_price', 'discount_price', 'billing_cycle', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $packages = Package::with('user')->filter();
        return $this->applyScopes($packages);
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
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'user', 'name' => 'user.name', 'title' => __('Author'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'is_private', 'name' => 'is_private', 'title' => __('Is Visible?'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'sale_price', 'name' => 'sale_price', 'title' => __('Sale Price'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'discount_price', 'name' => 'discount_price', 'title' => __('Discount Price')])
            ->addColumn(['data' => 'billing_cycle', 'name' => 'billing_cycle', 'title' => __('Billing Cycle')])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle text-center'])

            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '8%',
                'visible' => $this->hasPermission(['Modules\Subscription\Http\Controllers\PackageController@edit', 'Modules\Subscription\Http\Controllers\PackageController@show', 'Modules\Subscription\Http\Controllers\PackageController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'
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
