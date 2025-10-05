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
        Schema::dropIfExists('invoices');
        
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->nullable()->index()->comment('User ID');
            $table->string('invoice_number')->unique();
            $table->string('currency', 3)->default('USD');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('invoice_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
