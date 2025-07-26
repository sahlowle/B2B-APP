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
        Schema::table('transfer_details', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['transfer_id'])->references(['id'])->on('transfers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_details', function (Blueprint $table) {
            $table->dropForeign('transfer_details_product_id_foreign');
            $table->dropForeign('transfer_details_transfer_id_foreign');
        });
    }
};
