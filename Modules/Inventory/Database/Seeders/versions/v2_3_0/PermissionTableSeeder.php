<?php

namespace Modules\Inventory\Database\Seeders\versions\v2_3_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $inventoryController = Permission::where('controller_name', 'InventoryController');
        $locationController = Permission::where('controller_name', 'LocationController');
        $purchaseController = Permission::where('controller_name', 'PurchaseController');
        $supplierController = Permission::where('controller_name', 'SupplierController');
        $transferController = Permission::where('controller_name', 'TransferController');

        if ($inventoryController->exists()) {
            $inventoryController->delete();
        }

        if ($locationController->exists()) {
            $locationController->delete();
        }

        if ($purchaseController->exists()) {
            $purchaseController->delete();
        }

        if ($supplierController->exists()) {
            $supplierController->delete();
        }

        if ($transferController->exists()) {
            $transferController->delete();
        }

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController@adjust',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'adjust',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController@settings',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'settings',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController@transaction',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\InventoryController',
            'controller_name' => 'InventoryController',
            'method_name' => 'transaction',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\LocationController@vendorLocation',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\LocationController',
            'controller_name' => 'LocationController',
            'method_name' => 'vendorLocation',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@search',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'search',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@findSupplier',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'findSupplier',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@findLocation',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'findLocation',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@findVendor',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'findVendor',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@receive',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'receive',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController@receiveStore',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\PurchaseController',
            'controller_name' => 'PurchaseController',
            'method_name' => 'receiveStore',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\SupplierController',
            'controller_name' => 'SupplierController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@index',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'index',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@create',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'create',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@store',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'store',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@search',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'search',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@edit',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'edit',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@update',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'update',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@destroy',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'destroy',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@receive',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'receive',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'Modules\\Inventory\\Http\\Controllers\\TransferController@receiveStore',
            'controller_path' => 'Modules\\Inventory\\Http\\Controllers\\TransferController',
            'controller_name' => 'TransferController',
            'method_name' => 'receiveStore',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 1,
        ]);
    }
}
