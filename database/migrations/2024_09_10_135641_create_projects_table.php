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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('ProjectName', 50);
            $table->string('PR_Street', 50);
            $table->string('PR_Barangay', 50);
            $table->string('PR_City', 50);
            $table->string('PR_Province', 50);
            $table->date('StartDate');
            $table->date('EndDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
