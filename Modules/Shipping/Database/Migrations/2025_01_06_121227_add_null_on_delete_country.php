<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullOnDeleteCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_providers', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->change();
        });
        
        
    }

}
