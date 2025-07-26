<?php

namespace Modules\Refund\Database\Seeders\versions\v2_5_0;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenuItemsTableSeeder::class,
        ]);
    }
}
