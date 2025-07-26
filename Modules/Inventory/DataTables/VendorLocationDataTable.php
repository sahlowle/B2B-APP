<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\Location;

class VendorLocationDataTable extends DataTable
{
    /*
   * DataTable Ajax
   *
   * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
   */
    public function ajax(): JsonResponse
    {
        $locations = $this->query();

        return datatables()
            ->of($locations)
            ->editColumn('name', function ($locations) {
                return '<a href="' . route('vendor.location.edit', ['id' => $locations->id]) . '">' . wrapIt($locations->name, 10, ['columns' => 4]) . '</a>';
            })->editColumn('email', function ($locations) {
                return wrapIt($locations->email, 20, ['columns' => 4]);
            })->editColumn('phone', function ($locations) {
                return wrapIt($locations->phone, 15, ['columns' => 4]);
            })->editColumn('address', function ($locations) {
                return wrapIt($locations->fullAddress(), 20, ['columns' => 4]);
            })->editColumn('status', function ($locations) {
                return statusBadges(lcfirst($locations->status));
            })->editColumn('default', function ($locations) {
                return statusBadges($locations->is_default == 1 ? __('Yes') : __('No'));
            })->addColumn('action', function ($locations) {
                $str = '';

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\LocationController@edit')) {
                    $str = '<a title="' . __('Edit') . '" href="' . route('vendor.location.edit', ['id' => $locations->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }

                $canDelete = auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\LocationController@destroy');
                $hasNoStock = $locations->stockManagement()->sum('quantity') == 0;
                $isNotDefault = $locations->is_default == 0;
                $hasNoTerminal = isActive('Pos') ? $locations->terminals()->count() === 0 : true;
                if ($canDelete && $hasNoStock && $isNotDefault && $hasNoTerminal) {
                    $str .= '<form method="post" action="' . route('vendor.location.destroy', ['id' => $locations->id]) . '" id="delete-location-' . $locations->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $locations->id . ' data-delete="location" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Location')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </button>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['name', 'email', 'phone', 'address', 'status', 'action', 'default'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $locations = Location::select('id', 'shop_id', 'vendor_id', 'parent_id', 'name', 'slug', 'country', 'state', 'city', 'zip', 'phone', 'address', 'email', 'status', 'is_default')->where('vendor_id', auth()->user()->vendor()->vendor_id)->with('shop:id,name,vendor_id', 'shop.vendor', 'parent:id,name', 'vendor:id,name')->filter();

        return $this->applyScopes($locations);
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
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Location Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'phone', 'name' => 'phone', 'title' => __('Phone'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'address', 'name' => 'address', 'title' => __('Address'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'default', 'name' => 'is_default', 'title' => __('Default'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'className' => 'text-right align-middle',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Inventory\Http\Controllers\Vendor\LocationController@edit', 'Modules\Inventory\Http\Controllers\Vendor\LocationController@destroy']),
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
