<?php

namespace Modules\Shipping\Database\Seeders\Versions\v2_4_0;

use Illuminate\Database\Seeder;
use Modules\Shipping\Entities\ShippingProvider;

class ShippingProvidersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $shippingProviders = [
            [
                'name' => 'Australia Post',
                'slug' => 'australia-post',
                'country_id' => 15,
                'tracking_base_url' => 'https://auspost.com.au/mypost/track/details/%number%',
                'tracking_url_method' => 'Get',
                'status' => 'Active',
            ],
            [
                'name' => 'CouriersPlease',
                'slug' => 'couriersplease',
                'country_id' => 15,
                'tracking_base_url' => 'https://www.couriersplease.com.au/tools-track?no=%number%',
                'tracking_url_method' => 'Get',
                'status' => 'Active',
            ],
            [
                'name' => 'Dai Post',
                'slug' => 'dai-post',
                'country_id' => 15,
                'tracking_base_url' => 'https://daiglobaltrack.com/tracking.aspx?custtracknbr=%number%',
                'tracking_url_method' => 'Get',
                'status' => 'Active',
            ],
        ];

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($shippingProviders as $provider) {
            ShippingProvider::firstOrCreate(['slug' => $provider['slug']], $provider);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
