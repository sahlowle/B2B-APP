<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('location_id')->nullable()->index('inventory_logs_location_id_foreign_idx');
            $table->bigInteger('purchase_id')->nullable()->index('inventory_logs_purchase_id_foreign_idx');
            $table->unsignedBigInteger('product_id')->nullable()->index('inventory_logs_product_id_foreign_idx');
            $table->integer('supplier_id')->nullable()->index('inventory_logs_supplier_id_foreign_idx');
            $table->unsignedInteger('currency_id')->nullable()->index('inventory_logs_currency_id_foreign_idx');
            $table->bigInteger('purchase_detail_id')->nullable()->index('inventory_logs_purchase_detail_id_foreign_idx');
            $table->bigInteger('stock_management_id')->nullable()->index('inventory_logs_stock_management_id_foreign_idx');
            $table->unsignedBigInteger('order_id')->nullable()->index('inventory_logs_order_id_foreign_idx');
            $table->integer('transfer_id')->nullable()->index('inventory_logs_transfer_id_foreign_idx');
            $table->decimal('quantity', 16, 8)->nullable();
            $table->string('transaction_type', 45);
            $table->decimal('price', 16, 8)->nullable();
            $table->date('transaction_date');
            $table->text('note')->nullable();
            $table->string('log_type', 45);
            $table->timestamp('created_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('inventory_logs');
    }
}
