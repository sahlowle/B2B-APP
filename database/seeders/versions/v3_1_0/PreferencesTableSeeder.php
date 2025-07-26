<?php

namespace Database\Seeders\versions\v3_1_0;

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
        $dbPreference = Preference::where(['field' => 'buy_now'])->first();

        if (! $dbPreference) {
            Preference::insert([
                'category' => 'preference',
                'field' => 'buy_now',
                'value' => 1,
            ]);
        }

        Preference::updateOrInsert(
            [
                'category' => 'preference',
                'field' => 'db_version',
            ],
            [
                'value' => '3.1.0',
            ]
        );

        
    }
}
