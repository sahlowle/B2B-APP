<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use Illuminate\Database\Seeder;
use App\Traits\SeederTrait;
use Modules\Subscription\Entities\PackageSubscription;
class PackageSubscriptionsTableSeeder extends Seeder
{

    use SeederTrait;

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        PackageSubscription::updateOrInsert([
            'code' => '0QUIWAUF35'
        ], [
            'code' => '0QUIWAUF35',
            'user_id' => $this->getData('App\Models\User'),
            'package_id' => $this->getData('Modules\Subscription\Entities\Package'),
            'activation_date' => offsetDate(-7),
            'billing_date' => offsetDate(-7),
            'next_billing_date' => offsetDate(23),
            'billing_price' => '49.99000000',
            'billing_cycle' => 'monthly',
            'amount_billed' => '49.99000000',
            'amount_received' => '49.99000000',
            'amount_due' => '0.00000000',
            'is_customized' => 0,
            'renewable' => 1,
            'payment_status' => 'Paid',
            'status' => 'Active'
        ]);

        PackageSubscription::updateOrInsert([
            'code' => '2T0TW8CJLR'
        ], [
            'code' => '2T0TW8CJLR',
            'user_id' => $this->getData('App\Models\User'),
            'package_id' => $this->getData('Modules\Subscription\Entities\Package'),
            'activation_date' => offsetDate(-5),
            'billing_date' => offsetDate(-5),
            'next_billing_date' => offsetDate(25),
            'billing_price' => '129.00000000',
            'billing_cycle' => 'monthly',
            'amount_billed' => '129.00000000',
            'amount_received' => '129.00000000',
            'amount_due' => '0.00000000',
            'is_customized' => 0,
            'renewable' => 1,
            'payment_status' => 'Paid',
            'status' => 'Active'
        ]);

        PackageSubscription::updateOrInsert([
            'code' => 'DNQFLN6FWX'
        ], [
            'code' => 'DNQFLN6FWX',
            'user_id' => $this->getData('App\Models\User'),
            'package_id' => $this->getData('Modules\Subscription\Entities\Package'),
            'activation_date' => offsetDate(-2),
            'billing_date' => offsetDate(-2),
            'next_billing_date' => offsetDate(28),
            'billing_price' => '19.99000000',
            'billing_cycle' => 'monthly',
            'amount_billed' => '19.99000000',
            'amount_received' => '19.99000000',
            'amount_due' => '0.00000000',
            'is_customized' => 0,
            'renewable' => 1,
            'payment_status' => 'Paid',
            'status' => 'Active'
        ]);
    }
}
