<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\Location;

class LocationListDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     *
    @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        $locations = $this->query();

        return datatables()
            ->of($locations)
            ->editColumn('name', function ($locations) {
                return '<a href="' . route('location.edit', ['id' => $locations->id]) . '">' . wrapIt($locations->name, 10, ['columns' => 5]) . '</a>';
            })->editColumn('email', function ($locations) {
                return wrapIt($locations->email, 20, ['columns' => 5]);
            })->editColumn('phone', function ($locations) {
                return wrapIt($locations->phone, 15, ['columns' => 5]);
            })->editColumn('address', function ($locations) {
                return wrapIt($locations->fullAddress(), 20, ['columns' => 5]);
            })->editColumn('vendor', function ($locations) {
                return wrapIt(optional($locations->vendor)->name, 20, ['columns' => 5]);
            })->editColumn('status', function ($locations) {
                return statusBadges(lcfirst($locations->status));
            })->editColumn('default', function ($locations) {
                return statusBadges($locations->is_default == 1 ? __('Yes') : __('No'));
            })->addColumn('action', function ($locations) {
                $str = '';

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\LocationController@edit')) {
                    $str = '<a title="' . __('Edit') . '" href="' . route('location.edit', ['id' => $locations->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }

                $hasNoTerminal = isActive('Pos') ? $locations->terminals()->count() === 0 : true;
                $canDelete = auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\LocationController@destroy');
                $hasNoStock = $locations->stockManagement()->sum('quantity') == 0;
                $isNotDefault = $locations->is_default == 0;

                if ($canDelete && $hasNoStock && $isNotDefault && $hasNoTerminal) {
                    $str .= '<form method="post" action="' . route('location.destroy', ['id' => $locations->id]) . '" id="delete-location-' . $locations->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $locations->id . ' data-delete="location" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Location')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </button>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['name', 'email', 'phone', 'address', 'status', 'action', 'vendor', 'default'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $locations = Location::select('id', 'shop_id', 'vendor_id', 'parent_id', 'name', 'slug', 'country', 'state', 'city', 'zip', 'phone', 'address', 'email', 'status', 'is_default')->with('shop:id,name,vendor_id', 'shop.vendor', 'parent:id,name', 'vendor:id,name')->filter();

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
            ->addColumn(['data' => 'vendor', 'name' => 'vendor_id', 'title' => __('Vendor'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'address', 'name' => 'address', 'title' => __('Address'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'default', 'name' => 'is_default', 'title' => __('Default'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'className' => 'text-right align-middle',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Inventory\Http\Controllers\LocationController@edit', 'Modules\Inventory\Http\Controllers\LocationController@destroy']),
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
