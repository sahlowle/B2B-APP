<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign(['currency_id'])->references(['id'])->on('currencies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['location_id'])->references(['id'])->on('locations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['supplier_id'])->references(['id'])->on('suppliers')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_currency_id_foreign');
            $table->dropForeign('purchases_location_id_foreign');
            $table->dropForeign('purchases_supplier_id_foreign');
            $table->dropForeign('purchases_vendor_id_foreign');
        });
    }
}
