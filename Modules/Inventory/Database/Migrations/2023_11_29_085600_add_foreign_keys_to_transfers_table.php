<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign(['from_location_id'], 'transfers_form_location_id_foreign')->references(['id'])->on('locations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['vendor_id'])->references(['id'])->on('vendors')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['to_location_id'])->references(['id'])->on('locations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_form_location_id_foreign');
            $table->dropForeign('transfers_vendor_id_foreign');
            $table->dropForeign('transfers_to_location_id_foreign');
        });
    }
}
