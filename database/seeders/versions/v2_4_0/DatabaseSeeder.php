<?php

namespace Database\Seeders\versions\v2_4_0;

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
            PermissionsTableSeeder::class,
            OrderStatusesTableSeeder::class,
            PreferencesTableSeeder::class,
            EmailTemplatesTableSeeder::class,
        ]);
    }
}
