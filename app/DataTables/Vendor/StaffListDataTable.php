<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\DataTables\Vendor;

use App\Models\User;
use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;

class StaffListDataTable extends DataTable
{
    /*
    * DataTable Ajax
    *
    * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
    */
    public function ajax(): JsonResponse
    {
        $staffs = $this->query();

        return datatables()
            ->of($staffs)
            ->addColumn('picture', function ($staffs) {
                return '<img src="' . $staffs->fileUrl() . '" alt="' . __('Image') . '" width="50" height="50">';
            })
            ->editColumn('name', function ($staffs) {
                if (strlen($staffs->name) > 30) {
                    return '<span data-bs-toggle="tooltip" title="' . $staffs->name . '">' . trimWords($staffs->name, 30) . '</span>';
                }

                return wrapIt($staffs->name, 10);
            })
            ->editColumn('status', function ($staffs) {
                return statusBadges(lcfirst($staffs->status));
            })
            ->addColumn('role', function ($staffs) {
                $roles = $staffs->roles->map(function ($role) {
                    return '<span class="f-w-600 f-12 text-muted text-uppercase">' . $role->name . '</span>';
                })->toArray();

                return implode(', ', $roles);
            })
            ->addColumn('action', function ($staffs) {
                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\Vendor\StaffController@edit'])) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('vendor.staffs.edit', ['staff' => $staffs->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }
                if ($this->hasPermission(['App\Http\Controllers\Vendor\StaffController@destroy']) && optional($staffs->role())->slug != 'super-admin') {
                    $str .= view('components.backend.datatable.delete-button', [
                        'route' => route('vendor.staffs.destroy', ['staff' => $staffs->id]),
                        'id' => $staffs->id,
                        'method' => 'DELETE',
                    ])->render();
                }

                return $str;
            })
            ->rawColumns(['picture', 'name', 'email', 'role', 'status', 'action'])
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

        $staffs = User::whereHas('roles', function ($query) use ($vendorId) {
            $query->where('type', 'vendor')->where('vendor_id', $vendorId);
        })->filter();

        return $this->applyScopes($staffs);
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
            ->addColumn(['data' => 'picture', 'name' => 'picture', 'title' => __('Picture'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'role', 'name' => 'role', 'title' => __('Role'), 'orderable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'width' => '8%', 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '100',
                'visible' => $this->hasPermission(['App\Http\Controllers\Vendor\StaffController@edit', 'App\Http\Controllers\Vendor\StaffController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
