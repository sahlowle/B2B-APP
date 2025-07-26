<?php

namespace Modules\Shipping\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Shipping\Database\Seeders\Versions\v2_4_0\DatabaseSeeder as V24DatabaseSeeder;

class ShippingDatabaseSeeder extends Seeder
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
        $this->call(ShippingClassesWithoutDummyDataTableSeeder::class);
        $this->call(ShippingMethodsTableSeeder::class);
        $this->call(V24DatabaseSeeder::class);
    }
}
