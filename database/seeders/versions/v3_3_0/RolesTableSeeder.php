<?php

namespace Database\Seeders\versions\v3_3_0;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (Role::where('type', 'global')->count() > 0) {
            Role::where('slug', 'super-admin')->update(['type' => 'admin']);
            Role::whereIn('slug', ['customer', 'guest'])->update(['type' => 'customer']);
            Role::where('type', 'global')->update(['type' => 'customer']);
        }
    }
}
