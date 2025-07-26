<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('reference');
            $table->bigInteger('vendor_id')->index('transfers_vendor_id_foreign_idx');
            $table->bigInteger('from_location_id')->index('transfers_form_location_id_foreign_idx');
            $table->bigInteger('to_location_id')->index('transfers_to_location_id_foreign_idx');
            $table->decimal('quantity', 16, 8);
            $table->string('shipping_carrier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->date('arrival_date')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
