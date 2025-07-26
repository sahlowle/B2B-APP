<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeDeleteToOrderShippingTracksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_shipping_tracks', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);

            // Add the foreign key constraints with cascade on delete
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_shipping_tracks', function (Blueprint $table) {
            // Drop the new foreign key constraints with cascade delete
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);

            // Restore the original foreign key constraints (without cascade delete)
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }
}
