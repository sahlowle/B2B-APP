<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-05-2021
 *
 * @modified 04-10-2021
 */

namespace App\DataTables;

use App\Models\{Role, RoleUser};
use Illuminate\Http\JsonResponse;

class RoleListDataTable extends DataTable
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
        $roles = $this->query();

        return datatables()
            ->of($roles)

            ->addColumn('created_at', function ($roles) {
                return $roles->format_created_at;
            })
            ->addColumn('name', function ($roles) {
                return wrapIt($roles->name, 20, ['columns' => 2]);
            })
            ->addColumn('description', function ($roles) {
                return wrapIt($roles->description, 30, ['columns' => 2]);
            })

            ->addColumn('action', function ($roles) {
                $str = '';
                if (auth()->user()?->hasPermission('App\Http\Controllers\RoleController@edit')) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('roles.edit', ['id' => $roles->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }

                if (auth()->user()?->hasPermission('App\Http\Controllers\RoleController@destroy') && ! in_array($roles->slug, defaultRoles()) && ! RoleUser::where('role_id', $roles->id)->exists()) {
                    $str .= view('components.backend.datatable.delete-button', [
                        'route' => route('roles.destroy', ['id' => $roles->id]),
                        'id' => $roles->id,
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
        $roles = Role::whereNull('vendor_id');

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
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name')])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => __('Description')])
            ->addColumn(['data' => 'type', 'name' => 'type', 'title' => __('Type')])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created at')])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '5%',
                'visible' => auth()->user()?->hasAnyPermission(['App\Http\Controllers\RoleController@edit', 'App\Http\Controllers\RoleController@destroy']),
                'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }
}
