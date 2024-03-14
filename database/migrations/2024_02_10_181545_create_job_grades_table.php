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
        Schema::create('job_grades', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('description', 250)->nullable();
            $table->string('category', 250);
            $table->boolean('blocked')->default(false);
            $table->integer('employee_count');
            $table->decimal('maximum_pay')->nullable();
            $table->decimal('minimum_pay')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_grades');
    }
};
