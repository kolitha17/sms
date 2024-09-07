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
        Schema::table('item_manufactures', function (Blueprint $table) {
            $table->string('address', 255);
            $table->string('email', 255);
            $table->string('contact_no', 10);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_manufactures', function (Blueprint $table) {
            $table->dropColumn('address', 255);
            $table->dropColumn('email', 255);
            $table->dropColumn('contact_no', 10);
        });
    }
};
