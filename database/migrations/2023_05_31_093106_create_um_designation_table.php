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
        Schema::create('um_designation', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_form');
            $table->integer('designation_status');
            $table->integer('created_user_id');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('um_designation');
    }
};
