<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->index();
            $table->string('slug', 120)->index();
            $table->unsignedBigInteger('country_id');
            $table->string('tracking_base_url', 191);
            $table->string('tracking_url_method', 5)->default('Get');
            $table->string('status', 10)->default('Active')->index();
            $table->foreign('country_id')->references('id')->on('geolocale_countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_providers');
    }
}
