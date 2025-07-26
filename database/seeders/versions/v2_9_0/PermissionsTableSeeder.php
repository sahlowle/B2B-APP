<?php

namespace Database\Seeders\versions\v2_9_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\StaffController@create')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\StaffController@index',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\StaffController',
                'controller_name' => 'StaffController',
                'method_name' => 'index',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\StaffController@create')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\StaffController@create',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\StaffController',
                'controller_name' => 'StaffController',
                'method_name' => 'create',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\StaffController@store')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\StaffController@store',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\StaffController',
                'controller_name' => 'StaffController',
                'method_name' => 'store',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\StaffController@edit')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\StaffController@edit',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\StaffController',
                'controller_name' => 'StaffController',
                'method_name' => 'edit',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\StaffController@update')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\StaffController@update',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\StaffController',
                'controller_name' => 'StaffController',
                'method_name' => 'update',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\StaffController@destroy')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\StaffController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\StaffController',
                'controller_name' => 'StaffController',
                'method_name' => 'destroy',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\RoleController@index')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\RoleController@index',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\RoleController',
                'controller_name' => 'RoleController',
                'method_name' => 'index',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\RoleController@create')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\RoleController@create',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\RoleController',
                'controller_name' => 'RoleController',
                'method_name' => 'create',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\RoleController@store')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\RoleController@store',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\RoleController',
                'controller_name' => 'RoleController',
                'method_name' => 'store',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\RoleController@edit')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\RoleController@edit',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\RoleController',
                'controller_name' => 'RoleController',
                'method_name' => 'edit',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\RoleController@update')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\RoleController@update',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\RoleController',
                'controller_name' => 'RoleController',
                'method_name' => 'update',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\RoleController@destroy')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\RoleController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\RoleController',
                'controller_name' => 'RoleController',
                'method_name' => 'destroy',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\PermissionController@generate')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\PermissionController@generate',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\PermissionController',
                'controller_name' => 'PermissionController',
                'method_name' => 'generate',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\PermissionController@index')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\PermissionController@index',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\PermissionController',
                'controller_name' => 'PermissionController',
                'method_name' => 'index',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\PermissionController@assign')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\PermissionController@assign',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\PermissionController',
                'controller_name' => 'PermissionController',
                'method_name' => 'assign',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
    }
}
