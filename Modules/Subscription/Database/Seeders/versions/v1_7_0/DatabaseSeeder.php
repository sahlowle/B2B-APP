<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

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

        if (config('martvill.is_demo')) {
            $this->call(PackagesTableSeeder::class);
            $this->call(PackagesMetaTableSeeder::class);
            $this->call(PackageSubscriptionsTableSeeder::class);
            $this->call(PackageSubscriptionsMetaTableSeeder::class);
            $this->call(SubscriptionDetailsTableSeeder::class);
        }

        $this->call(EmailTemplatesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PreferencesTableSeeder::class);
    }
}
