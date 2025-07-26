<?php

namespace Modules\Inventory\Database\Seeders\versions\v2_3_0;

use App\Models\Preference;
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
        Preference::updateOrInsert(
            [
                'category' => 'inventory_module',
                'field' => 'order_fulfill',
            ],
            [
                'value' => 'default',
            ]
        );

        $inventoryId = addMenuItem('admin', 'Inventory', [
            'icon' => 'fas fa-table',
            'sort' => 7,
        ]);

        addMenuItem('admin', 'Location', [
            'link' => 'inventory/location',
            'parent' => $inventoryId,
            'sort' => 1,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\LocationController@index","route_name":["location.index", "location.edit", "location.create", "location.store", "location.update", "location.destroy"]}',
        ]);

        addMenuItem('admin', 'Supplier', [
            'link' => 'inventory/supplier',
            'parent' => $inventoryId,
            'sort' => 2,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\SupplierController@index","route_name":["supplier.index", "supplier.edit", "supplier.create", "supplier.store", "supplier.update", "supplier.destroy"]}',
        ]);

        addMenuItem('admin', 'Transaction', [
            'link' => 'inventory/transaction',
            'parent' => $inventoryId,
            'sort' => 7,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\InventoryController@transaction","route_name":["inventory.transaction"]}',
        ]);

        addMenuItem('admin', 'Purchase Order', [
            'link' => 'inventory/purchase-order',
            'parent' => $inventoryId,
            'sort' => 4,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\PurchaseController@index","route_name":["purchase.index", "purchase.edit", "purchase.create", "purchase.store", "purchase.update", "purchase.destroy", "purchase.receive"]}',
        ]);

        addMenuItem('admin', 'Stock', [
            'link' => 'inventory',
            'parent' => $inventoryId,
            'sort' => 5,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\InventoryController@index","route_name":["inventory.index", "inventory.adjust"]}',
        ]);

        addMenuItem('admin', 'Transfer', [
            'link' => 'inventory/transfer',
            'parent' => $inventoryId,
            'sort' => 6,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\TransferController@transfer","route_name":["transfer.index", "transfer.create", "transfer.edit", "transfer.receive"]}',
        ]);

        addMenuItem('admin', 'Settings', [
            'link' => 'inventory/settings',
            'parent' => $inventoryId,
            'sort' => 8,
            'params' => '{"permission":"Modules\\\\Inventory\\\\Http\\\\Controllers\\\\InventoryController@settings","route_name":["inventory.settings"]}',
        ]);
        MenuItems::where('label', 'Inventory')->update(['label' => '{"en":"Inventory","bn":"মজুদ","fr":"Inventaire","zh":"库存","ar":"المخزون","be":"Сток","bg":"Наличност","ca":"Inventari","et":"Varu","nl":"Voorraad"}']);
        MenuItems::where('label', 'Location')->update(['label' => '{"en":"Location","bn":"অবস্থান","fr":"Emplacement","zh":"位置","ar":"الموقع","be":"Месцазнаходжанне","bg":"Местоположение","ca":"Ubicació","et":"Asukoht","nl":"Locatie"}']);
        MenuItems::where('label', 'Supplier')->update(['label' => '{"en":"Supplier","bn":"সরবরাহকারী","fr":"Fournisseur","zh":"供应商","ar":"المورد","be":"Пастаўшчык","bg":"Доставчик","ca":"Proveïdor","et":"Tarnija","nl":"Leverancier"}']);
        MenuItems::where('label', 'Transaction')->update(['label' => '{"en":"Transaction","bn":"লেনদেন","fr":"Transaction","zh":"交易","ar":"المعاملة","be":"Трансакцыя","bg":"Транзакция","ca":"Transacció","et":"Tehing","nl":"Transactie"}']);
        MenuItems::where('label', 'Purchase Order')->update(['label' => '{"en":"Purchase Order","bn":"ক্রয় আদেশ","fr":"Bon de commande","zh":"采购订单","ar":"طلب الشراء","be":"Заказ","bg":"Поръчка","ca":"Ordre de compra","et":"Tellimus","nl":"Aankooporder"}']);
        MenuItems::where('label', 'Stock')->update(['label' => '{"en":"Stock","bn":"স্টক","fr":"Stock","zh":"股票","ar":"المخزون","be":"Запас","bg":"Акции","ca":"Estoc","et":"Aksiad","nl":"Voorraad"}']);
        MenuItems::where('label', 'Transfer')->update(['label' => '{"en":"Transfer","bn":"স্থানান্তর","fr":"Transfert","zh":"转账","ar":"تحويل","be":"Перанос","bg":"Трансфер","ca":"Transferència","et":"Ülekanne","nl":"Overdracht"}']);
        MenuItems::where('label', 'Settings')->update(['label' => '{"en":"Settings","bn":"সেটিংস","fr":"Paramètres","zh":"设置","ar":"الإعدادات","be":"Налады","bg":"Настройки","ca":"Configuració","et":"Sätted","nl":"Instellingen"}']);
    }
}
