<?php

namespace Database\Seeders\versions\v3_1_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\DataTableController@status')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\DataTableController@status',
                'controller_path' => 'App\\Http\\Controllers\\DataTableController',
                'controller_name' => 'DataTableController',
                'method_name' => 'status',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\UserController@findUser')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\UserController@findUser',
                'controller_path' => 'App\\Http\\Controllers\\UserController',
                'controller_name' => 'UserController',
                'method_name' => 'findUser',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        } else {
            $permissionId = Permission::where('name', 'App\\Http\\Controllers\\UserController@findUser')->first()->id;

            if (! PermissionRole::where('permission_id', $permissionId)->where('role_id', 2)->first()) {
                PermissionRole::insert([
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ]);
            }
        }
    }
}
