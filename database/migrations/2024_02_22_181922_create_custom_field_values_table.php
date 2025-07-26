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
        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('rel_id')->index();
            $table->unsignedInteger('field_id')->index();
            $table->string('field_to', 50);
            $table->string('value');

            $table->unique(['rel_id', 'field_id', 'field_to']);

            $table->foreign(['field_id'])->references(['id'])->on('custom_fields')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_field_values');
    }
};
