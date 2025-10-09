<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_meta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('package_id')->index();
            $table->string('feature', 100)->index();
            $table->string('key', 100)->index();
            $table->string('value', 1000)->nullable();
            $table->unique(['key', 'package_id', 'feature']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages_meta');
    }
}
