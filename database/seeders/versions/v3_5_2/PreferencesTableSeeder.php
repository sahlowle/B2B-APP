<?php

namespace Database\Seeders\versions\v3_5_2;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Preference::updateOrInsert(
            [
                'category' => 'preference',
                'field' => 'db_version',
            ],
            [
                'value' => '3.5.2',
            ]
        );
    }
}
