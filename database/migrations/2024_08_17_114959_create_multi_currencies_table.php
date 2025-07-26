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
        Schema::create('multi_currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('currency_id')->unique()->index('multicurrencies_currency_id_foreign_idx');
            $table->decimal('exchange_rate', 16, 8)->nullable();
            $table->decimal('exchange_fee', 16, 8)->nullable();
            $table->integer('allow_decimal_number')->nullable();
            $table->string('custom_symbol', 45)->nullable();
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
        Schema::dropIfExists('multi_currencies');
    }
};
