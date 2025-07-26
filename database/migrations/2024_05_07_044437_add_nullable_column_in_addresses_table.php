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
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('first_name', 191)->nullable()->change();
            $table->string('type_of_place', 20)->nullable()->change();
            $table->string('address_1', 191)->nullable()->change();
            $table->string('city', 191)->nullable()->change();
            $table->string('country', 191)->nullable()->change();
        });
    }
};
