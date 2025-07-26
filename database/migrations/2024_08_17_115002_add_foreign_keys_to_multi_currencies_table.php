<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multi_currencies', function (Blueprint $table) {
            $table->foreign(['currency_id'], 'multicurrencies_currency_id_foreign')->references(['id'])->on('currencies')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multi_currencies', function (Blueprint $table) {
            $table->dropForeign('multicurrencies_currency_id_foreign');
        });
    }
};
