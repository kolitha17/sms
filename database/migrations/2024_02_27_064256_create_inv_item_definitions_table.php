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
        Schema::create('inv_item_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchasing_item_id')->constrained('purchasing_items');
            $table->string('model')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_item_definitions');
    }
};
