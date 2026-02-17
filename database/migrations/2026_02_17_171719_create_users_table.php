<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('api_token', 512)->nullable(); // optional quick reference token
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // optional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
