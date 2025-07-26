<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('vendor_id')->nullable()->index('suppliers_vendor_id_foreign_idx');
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('country', 45)->nullable();
            $table->string('state', 45)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('zip', 45)->nullable();
            $table->string('phone', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('status', 45);
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
        Schema::dropIfExists('suppliers');
    }
}
