<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSubscriptionsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_subscriptions_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_subscription_id')->index('package_subscriptions_meta_package_subscription_id_foreign_idx');
            $table->string('type')->default('null');
            $table->string('key')->index();
            $table->string('value', 10000)->nullable();
            $table->unique(['key', 'package_subscription_id', 'type'], 'subscription_key_id_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_subscriptions_meta');
    }
}
