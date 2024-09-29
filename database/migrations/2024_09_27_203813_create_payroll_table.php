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
        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('EmployeeID');
            $table->date('PayrollDate');
            $table->decimal('TotalEarnings', 10, 2);
            $table->decimal('GrossPay', 10, 2);
            $table->decimal('TotalDeductions', 10, 2);
            $table->decimal('NetPay', 10, 2);

            $table->foreign('EmployeeID')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll');
    }
};
