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
        Schema::create('inv_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('inv_categories');
            $table->foreignId('sub_category_id')->constrained('inv_sub_categories');
            $table->string('name', 150);
            $table->string('code', 6);
            $table->string('ledger_type');
            $table->string('status', 50)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_items');
    }
};
