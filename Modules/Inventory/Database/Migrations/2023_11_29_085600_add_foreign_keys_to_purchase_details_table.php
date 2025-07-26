<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['purchase_id'])->references(['id'])->on('purchases')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropForeign('purchase_details_product_id_foreign');
            $table->dropForeign('purchase_details_purchase_id_foreign');
        });
    }
}
