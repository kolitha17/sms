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
        Schema::create('pur_order_inv_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pur_order_id')->constrained('purchase_orders');
            $table->foreignId('inv_item_id')->constrained('inv_items');
            $table->decimal('unit_price');
            $table->decimal('vat');
            $table->integer('quantity');
            $table->string('total_amount');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_order_inv_items');
    }
};
