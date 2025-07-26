<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shipping\Entities\ShippingProvider;

class ShippingProviderController extends Controller
{
    /**
     * Find shipping providers based on the search query.
     *
     * This function retrieves a list of active shipping providers whose names match the search query.
     * The result is limited to 20 providers and includes the provider's ID, name, and image URL.
     *
     * @param  Request  $request  The HTTP request object containing the search query.
     * @return Collection A collection of shipping providers with their ID, name, and image URL.
     */
    public function findShippingProviders(Request $request)
    {
        return ShippingProvider::where('status', 'Active')
            ->whereLike('name', $request->q)
            ->limit(20)
            ->get()
            ->map(function ($provider) {
                return [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'image' => $provider->logoFile(),
                ];
            });
    }

    /**
     * Retrieves a shipping provider by its ID.
     *
     * @param  int  $id  The ID of the shipping provider to retrieve.
     * @return array A response array containing the shipping provider data or an error message.
     *               - 'status' (int): 1 if the shipping provider is found, 0 otherwise.
     *               - 'content' (object): The shipping provider data if found.
     *               - 'track_method' (string): The tracking URL method of the shipping provider if found.
     *               - 'error' (string): An error message if the shipping provider is not found.
     */
    public function shippingProvider($id)
    {
        try {
            $data = ShippingProvider::findOrFail($id);
            $data = ['status' => 1, 'content' => $data, 'track_method' => $data->tracking_url_method];
        } catch (\Throwable $th) {
            $data = ['status' => 0, 'error' =>  __('Provider not found, please check details')];
        }

        return $data;
    }
}
