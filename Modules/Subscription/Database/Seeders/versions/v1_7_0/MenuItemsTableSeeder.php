<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use Google\Service\CloudSearch\MenuItem;
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
        $menu = MenuItems::where(['label' => 'Subscriptions', 'menu' => 1])->first();

        if (!$menu) {
            $menuId = MenuItems::insertGetId([
                'label' => 'Subscriptions',
                'link' => NULL,
                'params' => NULL,
                'is_default' => 1,
                'icon' => 'fas fa-money-bill-alt',
                'parent' => 0,
                'sort' => 24,
                'class' => NULL,
                'menu' => 1,
                'depth' => 0
            ]);

            MenuItems::insert([
                ['label' => 'Plans', 'link' => 'packages', 'params' => '{"permission":"Modules\\\\Subscription\\\\Http\\\\Controllers\\\\PackageController@index", "route_name":["package.index", "package.create", "package.show", "package.edit", "package.generate.link.index"], "menu_level":"1"}', 'is_default' => 1, 'icon' => NULL, 'parent' => $menuId, 'sort' => 10, 'class' => NULL, 'menu' => 1, 'depth' => 1,],
                ['label' => 'Members', 'link' => 'package/subscriptions', 'params' => '{"permission":"Modules\\\\Subscription\\\\Http\\\\Controllers\\\\SubscriptionController@index", "route_name":["package.subscription.index", "package.subscription.create", "package.subscription.show", "package.subscription.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => NULL, 'parent' => $menuId, 'sort' => 12, 'class' => NULL, 'menu' => 1, 'depth' => 1,],
                ['label' => 'Payments', 'link' => 'payments', 'params' => '{"permission":"Modules\\\\Subscription\\\\Http\\\\Controllers\\\\SubscriptionController@payment", "route_name":["package.subscription.payment", "package.subscription.invoice"], "menu_level":"1"}', 'is_default' => 1, 'icon' => NULL, 'parent' => $menuId, 'sort' => 13, 'class' => NULL, 'menu' => 1, 'depth' => 1,],
                ['label' => 'Settings', 'link' => 'subscriptions/settings', 'params' => '{"permission":"Modules\\\\Subscription\\\\Http\\\\Controllers\\\\SubscriptionController@setting", "route_name":["package.subscription.setting"], "menu_level":"1"}', 'is_default' => 1, 'icon' => NULL, 'parent' => $menuId, 'sort' => 13, 'class' => NULL, 'menu' => 1, 'depth' => 1,],

                // Vendor Panel
                ['label' => 'Subscriptions', 'link' => 'subscription', 'params' => '{"permission":"Modules\\\\Subscription\\\\Http\\\\Controllers\\\\Vendor\\\\SubscriptionController@index","route_name":["vendor.subscription.index", "vendor.subscription.store", "vendor.subscription.paid", "vendor.subscription.history", "vendor.subscription.invoice"]}', 'is_default' => 1, 'icon' => 'fas fa-money-bill-alt', 'parent' => 0, 'sort' => 4, 'class' => NULL, 'menu' => 3, 'depth' => 0],
            ]);
        }
    }
}
