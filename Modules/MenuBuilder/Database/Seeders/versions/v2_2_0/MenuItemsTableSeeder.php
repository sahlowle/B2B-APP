<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_2_0;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        addMenuItem('admin', 'Custom Fields', [
            'parent' => 'Configurations',
            'link' => 'custom-fields',
            'sort' => 57,
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\CustomFieldController@index", "route_name":["custom_fields.index", "custom_fields.create", "custom_fields.edit"], "menu_level":"1"}',
        ]);
    }
}
