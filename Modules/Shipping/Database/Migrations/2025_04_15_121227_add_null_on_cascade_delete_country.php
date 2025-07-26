<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNullOnCascadeDeleteCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_providers', function (Blueprint $table) {


            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.REFERENTIAL_CONSTRAINTS 
                WHERE CONSTRAINT_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'shipping_providers' 
                AND CONSTRAINT_NAME = 'shipping_providers_country_id_foreign'
            ");

            if (!empty($foreignKeys)) {
                $table->dropForeign('shipping_providers_country_id_foreign');
            }

            $table->foreign('country_id')
                ->references('id')
                ->on('geolocale_countries')
                ->onDelete('set null');
        });
    }
}
