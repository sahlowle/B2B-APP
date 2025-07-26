<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 02-11-2023
 */

namespace App\DataTables\Vendor;

use App\Models\Role;
use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;

class RoleListDataTable extends DataTable
{
    /*
    * DataTable Ajax
    *
    * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
    */
    public function ajax(): JsonResponse
    {
        $roles = $this->query();

        return datatables()
            ->of($roles)
            ->addColumn('name', function ($roles) {
                return wrapIt($roles->name, 20, ['columns' => 2]);
            })
            ->addColumn('description', function ($roles) {
                return wrapIt($roles->description, 30, ['columns' => 2]);
            })
            ->addColumn('action', function ($roles) {
                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\Vendor\RoleController@edit'])) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('vendor.roles.edit', ['role' => $roles?->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }
                if ($this->hasPermission(['App\Http\Controllers\Vendor\RoleController@destroy']) && ! in_array($roles->slug, defaultRoles())) {
                    $str .= view('components.backend.datatable.delete-button', [
                        'route' => route('vendor.roles.destroy', ['role' => $roles?->id]),
                        'id' => $roles->id,
                        'method' => 'DELETE',
                    ])->render();
                }

                return $str;
            })

            ->rawColumns(['name', 'description', 'type', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $vendorId = session('vendorId') ?: auth()->user()->vendor()->vendor_id;

        $roles = Role::where('vendor_id', $vendorId);

        return $this->applyScopes($roles);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => __('Description'), 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '20%',
                'visible' => $this->hasPermission(['App\Http\Controllers\Vendor\RoleController@edit', 'App\Http\Controllers\Vendor\RoleController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
