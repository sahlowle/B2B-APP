<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_managements', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('location_id')->index('stock_managements_location_id_foreign_idx');
            $table->unsignedBigInteger('product_id')->index('stock_managements_product_id_foreign_idx');
            $table->decimal('quantity', 16, 8);
            $table->string('type');
            $table->date('date');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('stock_managements');
    }
}
