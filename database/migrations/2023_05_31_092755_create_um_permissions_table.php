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
        Schema::create('um_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('description_url');
            $table->integer('permission_status');
            $table->integer('status_updated_user_id');
            $table->integer('created_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('um_permissions');
    }
};
