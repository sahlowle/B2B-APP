<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use Illuminate\Database\Seeder;

use Modules\Subscription\Entities\{
    PackageSubscription,
    SubscriptionDetails
};

class SubscriptionDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $subscription = PackageSubscription::where(['code' => '0QUIWAUF35'])->first();
        if ($subscription) {
            SubscriptionDetails::updateOrInsert([
                'unique_code' => '5353171636469eb74409fa9.63050883'
            ], [
                'code' => '0QUIWAUF35',
                'unique_code' => '5353171636469eb74409fa9.63050883',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-90),
                'billing_date' => offsetDate(-90),
                'next_billing_date' => offsetDate(-60),
                'billing_price' => '0.00000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '0.00000000',
                'amount_received' => '0.00000000',
                'payment_method' => NULL,
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 0,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '604618966469eb80baf493.17102380'
            ], [
                'code' => '0QUIWAUF35',
                'unique_code' => '604618966469eb80baf493.17102380',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-60),
                'billing_date' => offsetDate(-60),
                'next_billing_date' => offsetDate(-30),
                'billing_price' => '19.99000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '19.99000000',
                'amount_received' => '0.00000000',
                'payment_method' => NULL,
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 1,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '1831570236469eb8a89f516.94193648'
            ], [
                'code' => '0QUIWAUF35',
                'unique_code' => '1831570236469eb8a89f516.94193648',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-30),
                'billing_date' => offsetDate(-30),
                'next_billing_date' => offsetDate(0),
                'billing_price' => '49.99000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '49.99000000',
                'amount_received' => '0.00000000',
                'payment_method' => NULL,
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 1,
                'renewable' => 0,
                'payment_status' => 'Paid',
                    'status' => 'Active'
            ]);

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '19321741516469eb93e956b9.38974678'
            ], [
                'code' => '0QUIWAUF35',
                'unique_code' => '19321741516469eb93e956b9.38974678',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-7),
                'billing_date' => offsetDate(-7),
                'next_billing_date' => offsetDate(23),
                'billing_price' => '49.99000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '49.99000000',
                'amount_received' => '49.99000000',
                'payment_method' => 'Stripe',
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 0,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);
        }

        $subscription = PackageSubscription::where(['code' => '2T0TW8CJLR'])->first();
        if ($subscription) {

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '12054123726469ebc4b9fb03.54911868'
            ], [
                'code' => '2T0TW8CJLR',
                'unique_code' => '12054123726469ebc4b9fb03.54911868',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-35),
                'billing_date' => offsetDate(-35),
                'next_billing_date' => offsetDate(-5),
                'billing_price' => '129.00000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '129.00000000',
                'amount_received' => '0.00000000',
                'payment_method' => NULL,
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 1,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '135938626469ebce768475.57702863'
            ], [
                'code' => '2T0TW8CJLR',
                'unique_code' => '135938626469ebce768475.57702863',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-5),
                'billing_date' => offsetDate(-5),
                'next_billing_date' => offsetDate(25),
                'billing_price' => '129.00000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '129.00000000',
                'amount_received' => '129.00000000',
                'payment_method' => 'Stripe',
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 0,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);
        }

        $subscription = PackageSubscription::where(['code' => 'DNQFLN6FWX'])->first();
        if ($subscription) {

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '16229309086469ec3479e3a1.47288751'
            ], [
                'code' => 'DNQFLN6FWX',
                'unique_code' => '16229309086469ec3479e3a1.47288751',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-62),
                'billing_date' => offsetDate(-62),
                'next_billing_date' => offsetDate(-32),
                'billing_price' => '19.99000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '19.99000000',
                'amount_received' => '0.00000000',
                'payment_method' => NULL,
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 1,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '15891132976469ec3da494a8.56873353'
            ], [
                'code' => 'DNQFLN6FWX',
                'unique_code' => '15891132976469ec3da494a8.56873353',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-32),
                'billing_date' => offsetDate(-32),
                'next_billing_date' => offsetDate(-2),
                'billing_price' => '19.99000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '19.99000000',
                'amount_received' => '0.00000000',
                'payment_method' => NULL,
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 0,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Pending'
            ]);

            SubscriptionDetails::updateOrInsert([
                'unique_code' => '17298839576469ec51e0bf73.00531770'
            ], [
                'code' => 'DNQFLN6FWX',
                'unique_code' => '17298839576469ec51e0bf73.00531770',
                'user_id' => $subscription->user_id,
                'package_id' => $subscription->package_id,
                'package_subscription_id' => $subscription->id,
                'activation_date' => offsetDate(-2),
                'billing_date' => offsetDate(-2),
                'next_billing_date' => offsetDate(28),
                'billing_price' => '19.99000000',
                'billing_cycle' => 'monthly',
                'amount_billed' => '19.99000000',
                'amount_received' => '19.99000000',
                'payment_method' => 'Stripe',
                'features' => NULL,
                'duration' => NULL,
                'currency' => 'USD',
                'is_trial' => 0,
                'renewable' => 0,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);
        }

    }
}
