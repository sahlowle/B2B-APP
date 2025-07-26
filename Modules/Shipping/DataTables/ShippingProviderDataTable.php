<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 29-12-2021
 */

namespace Modules\Shipping\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Shipping\Entities\ShippingProvider;

class ShippingProviderDataTable extends DataTable
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
        $provider = $this->query();

        return datatables()
            ->of($provider)

            ->editColumn('name', function ($provider) {
                return wrapIt(ucfirst($provider->name), 30);
            })->addColumn('logo', function ($provider) {
                return '<img class="rounded" src="' . $provider->logoFile('small') . '" alt="' . __('logo') . '" width="40" height="40">';
            })->addColumn('country', function ($provider) {
                return wrapIt(ucfirst(optional($provider->country)->name), 30);
            })->editColumn('status', function ($provider) {
                return statusBadges(lcfirst($provider->status));
            })->addColumn('action', function ($provider) {
                $edit = '<a title="' . __('Edit :x', ['x' => __('Provider')]) . '" href="javascript:void(0) "
                class="edit_provider action-icon" 
                data-bs-toggle="modal" data-bs-target="#edit-provider" 
                data-id="' . $provider->id . '" 
                data-name="' . $provider->name . '" 
                data-country_id="' . $provider->country_id . '" 
                data-tracking_base_url="' . $provider->tracking_base_url . '" 
                data-tracking_url_method="' . $provider->tracking_url_method . '" 
                data-status="' . $provider->status . '"
                data-logo_url="' . $provider->logoFile() . '"
                data-file_id="' . optional($provider->objectFile)->file_id . '"
                >
                <i class="feather icon-edit-1"></i>
                </a>&nbsp';

                $delete = '<a title="' . __('Delete :x', ['x' => __('Provider')]) . '" 
                href="javascript:void(0)" 
                data-action_url="' . route('shipping.removeProvider', $provider->id) . '" 
                class="delete_provider action-icon" data-bs-toggle="modal" data-bs-target="#delete-provider">
                <i class="feather icon-trash"></i>
                </a>';

                $str = '';

                if (auth()->user()?->hasPermission('Modules\Shipping\Http\Controllers\ShippingController@updateProvider')) {
                    $str .= $edit;
                }

                if (auth()->user()?->hasPermission('Modules\Shipping\Http\Controllers\ShippingController@removeProvider')) {
                    $str .= $delete;
                }

                return $str;
            })
            ->rawColumns(['logo', 'status', 'action'])
            ->filter(function ($instance) {
                if (request('status') && (request('status') == 'Active' || request('status') == 'Inactive')) {
                    $instance->where('status', request('status'));
                }
                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->Where('name', 'like', '%' . $keyword . '%');
                        });
                    }
                }

                if (request('country')) {
                    $country = request('country');
                    $instance->where(function ($query) use ($country) {
                        $query->Where('country_id', $country);
                    });
                }
            })
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $provider = ShippingProvider::getAllShippingProvider();

        return $this->applyScopes($provider);
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
            ->addColumn(['data' => 'logo', 'name' => 'logo', 'title' => __('Logo'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'country', 'name' => 'country', 'title' => __('Country'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '',
                'visible' => auth()->user()?->hasAnyPermission(['Modules\Shipping\Http\Controllers\ShippingController@updateProvider', 'Modules\Shipping\Http\Controllers\ShippingController@removeProvider']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
