<?php

namespace Modules\Subscription\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscription\Database\Seeders\versions\v1_7_0\DatabaseSeeder as V17DatabaseSeeder;
use Modules\Subscription\Database\Seeders\versions\v2_0_0\DatabaseSeeder as V200DatabaseSeeder;

class SubscriptionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(V17DatabaseSeeder::class);
        $this->call(V200DatabaseSeeder::class);
    }
}
