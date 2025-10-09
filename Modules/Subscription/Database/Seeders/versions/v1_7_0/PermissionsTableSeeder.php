<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@index',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@index',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'index',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@create',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@create',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'create',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@store',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@store',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'store',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@show',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@show',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'show',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@edit',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@edit',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'edit',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@update',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@update',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'update',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@destroy',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@destroy',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'destroy',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@getTemplate',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@getTemplate',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
            'controller_name' => 'PackageController',
            'method_name' => 'getTemplate',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@index',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@index',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'index',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@create',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@create',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'create',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@store',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@store',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'store',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@show',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@show',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'show',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@edit',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@edit',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'edit',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@update',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@update',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'update',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@destroy',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@destroy',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'destroy',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@setting',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@setting',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'setting',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@payment',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@payment',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'payment',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoice',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoice',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'invoice',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoicePdf',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoicePdf',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'invoicePdf',
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoiceEmail',
        ], [
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoiceEmail',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'controller_name' => 'PackageSubscriptionController',
            'method_name' => 'invoiceEmail',
        ]);

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@index'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@index',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@store'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@store',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@paid'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@paid',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'paid',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@history'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@history',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'history',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@invoice'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@invoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'invoice',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@pdfInvoice'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@pdfInvoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'pdfInvoice',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@cancel'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@cancel',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'cancel'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        Permission::updateOrInsert([
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@generateLink'
        ], [
            'controller_name' => 'generateLink',
            'controller_path' => 'Modules\Subscription\Http\Controllers\PackageController',
            'method_name' => 'PackageController',
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@generateLink'
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@getGenerateLink',
        ], [
            'controller_name' => 'getGenerateLink',
            'controller_path' => 'Modules\Subscription\Http\Controllers\PackageController',
            'method_name' => 'PackageController',
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@getGenerateLink'
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@generateLinkIndex',
        ], [
            'controller_name' => 'generateLinkIndex',
            'controller_path' => 'Modules\Subscription\Http\Controllers\PackageController',
            'method_name' => 'PackageController',
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@generateLinkIndex'
        ]);

        Permission::updateOrInsert([
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@destroyLink',
        ], [
            'controller_name' => 'destroyLink',
            'controller_path' => 'Modules\Subscription\Http\Controllers\PackageController',
            'method_name' => 'PackageController',
            'name' => 'Modules\Subscription\Http\Controllers\PackageController@destroyLink',
        ]);

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@index'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@index',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@store'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@store',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@cancel'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@cancel',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'cancel'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@paid'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@paid',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'paid'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@history'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@history',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'history'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@invoice'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@invoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'invoice'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@pdfInvoice'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@pdfInvoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'pdfInvoice'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@privatePlan'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@privatePlan',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'privatePlan'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $permission = Permission::where(['name' =>'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@isValidPrivatePlan'])->first();
        if (!$permission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@isValidPrivatePlan',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'isValidPrivatePlan'
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        Permission::updateOrInsert([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@notification',
        ], [
            'controller_name' => 'PackageSubscriptionController',
            'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
            'method_name' => 'notification',
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@notification'
        ]);
    }
}
