<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPackageSubscriptionsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_subscriptions_meta', function (Blueprint $table) {
            $table->foreign(['package_subscription_id'])->references(['id'])->on('package_subscriptions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_subscriptions_meta', function (Blueprint $table) {
            $table->dropForeign('package_subscriptions_meta_package_subscription_id_foreign');
        });
    }
}
