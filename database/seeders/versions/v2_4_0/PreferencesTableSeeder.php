<?php

namespace Database\Seeders\versions\v2_4_0;

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
        Preference::updateOrInsert(
            [
                'category' => 'preference',
                'field' => 'db_version',
            ],
            [
                'value' => '2.4.0',
            ]
        );

        Preference::updateOrInsert(
            [
                'category' => 'preference',
                'field' => 'auth_settings',
            ],
            [
                'value' => '{"template-1":{"required":[],"data":[]},"template-2":{"required":["title","description","file"],"data":{"title":"Login to Martvill","description":"Experience shopping made easy. Log in now to access exclusive offers, manage orders, and discover your personalized shopping experience. Your one-stop destination for convenience and savings starts here.","file":"image.jpg"}},"template-3":{"required":["file"],"data":{"file":"image.jpg"}},"template-4":{"required":["file"],"data":{"file":"image.png"}},"template-5":{"required":["file"],"data":{"file":"image.jpg"}},"template-6":{"required":[],"data":[]}}',
            ]
        );

        Preference::updateOrInsert(
            [
                'category' => 'shipping_setting',
                'field' => 'shipping_provider',
            ],
            [
                'value' => '1',
            ]
        );

        Preference::updateOrInsert(
            [
                'category' => 'shipping_setting',
                'field' => 'product_label_wise_shipment_track',
            ],
            [
                'value' => '0',
            ]
        );

        Preference::updateOrInsert(
            [
                'category' => 'shipping_setting',
                'field' => 'vendor_assign_shipping_provider',
            ],
            [
                'value' => '0',
            ]
        );
    }
}
