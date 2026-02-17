<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('reason');
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id','employee_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
