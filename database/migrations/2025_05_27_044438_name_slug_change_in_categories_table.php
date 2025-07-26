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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['name']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->text('name')->nullable()->change();
            $table->text('slug')->nullable()->change();
        });
    }
};
