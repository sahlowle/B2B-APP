<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_9_0;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->upsert([
            [
                'name' => 'Staff',
                'slug' => 'vendor-staff',
                'url' => 'staff',
                'permission' => '{"permission":"App\\\\Http\\\\Controllers\\\\Vendor\\\\StaffController@index", "route_name":["vendor.staff.index", "vendor.staff.create", "vendor.staff.edit"]}',
                'is_default' => 1,
            ],

        ], 'slug');
    }
}
