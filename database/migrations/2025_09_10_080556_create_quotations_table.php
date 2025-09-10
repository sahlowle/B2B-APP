<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',150);
            $table->string('last_name',150);
            $table->bigInteger('country_id');
            $table->string('phone_number',20);
            $table->string('email',150);
            $table->bigInteger('category_id');
            $table->text('notes')->nullable();
            $table->text('pdf_file')->nullable();
            $table->string('status',20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
