<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('reference')->nullable();
            $table->bigInteger('location_id')->index('purchases_location_id_foreign_idx');
            $table->integer('supplier_id')->index('purchases_supplier_id_foreign_idx');
            $table->unsignedInteger('currency_id')->index('purchases_currency_id_idx');
            $table->bigInteger('vendor_id')->index('purchases_vendor_id_foreign_idx');
            $table->decimal('exchange_rate', 16, 8)->nullable();
            $table->decimal('shipping_charge', 16, 8)->nullable();
            $table->string('payment_type', 45)->nullable();
            $table->decimal('tax_charge', 16, 8)->nullable();
            $table->string('shipping_carrier')->nullable();
            $table->string('tracking_number', 45)->nullable();
            $table->text('note')->nullable();
            $table->date('arrival_date')->nullable();
            $table->text('adjustment')->nullable();
            $table->decimal('total_quantity', 16, 8);
            $table->decimal('total_amount', 16, 8);
            $table->decimal('paid_amount', 16, 8)->nullable();
            $table->string('status', 45);
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
        Schema::dropIfExists('purchases');
    }
}
