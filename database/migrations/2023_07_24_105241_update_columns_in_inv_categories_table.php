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
        Schema::table('inv_categories', function (Blueprint $table) {
            //
            $table->unique('name', 150);
            $table->unique('code', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_categories', function (Blueprint $table) {
            //
            $table->string('name', 150);
            $table->string('code', 50);
        });
    }
};
