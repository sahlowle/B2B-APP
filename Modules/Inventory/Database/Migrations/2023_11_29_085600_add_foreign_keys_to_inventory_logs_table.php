<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->foreign(['currency_id'])->references(['id'])->on('currencies')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['location_id'])->references(['id'])->on('locations')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['supplier_id'])->references(['id'])->on('suppliers')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['purchase_id'])->references(['id'])->on('purchases')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['purchase_detail_id'])->references(['id'])->on('purchase_details')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['stock_management_id'])->references(['id'])->on('stock_managements')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['order_id'])->references(['id'])->on('orders')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['transfer_id'])->references(['id'])->on('transfers')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->dropForeign('inventory_logs_currency_id_foreign');
            $table->dropForeign('inventory_logs_location_id_foreign');
            $table->dropForeign('inventory_logs_product_id_foreign');
            $table->dropForeign('inventory_logs_supplier_id_foreign');
            $table->dropForeign('inventory_logs_purchase_id_foreign');
            $table->dropForeign('inventory_logs_purchase_detail_id_foreign');
            $table->dropForeign('inventory_logs_stock_management_id_foreign');
            $table->dropForeign('inventory_logs_order_id_foreign');
            $table->dropForeign('inventory_logs_transfer_id_foreign');
        });
    }
}
