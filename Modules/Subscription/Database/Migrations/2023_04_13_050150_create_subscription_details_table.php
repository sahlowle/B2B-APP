<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_details', function (Blueprint $table) {
            $table->id();
            $table->string('code', 65);
            $table->string('unique_code')->unique()->nullable()->index();
            $table->integer('user_id')->nullable()->index();
            $table->integer('package_id')->nullable()->index();
            $table->integer('package_subscription_id')->nullable()->index();

            $table->date('activation_date');
            $table->date('billing_date')->nullable();
            $table->date('next_billing_date')->nullable();
            $table->decimal('billing_price', 16, 8)->default(0);
            $table->string('billing_cycle', 45)->nullable();

            $table->decimal('amount_billed', 16, 8)->default(0);
            $table->decimal('amount_received', 16, 8)->default(0);

            $table->string('payment_method', 45)->nullable();
            $table->string('features', 1000)->nullable();
            $table->string('duration', 5)->nullable();
            $table->string('currency', 5)->nullable();

            $table->boolean('is_trial')->default(0);

            $table->boolean('renewable')->default(0)->index();

            $table->string('payment_status', 45)->index()->comment('Paid / Unpaid');
            $table->string('status', 45)->index()->comment('Pending / Active / Inactive/ Expired / Paused');

            $table->timestamps();
        });
        
        \DB::statement('ALTER TABLE subscription_details AUTO_INCREMENT = 5000000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_details');
    }
}
