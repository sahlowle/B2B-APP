<?php

namespace Modules\Inventory\Database\Seeders\versions\v2_3_0\vendor;

use Illuminate\Database\Seeder;
use Modules\MenuBuilder\Http\Models\MenuItems;

class MenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $inventoryId = addMenuItem('vendor', 'Inventory', [
            'icon' => 'fas fa-table',
            'sort' => 2,
        ]);
        
        addMenuItem('vendor', 'Location', [
            'link' => 'inventory/location',
            'parent' => $inventoryId,
            'sort' => 2,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\Vendor\\\\LocationController@index","route_name":["vendor.location.index", "vendor.location.edit", "vendor.location.create", "vendor.location.store", "vendor.location.update", "vendor.location.destroy"]}',
        ]);
        
        addMenuItem('vendor', 'Supplier', [
            'link' => 'inventory/supplier',
            'parent' => $inventoryId,
            'sort' => 2,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\Vendor\\\\SupplierController@index","route_name":["vendor.supplier.index", "vendor.supplier.edit", "vendor.supplier.create", "vendor.supplier.store", "vendor.supplier.update", "vendor.supplier.destroy"]}',
        ]);
        
        addMenuItem('vendor', 'Transaction', [
            'link' => 'inventory/transaction',
            'parent' => $inventoryId,
            'sort' => 7,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\Vendor\\\\InventoryController@transaction","route_name":["vendor.inventory.transaction"]}',
        ]);
        
        addMenuItem('vendor', 'Purchase Order', [
            'link' => 'inventory/purchase-order',
            'parent' => $inventoryId,
            'sort' => 4,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\Vendor\\\\PurchaseController@index","route_name":["vendor.purchase.index", "vendor.purchase.edit", "vendor.purchase.create", "vendor.purchase.store", "vendor.purchase.update", "vendor.purchase.destroy", "vendor.purchase.receive"]}',
        ]);
        
        addMenuItem('vendor', 'Stock', [
            'link' => 'inventory',
            'parent' => $inventoryId,
            'sort' => 5,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\Vendor\\\\InventoryController@index","route_name":["vendor.inventory.index", "vendor.inventory.adjust"]}',
        ]);
        
        addMenuItem('vendor', 'Transfer', [
            'link' => 'inventory/transfer',
            'parent' => $inventoryId,
            'sort' => 6,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\Vendor\\\\TransferController@index","route_name":["vendor.transfer.index", "vendor.transfer.create", "vendor.transfer.edit", "vendor.transfer.receive"]}',
        ]);
    }
}
