<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_shipping_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_provider_id')->nullable();
            $table->string('provider_name')->nullable();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->string('tracking_link')->nullable();
            $table->string('tracking_no')->nullable()->index();
            $table->date('order_shipped_date')->nullable()->index();
            $table->string('track_type')->default('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_shipping_tracks');
    }
};
