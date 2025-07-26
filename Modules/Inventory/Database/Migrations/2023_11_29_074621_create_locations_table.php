<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('locations');

        Schema::create('locations', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('shop_id')->index('locations_shop_id_foreign_idx');
            $table->bigInteger('vendor_id')->index('locations_vendor_id_foreign_idx');
            $table->bigInteger('parent_id')->nullable();
            $table->integer('priority')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('address', 45)->nullable();
            $table->string('country', 45)->nullable();
            $table->string('state', 45)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('zip', 45)->nullable();
            $table->string('phone', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('status', 45);
            $table->tinyInteger('is_default')->default('0');
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
        Schema::dropIfExists('locations');
    }
}
