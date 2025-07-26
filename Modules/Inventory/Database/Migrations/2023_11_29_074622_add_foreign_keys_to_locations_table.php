<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign(['shop_id'])->references(['id'])->on('shops')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['vendor_id'])->references(['id'])->on('vendors')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_shop_id_foreign');
            $table->dropForeign('locations_vendor_id_foreign');
        });
    }
}
