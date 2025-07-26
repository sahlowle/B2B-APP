<?php

namespace Modules\Inventory\Database\Seeders\versions\v2_3_0;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(AdminMenusTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(\Modules\Inventory\Database\Seeders\versions\v2_3_0\vendor\MenuItemsTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(\Modules\Inventory\Database\Seeders\versions\v2_3_0\vendor\PermissionTableSeeder::class);
    }
}
