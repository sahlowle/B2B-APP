<?php

namespace Modules\Subscription\Database\Seeders\versions\v2_0_0;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmailTemplatesTableSeeder::class);
        $this->call(NotificationSettingsTableSeeder::class);
    }
}
