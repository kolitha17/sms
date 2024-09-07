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
        Schema::create('purchasing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('inv_categories');
            $table->foreignId('sub_category_id')->constrained('inv_sub_categories');
            $table->foreignId('inv_item_id')->constrained('inv_items');
            $table->string('ledger_type');
            $table->date('purchase_date');
            $table->foreignId('pur_unit_type')->constrained('org_unit_types');
            $table->foreignId('pur_units')->constrained('org_units');
            $table->string('ledger_no');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('invoice_no');
            $table->string('quantity');
            $table->decimal('uPrice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasing_items');
    }
};
