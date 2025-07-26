<?php

namespace Modules\MenuBuilder\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\MenuBuilder\Database\Seeders\versions\{
    v1_1_0\DatabaseSeeder as V11DatabaseSeeder,
    v1_7_0\DatabaseSeeder as V17DatabaseSeeder,
    v2_0_0\DatabaseSeeder as V20DatabaseSeeder,
    v2_1_0\DatabaseSeeder as V21DatabaseSeeder,
    v2_2_0\DatabaseSeeder as V22DatabaseSeeder,
    v2_4_0\DatabaseSeeder as V24DatabaseSeeder,
    v2_5_0\DatabaseSeeder as V25DatabaseSeeder,
    v2_6_0\DatabaseSeeder as V26DatabaseSeeder,
    v2_7_0\DatabaseSeeder as V27DatabaseSeeder,
    v2_9_0\DatabaseSeeder as V29DatabaseSeeder,
};

class MenuBuilderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(MenusTableSeeder::class);
        $this->call(MenuItemsTableWithoutDummyDataSeeder::class);
        $this->call(AdminMenusTableSeeder::class);
        $this->call(V11DatabaseSeeder::class);
        $this->call(V17DatabaseSeeder::class);
        $this->call(V20DatabaseSeeder::class);
        $this->call(V21DatabaseSeeder::class);
        $this->call(V22DatabaseSeeder::class);
        $this->call(V24DatabaseSeeder::class);
        $this->call(V25DatabaseSeeder::class);
        $this->call(V26DatabaseSeeder::class);
        $this->call(V27DatabaseSeeder::class);
        $this->call(V29DatabaseSeeder::class);
    }
}
