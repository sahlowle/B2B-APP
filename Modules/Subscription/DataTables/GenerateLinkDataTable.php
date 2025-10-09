<?php

/**
 * @package GenerateLinkDataTable
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 10-10-2023
 */

namespace Modules\Subscription\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Modules\Subscription\Entities\PackageMeta;

class GenerateLinkDataTable extends DataTable
{
    /*
    * DataTable Ajax
    *
    * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
    */
    public function ajax(): JsonResponse
    {
        $meta = $this->query();
        return DataTables::collection($meta)
            ->addColumn('email', function ($meta) {
                return wrapIt($meta['email'], 10, ['columns' => 2]);
            })
            ->editColumn('link', function ($meta) {
                return wrapIt($meta['link'], 78, ['columns' => 2]);
            })->addColumn('action', function ($meta) {
                $str = '<a href="javascript:void(0)" title="' . __('Copy Link') . '" class="copy-link-btn action-icon" data-link="' . $meta['link'] . '"><i class="feather icon-copy"></i></a>';

                if ($this->hasPermission(['Modules\Subscription\Http\Controllers\PackageController@destroyLink'])) {
                    $str .= '<form method="post" action="' . route('package.destroy.link', ['id' => $meta['id']]) . '" id="delete-package-meta-' . $meta['id'] . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        ' . method_field('delete') . '
                        <a title="' . __('Delete :x', ['x' => __('Link')]) . '" class="action-icon confirm-delete" data-id=' . $meta['id'] . ' data-label="Delete" data-delete="package-meta" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Link')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['email', 'link', 'action'])
            ->make(true);
    }
    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $metas = PackageMeta::where('package_id', $this->id)->whereBeginsWith('key', 'generate_link')
            ->orderBy('id', 'DESC')->get();

        $data = [];

        foreach ($metas as $key => $meta) {
            $decrypt = json_decode(techDecrypt($meta->value), true);
            $email = isset($decrypt['email']) ? $decrypt['email'] : __('Anyone');
            $data[] = ['id' => $meta->id, 'email' => $email, 'link' => route('vendor.private-plan', $meta->value)];
        }

        return $this->applyScopes(collect($data));
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
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'link', 'name' => 'link', 'title' => __('Link'), 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '10%',
                'visible' => true,
                'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-right'
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
