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
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('transfer_id')->index('transfer_details_transfer_id_foreign_idx');
            $table->unsignedBigInteger('product_id')->index('transfer_details_product_id_foreign_idx');
            $table->decimal('quantity', 16, 8)->default(0);
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
        Schema::dropIfExists('transfer_details');
    }
};
