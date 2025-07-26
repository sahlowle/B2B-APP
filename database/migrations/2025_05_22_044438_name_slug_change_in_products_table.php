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
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_slug_to_index');
            $table->dropIndex(['name']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('slug')->nullable()->change();
            $table->longText('summary')->nullable()->change();
            $table->longText('description')->nullable()->change();
        });
    }
};
