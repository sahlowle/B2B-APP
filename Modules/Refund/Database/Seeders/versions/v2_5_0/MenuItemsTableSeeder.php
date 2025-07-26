<?php

namespace Modules\Refund\Database\Seeders\versions\v2_5_0;

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

        MenuItems::where(['menu' => 2, 'link' => 'refund-request'])->update(['link' => 'refunds']);
    }
}
