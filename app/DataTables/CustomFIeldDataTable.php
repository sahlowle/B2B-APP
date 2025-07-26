<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-02-2024
 */

namespace App\DataTables;

use App\Models\{
    CustomField
};
use Illuminate\Http\JsonResponse;

class CustomFIeldDataTable extends DataTable
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
        $customField = $this->query();

        return datatables()
            ->of($customField)

            ->editColumn('name', function ($customField) {
                return '<a href="' . route('custom_fields.edit', ['id' => $customField->id]) . '">' . wrapIt($customField->name, 10, ['columns' => 2, 'trim' => true, 'trimLength' => 20]) . '</a>';
            })->editColumn('field_to', function ($customField) {
                return ucfirst($customField->field_to);
            })->editColumn('type', function ($customField) {
                return ucfirst($customField->type);
            })->editColumn('created_at', function ($customField) {
                return $customField->format_created_at;
            })->editColumn('status', function ($customField) {
                return statusBadges(lcfirst($customField->status ? __('Active') : __('Inactive')));
            })->addColumn('action', function ($customField) {
                $str = '';
                if (auth()->user()?->hasPermission('App\Http\Controllers\CustomFieldController@edit')) {
                    $str .= '<a data-bs-toggle="tooltip" title="' . __('Edit') . '" href="' . route('custom_fields.edit', ['id' => $customField->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';
                }
                if (auth()->user()?->hasPermission('App\Http\Controllers\CustomFieldController@destroy')) {
                    $str .= '<form method="post" action="' . route('custom_fields.destroy', ['id' => $customField->id]) . '" id="delete-custom-field-' . $customField->id . '" accept-charset="UTF-8" class="display_inline">
                    ' . method_field('DELETE') . '
                    ' . csrf_field() . '
                    <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $customField->id . ' data-delete="custom-field" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Custom Field')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                    <i class="feather icon-trash"></i>
                    </a>
                    </form>';
                }

                return $str;
            })

            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $customFields = CustomField::query()->filter();

        return $this->applyScopes($customFields);
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
            ->addColumn(['data' => 'field_to', 'name' => 'field_to', 'title' => __('Field Belong To')])
            ->addColumn(['data' => 'type', 'name' => 'type', 'title' => __('Type')])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created')])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'width' => '5%'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '',
                'visible' => auth()->user()?->hasAnyPermission(['App\Http\Controllers\CustomFieldController@edit', 'App\Http\Controllers\CustomFieldController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle', 'width' => '10%',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }

    public function setViewData()
    {
        $statusLabels = [
            0 => 'Inactive',
            1 => 'Active',
        ];

        $statusCounts = $this->query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $transformedStatusCounts = $statusCounts->mapWithKeys(function ($count, $status) use ($statusLabels) {
            return [$statusLabels[$status] => $count];
        });

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $transformedStatusCounts->toArray();
    }
}
