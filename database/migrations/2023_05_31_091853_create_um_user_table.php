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
        Schema::create('um_user', function (Blueprint $table) {

            $table->id();
            $table->string('full_name');
            $table->integer('emp_no');
            $table->string('designation_id'); //please change data type
            $table->string('mobile_no');
            $table->string('email_address');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_name');
            $table->string('password');
            $table->integer('org_unit_id')->nullable();
            $table->integer('status_updated_user_id')->default('0');
            $table->integer('approval_user_id')->default('0');
            $table->string('user_image')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('um_user');
    }
};
