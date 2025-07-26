<?php

namespace Modules\Newsletter\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('menu_items')->upsert([
            ['id' => 84, 'label' => 'All Subscribers', 'link' => 'subscribers', 'params' => '{"permission":"Modules\\\\Newsletter\\\\Http\\\\Controllers\\\\SubscriberController@index","route_name":["subscriber.index","subscriber.edit","subscriber.update","subscriber.pdf","subscriber.csv"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 32, 'class' => null, 'menu' => 1, 'depth' => 1],
        ], 'id');

        MenuItems::where('label', 'All Subscribers')->update(['label' => '{"en":"All Subscribers","bn":"সমস্ত গ্রাহক","fr":"Tous les abonnés","zh":"所有订阅者","ar":"جميع المشتركين","be":"Усе падпісчыкі","bg":"Всички абонати","ca":"Tots els subscriptors","et":"Kõik tellijad","nl":"Alle abonnees"}']);
    }
}
