<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-08-2021
 *
 * @modified 04-10-2021
 */

namespace App\DataTables;

use App\Models\{
    Vendor
};
use Illuminate\Http\JsonResponse;

class VendorListDataTable extends DataTable
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
        $vendors = $this->query();

        return datatables()
            ->of($vendors)
            ->addColumn('logo', function ($vendors) {
                return '<img class="rounded" src="' . (optional($vendors->logo)->fileUrl() ?? $vendors->fileUrl()) . '" alt="' . __('image') . '" width="40" height="40">';
            })->editColumn('name', function ($vendors) {
                $html = '<a href="' . route('vendors.edit', ['id' => $vendors->id]) . '">' . wrapIt($vendors->name, 10) . '</a>';
                $html .= '<span class="d-block text-muted info-meta"><span>' . $vendors->email . '</span>';

                return $html;
            })->editColumn('phone', function ($vendors) {
                return wrapIt($vendors->phone, 15, ['columns' => 4]);
            })->editColumn('user', function ($vendors) {
                $html = '';
                foreach ($vendors->userList as $user) {
                    $html .= '<a href="' . route('users.edit', ['id' => $user->id]) . '">' . wrapIt($user->name, 10, ['columns' => 4]) . ' </a>';
                }

                return $html;
            })->editColumn('status', function ($vendors) {
                return statusBadges(lcfirst($vendors->status));
            })->addColumn('action', function ($vendors) {
                $str = '';
                if (auth()->user()?->hasPermission('App\Http\Controllers\VendorController@edit')) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('vendors.edit', ['id' => $vendors->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }
                if (auth()->user()?->hasPermission('App\Http\Controllers\VendorController@destroy')) {
                    $str .= view('components.backend.datatable.delete-button', [
                        'route' => route('vendors.destroy', ['id' => $vendors->id]),
                        'id' => $vendors->id,
                    ])->render();
                }

                return $str;
            })
            ->rawColumns(['logo', 'name', 'email', 'phone', 'status', 'action', 'user'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $vendors = Vendor::select('vendors.id', 'vendors.name', 'vendors.email', 'vendors.phone', 'vendors.created_at', 'vendors.status')
            ->with(['userList' => function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->whereNull('vendor_id');
                });
            }])
            ->filter();

        return $this->applyScopes($vendors);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'vendors.id', 'title' => __('Id'), 'visible' => false])
            ->addColumn(['data' => 'logo', 'name' => 'logo', 'title' => __('Logo'), 'orderable' => false, 'searchable' => false, 'width' => '5%'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Vendor Name'), 'className' => 'align-middle text-left'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'visible' => false])
            ->addColumn(['data' => 'phone', 'name' => 'phone', 'title' => __('Phone'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'user', 'name' => 'userList.name', 'title' => __('Username'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '10%',
                'visible' => auth()->user()?->hasAnyPermission(['App\Http\Controllers\VendorController@edit', 'App\Http\Controllers\VendorController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
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
