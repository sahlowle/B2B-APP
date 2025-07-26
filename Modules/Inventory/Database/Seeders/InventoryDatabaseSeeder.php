<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Database\Seeders\versions\v2_3_0\DatabaseSeeder as V23DatabaseSeeder;

class InventoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(V23DatabaseSeeder::class);
    }
}
