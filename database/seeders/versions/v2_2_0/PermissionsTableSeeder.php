<?php

namespace Database\Seeders\versions\v2_2_0;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\CustomFieldController@index')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\CustomFieldController@index',
                'controller_path' => 'App\\Http\\Controllers\\Site\\CustomFieldController',
                'controller_name' => 'CustomFieldController',
                'method_name' => 'index',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\CustomFieldController@create')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\CustomFieldController@create',
                'controller_path' => 'App\\Http\\Controllers\\Site\\CustomFieldController',
                'controller_name' => 'CustomFieldController',
                'method_name' => 'create',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\CustomFieldController@store')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\CustomFieldController@store',
                'controller_path' => 'App\\Http\\Controllers\\Site\\CustomFieldController',
                'controller_name' => 'CustomFieldController',
                'method_name' => 'store',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\CustomFieldController@edit')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\CustomFieldController@edit',
                'controller_path' => 'App\\Http\\Controllers\\Site\\CustomFieldController',
                'controller_name' => 'CustomFieldController',
                'method_name' => 'edit',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\CustomFieldController@update')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\CustomFieldController@update',
                'controller_path' => 'App\\Http\\Controllers\\Site\\CustomFieldController',
                'controller_name' => 'CustomFieldController',
                'method_name' => 'update',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\CustomFieldController@destroy')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\CustomFieldController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\Site\\CustomFieldController',
                'controller_name' => 'CustomFieldController',
                'method_name' => 'destroy',
            ]);
        }
    }
}
