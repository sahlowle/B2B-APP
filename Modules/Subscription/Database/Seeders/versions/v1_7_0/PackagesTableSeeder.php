<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use Illuminate\Database\Seeder;
use Modules\Subscription\Entities\Package;

class PackagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Package::updateOrInsert([
            'code' => 'p-starter'
        ], [
            'user_id' => 1,
            'name' => 'Starter Plan',
            'code' => 'p-starter',
            'short_description' => NULL,
            'sale_price' => '{"lifetime":0,"yearly":89.99,"monthly":9.99,"weekly":0,"days":0}',
            'discount_price' => '{"lifetime":0,"yearly":79.99,"monthly":null,"weekly":null,"days":null}',
            'billing_cycle' => '{"lifetime":0,"yearly":"1","monthly":"1","weekly":"0","days":"0"}',
            'sort_order' => 2,
            'trial_day' => 3,
            'usage_limit' => NULL,
            'renewable' => 1,
            'status' => 'Active'
        ]);

        Package::updateOrInsert([
            'code' => 'p-premium'
        ], [
            'user_id' => 1,
            'name' => 'Premium Plan',
            'code' => 'p-premium',
            'short_description' => NULL,
            'sale_price' => '{"lifetime":0,"yearly":139.99,"monthly":14.99,"weekly":0,"days":0}',
            'discount_price' => '{"lifetime":0,"yearly":129.99,"monthly":12.99,"weekly":null,"days":null}',
            'billing_cycle' => '{"lifetime":0,"yearly":"1","monthly":"1","weekly":"0","days":"0"}',
            'sort_order' => 2,
            'trial_day' => 7,
            'usage_limit' => NULL,
            'renewable' => 1,
            'status' => 'Active'
        ]);

        Package::updateOrInsert([
            'code' => 'p-platinum'
        ], [
            'user_id' => 1,
            'name' => 'Platinum Plan',
            'code' => 'p-platinum',
            'short_description' => NULL,
            'sale_price' => '{"lifetime":0,"yearly":190.99,"monthly":19.99,"weekly":0,"days":0}',
            'discount_price' => '{"lifetime":0,"yearly":null,"monthly":null,"weekly":null,"days":null}',
            'billing_cycle' => '{"lifetime":0,"yearly":"1","monthly":"1","weekly":"0","days":"0"}',
            'sort_order' => 3,
            'trial_day' => 15,
            'usage_limit' => NULL,
            'renewable' => 1,
            'status' => 'Active'
        ]);

        Package::updateOrInsert([
            'code' => 'p-free'
        ], [
            'user_id' => 1,
            'name' => 'Free Plan',
            'code' => 'p-free',
            'short_description' => NULL,
            'sale_price' => '{"lifetime":0,"yearly":0,"monthly":0,"weekly":0,"days":0}',
            'discount_price' => '{"lifetime":0,"yearly":null,"monthly":null,"weekly":null,"days":null}',
            'billing_cycle' => '{"lifetime":0,"yearly":"0","monthly":"1","weekly":"0","days":"0"}',
            'sort_order' => 1,
            'trial_day' => NULL,
            'usage_limit' => NULL,
            'renewable' => 0,
            'status' => 'Active'
        ]);
    }
}
