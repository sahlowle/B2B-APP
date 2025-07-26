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
        Schema::create('vendor_associated_users', function (Blueprint $table) {
            $table->bigInteger('vendor_id')->index('vendor_users_vendor_id_foreign_idx');
            $table->bigInteger('user_id')->index('vendor_users_user_id_foreign_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_associated_users');
    }
};
