<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('user_id')->index();
            $table->string('name', 100);
            $table->string('code', 45)->nullable();
            $table->string('short_description')->nullable();
            $table->string('sale_price', 400);
            $table->string('discount_price', 400);
            $table->string('billing_cycle', 400)->comment('Day / Weekly / Monthly / Yearly');
            $table->integer('sort_order')->nullable();
            $table->boolean('is_private')->default(false);
            $table->integer('trial_day')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->boolean('renewable')->nullable()->default(false);
            $table->string('status', 45)->default('Pending')->comment('Active / Inactive / Pending');

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
        Schema::dropIfExists('packages');
    }
}
