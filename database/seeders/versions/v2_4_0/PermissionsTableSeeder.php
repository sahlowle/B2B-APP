<?php

namespace Database\Seeders\versions\v2_4_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\VendorOrderController@customize')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\VendorOrderController@customize',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\VendorOrderController',
                'controller_name' => 'VendorOrderController',
                'method_name' => 'customize',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\VendorOrderController@userAddress')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\VendorOrderController@userAddress',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\VendorOrderController',
                'controller_name' => 'VendorOrderController',
                'method_name' => 'userAddress',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\AddressSettingController@index')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\AddressSettingController@index',
                'controller_path' => 'App\\Http\\Controllers\\AddressSettingController',
                'controller_name' => 'AddressSettingController',
                'method_name' => 'index',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\AddressSettingController@update')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\AddressSettingController@update',
                'controller_path' => 'App\\Http\\Controllers\\AddressSettingController',
                'controller_name' => 'AddressSettingController',
                'method_name' => 'update',
            ]);
        }
    }
}
