<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_subscriptions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 65);
            $table->integer('user_id')->nullable()->index();
            $table->integer('package_id')->nullable()->index();

            $table->date('activation_date');
            $table->date('billing_date')->nullable();
            $table->date('next_billing_date')->nullable();
            $table->decimal('billing_price', 16, 8)->default(0);
            $table->string('billing_cycle', 45)->nullable();

            $table->decimal('amount_billed', 16, 8)->default(0);
            $table->decimal('amount_received', 16, 8)->default(0);
            $table->decimal('amount_due', 16, 8)->default(0);

            $table->boolean('is_customized')->default(0)->index();
            $table->boolean('renewable')->default(0)->index();

            $table->string('payment_status', 45)->index()->comment('Paid / Unpaid / Partial');
            $table->string('status', 45)->index()->comment('Pending / Active / Inactive/ Expired / Paused');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_subscriptions');
    }
}
