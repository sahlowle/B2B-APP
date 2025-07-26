<?php

namespace Modules\GeoLocale\Database\Seeders;

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
            [
                'id' => 49,
                'label' => 'Geo Locale',
                'link' => 'geolocale',
                'params' => '{"permission":"Modules\\\\GeoLocale\\\\Http\\\\Controllers\\\\GeoLocaleController@index", "route_name":["geolocale.index"], "menu_lavel":"1"}',
                'is_default' => 1,
                'icon' => null,
                'parent' => 31,
                'sort' => 58,
                'class' => null,
                'menu' => 1,
                'depth' => 1,
                'is_custom_menu' => 0,
            ],
        ], 'id');

        MenuItems::where('label', 'Geo Locale')->update(['label' => '{"en":"Geo Locale","bn":"জিও লোকেল","fr":"Géo Localisation","zh":"地理位置","ar":"الموقع الجغرافي","be":"Геалакаль","bg":"Гео локация","ca":"Geolocalització","et":"Geo lokaalne","nl":"Geo-locatie"}']);
    }
}
