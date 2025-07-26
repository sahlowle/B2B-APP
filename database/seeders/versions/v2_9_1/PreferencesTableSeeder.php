<?php

namespace Database\Seeders\versions\v2_9_1;

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
                'value' => '2.9.1',
            ]
        );
    }
}
