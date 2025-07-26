<?php

namespace Modules\Inventory\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Inventory\Entities\Supplier;

class VendorSupplierDataTable extends DataTable
{
    /*
   * DataTable Ajax
   *
   * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
   */
    public function ajax(): JsonResponse
    {
        $suppliers = $this->query();

        return datatables()
            ->of($suppliers)
            ->editColumn('name', function ($suppliers) {
                return '<a href="' . route('vendor.supplier.edit', ['id' => $suppliers->id]) . '">' . wrapIt($suppliers->name, 10, ['columns' => 4]) . '</a>';
            })->editColumn('email', function ($suppliers) {
                return wrapIt($suppliers->email, 20, ['columns' => 4]);
            })->editColumn('phone', function ($suppliers) {
                return wrapIt($suppliers->phone, 15, ['columns' => 4]);
            })->editColumn('address', function ($suppliers) {
                return wrapIt($suppliers->fullAddress(), 20, ['columns' => 4]);
            })->editColumn('status', function ($suppliers) {
                return statusBadges(lcfirst($suppliers->status));
            })->editColumn('company_name', function ($suppliers) {
                return $suppliers->company_name;
            })->addColumn('action', function ($suppliers) {
                $str = '';

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\SupplierController@edit')) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('vendor.supplier.edit', ['id' => $suppliers->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }

                if (auth()->user()?->hasPermission('Modules\Inventory\Http\Controllers\Vendor\SupplierController@destroy')) {
                    $str .= '<form method="post" action="' . route('vendor.supplier.destroy', ['id' => $suppliers->id]) . '" id="delete-supplier-' . $suppliers->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $suppliers->id . ' data-delete="supplier" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Supplier')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </button>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['name', 'email', 'phone', 'address', 'status', 'action', 'company_name'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $suppliers = Supplier::select('id', 'vendor_id', 'name', 'company_name', 'address', 'country', 'state', 'city', 'zip', 'phone', 'email', 'status')->where('vendor_id', auth()->user()->vendor()->vendor_id)->with('vendor')->filter();

        return $this->applyScopes($suppliers);
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
            ->addColumn(['data' => 'company_name', 'name' => 'company_name', 'title' => __('Company Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'phone', 'name' => 'phone', 'title' => __('Phone'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'address', 'name' => 'address', 'title' => __('Address'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'className' => 'text-right align-middle',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Inventory\Http\Controllers\Vendor\SupplierController@edit', 'Modules\Inventory\Http\Controllers\Vendor\SupplierController@destroy']),
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
