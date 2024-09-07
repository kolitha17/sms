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
        Schema::create('good_receive_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('pur_order_no');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('pur_order_id')->constrained('purchase_orders');
            $table->string('invoice_no');
            $table->string('complete_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_receive_notes');
    }
};
