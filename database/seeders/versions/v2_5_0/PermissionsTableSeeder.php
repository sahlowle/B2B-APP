<?php

namespace Database\Seeders\versions\v2_5_0;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\SsoController@client')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SsoController@client',
                'controller_path' => 'App\\Http\\Controllers\\SsoController',
                'controller_name' => 'SsoController',
                'method_name' => 'client',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\SsoController@deleteClient')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SsoController@deleteClient',
                'controller_path' => 'App\\Http\\Controllers\\SsoController',
                'controller_name' => 'SsoController',
                'method_name' => 'deleteClient',
            ]);
        }
        
        if (! Permission::where('name', 'App\\Http\\Controllers\\ApiKeyController@index')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ApiKeyController@index',
                'controller_path' => 'App\\Http\\Controllers\\ApiKeyController',
                'controller_name' => 'ApiKeyController',
                'method_name' => 'index',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\ApiKeyController@store')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ApiKeyController@store',
                'controller_path' => 'App\\Http\\Controllers\\ApiKeyController',
                'controller_name' => 'ApiKeyController',
                'method_name' => 'store',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\ApiKeyController@update')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ApiKeyController@update',
                'controller_path' => 'App\\Http\\Controllers\\ApiKeyController',
                'controller_name' => 'ApiKeyController',
                'method_name' => 'update',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\ApiKeyController@destroy')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ApiKeyController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\ApiKeyController',
                'controller_name' => 'ApiKeyController',
                'method_name' => 'destroy',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\ApiKeyController@settings')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ApiKeyController@settings',
                'controller_path' => 'App\\Http\\Controllers\\ApiKeyController',
                'controller_name' => 'ApiKeyController',
                'method_name' => 'settings',
            ]);
        }
    }
}
