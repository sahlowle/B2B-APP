<?php

namespace Modules\Refund\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Refund\Database\Seeders\versions\v2_5_0\DatabaseSeeder as V25DatabaseSeeder;

class RefundDatabaseSeeder extends Seeder
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
        $this->call(RefundReasonsTableSeeder::class);
        $this->call(V25DatabaseSeeder::class);
    }
}
