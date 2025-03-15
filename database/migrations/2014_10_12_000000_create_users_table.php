<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_level')->nullable();
            $table->bigInteger('subsidiary_id')->nullable();
            $table->string('name')->nullable();
            $table->string('is_admin')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('position')->nullable();
            $table->string('password');
            $table->string('code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
