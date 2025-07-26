<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('purchase_id')->index('purchase_details_purchase_id_foreign_idx');
            $table->unsignedBigInteger('product_id')->index('purchase_details_product_id_foreign_idx');
            $table->string('product_name');
            $table->decimal('quantity', 16, 8);
            $table->decimal('amount', 16, 8);
            $table->string('sku', 45)->nullable();
            $table->decimal('tax_charge', 16, 8)->nullable();
            $table->decimal('quantity_receive', 16, 8)->default(0);
            $table->decimal('quantity_reject', 16, 8)->default(0);
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
        Schema::dropIfExists('purchase_details');
    }
}
