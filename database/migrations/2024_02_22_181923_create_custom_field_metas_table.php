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
        Schema::create('custom_field_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('custom_field_id')->index();
            $table->string('key')->index();
            $table->string('value', 10000)->nullable();
            $table->unique(['key', 'custom_field_id']);

            $table->foreign(['custom_field_id'])->references(['id'])->on('custom_fields')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_field_metas');
    }
};
