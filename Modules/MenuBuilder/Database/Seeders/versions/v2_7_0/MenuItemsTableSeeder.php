<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_7_0;

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
        addMenuItem('admin', 'Currencies', [
            'parent' => 'Configurations',
            'link' => 'settings/currency',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\CurrencySettingsController@index","route_name":["settings.currency.index"]}',
            'sort' => 52,
        ]);

        MenuItems::where('label', 'Currencies')->update(['label' => '{ "en": "Currencies", "bn": "মুদ্রা", "fr": "Devises", "zh": "货币", "ar": "العملات", "be": "Валюты", "bg": "Валути", "ca": "Monedes", "et": "Valuutad", "nl": "Valuta\'s" }']);
    }
}
