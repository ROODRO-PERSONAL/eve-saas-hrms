<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('position');
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'email']); // for faster tenant queries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
