<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_6_0;

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
        addMenuItem('admin', 'Themes', [
            'parent' => 'Website Setup',
            'link' => 'themes',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\ThemeController@index","route_name":["themes.index"]}',
            'sort' => 48,
        ]);

        MenuItems::where('label', 'Themes')->update(['label' => '{"en":"Themes","bn":"থিমস","fr":"Thèmes","zh":"主题","ar":"ثيمات","be":"Тэмы","bg":"Теми","ca":"Temes","et":"Teemad","nl":"Thema\'s"}']);
    }
}
