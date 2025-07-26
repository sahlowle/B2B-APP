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

use App\Models\{
    EmailTemplate
};
use Illuminate\Http\JsonResponse;

class EmailTemplateListDataTable extends DataTable
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
        $templates = $this->query();

        return datatables()
            ->of($templates)

            ->addColumn('name', function ($templates) {
                return isset($templates->name) ? "<a href='" . route('emailTemplates.edit', ['id' => $templates->id]) . "'>" . $templates->name . '</a>' : '';
            })

            ->addColumn('status', function ($templates) {
                return statusBadges(lcfirst($templates->status));
            })

            ->addColumn('action', function ($templates) {
                $edit = '<a title="' . __('Edit') . '" href="' . route('emailTemplates.edit', ['id' => $templates->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>&nbsp;';

                $str = '';
                if (auth()->user()?->hasPermission('App\Http\Controllers\MailTemplateController@edit')) {
                    $str .= $edit;
                }

                return $str;
            })

            ->rawColumns(['name', 'subject', 'status', 'slug', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $templates = EmailTemplate::getAll()->whereNull('parent_id');

        return $this->applyScopes($templates);
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
            ->addColumn(['data' => 'slug', 'name' => 'slug', 'title' => __('Slug'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'subject', 'name' => 'subject', 'title' => __('Subject'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '8%',
                'visible' => auth()->user()?->hasAnyPermission(['App\Http\Controllers\MailTemplateController@edit', 'App\Http\Controllers\MailTemplateController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
