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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeeID')->constrained('employees')->onDelete('cascade');
    
            $table->foreignId('SSS_ID')->constrained('sss')->onDelete('cascade');
            $table->foreignId('PHILHEALTH_ID')->constrained('philhealth')->onDelete('cascade');
            $table->foreignId('PAGIBIG_ID')->constrained('pagibig')->onDelete('cascade');
            
            $table->decimal('SSS_Monthly_Payment', 10, 2);
            $table->decimal('PHILHEALTH_Monthly_Payment', 10, 2);
            $table->decimal('Pagibig_Monthly_Payment', 10, 2);
            
            $table->decimal('CashAdvance', 10, 2)->nullable();
            $table->decimal('Undertime', 10, 2)->nullable();
            $table->decimal('SalaryAdjustment', 10, 2)->nullable();
            $table->decimal('Loan', 10, 2)->nullable();
            
            $table->decimal('TotalDeduction', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
