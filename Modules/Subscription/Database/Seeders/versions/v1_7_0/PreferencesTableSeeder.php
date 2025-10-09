<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Preference::insertOrIgnore([
            [
                'category' => 'subscription',
                'field' => 'subscription_downgrade',
                'value' => '1',
            ], [
                'category' => 'subscription',
                'field' => 'subscription_change_plan',
                'value' => '1',
            ], [
                'category' => 'subscription',
                'field' => 'subscription_restriction_message',
                'value' => 'Please check you plan details',
            ], [
                'category' => 'subscription',
                'field' => 'subscription_renewal',
                'value' => 'manual',
            ],
        ]);
    }
}
