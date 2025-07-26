<?php

namespace Modules\Inventory\Database\Seeders\versions\v2_3_0\vendor;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\InventoryController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\InventoryController@adjust',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'adjust',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\InventoryController@transaction',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'transaction',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController@vendorLocation',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'vendorLocation',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@search',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'search',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@findSupplier',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'findSupplier',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@findLocation',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'findLocation',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@findVendor',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'findVendor',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@receive',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'receive',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController@receiveStore',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'receiveStore',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);




        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@search',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'search',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@receive',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'receive',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController@receiveStore',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\Vendor\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'receiveStore',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);
    }
}
