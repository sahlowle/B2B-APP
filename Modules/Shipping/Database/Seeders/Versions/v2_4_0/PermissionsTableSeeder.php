<?php

namespace Modules\Shipping\Database\Seeders\Versions\v2_4_0;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'Modules\\Shipping\\Http\\Controllers\\ShippingController@updateProvider')->first()) {
            Permission::insert([
                'name' => 'Modules\\Shipping\\Http\\Controllers\\ShippingController@updateProvider',
                'controller_path' => 'Modules\\Shipping\\Http\\Controllers\\ShippingController',
                'controller_name' => 'ShippingController',
                'method_name' => 'updateProvider',
            ]);
        }

        if (! Permission::where('name', 'Modules\\Shipping\\Http\\Controllers\\ShippingController@removeProvider')->first()) {
            Permission::insert([
                'name' => 'Modules\\Shipping\\Http\\Controllers\\ShippingController@removeProvider',
                'controller_path' => 'Modules\\Shipping\\Http\\Controllers\\ShippingController',
                'controller_name' => 'ShippingController',
                'method_name' => 'removeProvider',
            ]);
        }

    }
}
