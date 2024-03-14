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
        Schema::create('associated_grades', function (Blueprint $table) {
            $table->string('qualificationCode', 20);
            $table->string('qualificationGrade', 20);
            $table->string('gradeDescription', 100);
            $table->integer('sequenceID', 32);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associated_grades');
    }
};
