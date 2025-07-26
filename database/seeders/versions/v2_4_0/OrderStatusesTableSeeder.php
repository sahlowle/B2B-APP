<?php

namespace Database\Seeders\versions\v2_4_0;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    public function run()
    {
        if (! OrderStatus::where('slug', 'draft')->first()) {
            OrderStatus::insert([
                'name' => 'Draft',
                'slug' => 'draft',
                'payment_scenario' => 'unpaid',
                'color' => '#000000',
                'is_default' => '0',
                'order_by' => '9',
            ]);
        }
    }
}
