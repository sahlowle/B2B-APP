<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 20-05-2021
 *
 * @modified 30-05-2022
 */

namespace App\DataTables;

use App\Models\{
    User
};
use App\Services\CustomFieldService;
use Illuminate\Http\JsonResponse;

class UserListDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     */
    public function ajax(): JsonResponse
    {
        $users = $this->query();

        $dt = datatables()
            ->of($users)
            ->addColumn('picture', function ($users) {
                return '<img class="rounded" src="' . $users->fileUrl() . '" alt="' . __('image') . '" width="40" height="40">';
            })
            ->editColumn('name', function ($users) {
                $html = '<a href="' . route('users.edit', ['id' => $users->id]) . '">' . wrapIt($users->name, 10) . '</a>';
                $html .= '<span class="d-block text-muted info-meta"><span>' . $users->email . '</span>';

                return $html;
            })
            ->editColumn('status', function ($users) {
                return statusBadges(lcfirst($users->status));
            })
            ->addColumn('role', function ($users) {
                $roles = $users->roles->map(function ($role) {   
                    $roleName = ($role->vendor_id) ? 'Vendor Staff' : $role->name;
                    return '<span class="f-w-600 f-12 text-muted text-uppercase">' . $roleName . '</span>';
                })->toArray();

                return implode(', ', $roles);
            });

        CustomFieldService::dataTableBody($dt, 'users');

        $dt->editColumn('created_at', function ($users) {
            return $users->format_created_at_only_date . '<br><span class="text-muted">' . $users->format_created_at_only_time . '</span>';
        })
            ->addColumn('action', function ($users) {
                $loginAs = '<a data-bs-toggle="tooltip" title="' . __('Login as') . '" class="action-icon pr-5" href="' . route('impersonator', ['impersonate' => techEncrypt($users->password)]) . '" target="_blank"><i class="feather icon-log-in"></i></a>';

                $edit = '<a data-bs-toggle="tooltip" title="' . __('Edit') . '" href="' . route('users.edit', ['id' => $users->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>';

                $str = '';
                if (auth()->user()?->hasPermission('App\Http\Controllers\UserController@edit')) {
                    $str .= $edit;
                }
                if (auth()->user()?->hasPermission('App\Http\Controllers\UserController@destroy') && optional($users->role())->slug != 'super-admin') {
                    $str .= view('components.backend.datatable.delete-button', [
                        'route' => route('users.destroy', ['id' => $users->id]),
                        'id' => $users->id,
                    ])->render();
                }

                return $loginAs . $str;
            })
            ->rawColumns(['picture', 'name', 'email', 'role', 'status', 'created_at', 'action']);

        return $dt->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $users = User::select('users.*')->with('customFieldValues')->filter();

        return $this->applyScopes($users);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        $builder = $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false])
            ->addColumn(['data' => 'picture', 'name' => 'picture', 'title' => __('Picture'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-left', 'width' => '5%'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'visible' => false])
            ->addColumn(['data' => 'role', 'name' => 'role', 'title' => __('Role'), 'className' => 'align-middle']);

        CustomFieldService::dataTableHeader($builder, 'users');

        $builder->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Registered'), 'className' => 'align-middle', 'width' => '11%'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'visible' => auth()->user()?->hasAnyPermission(['App\Http\Controllers\UserController@edit', 'App\Http\Controllers\UserController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));

        return $builder;
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
