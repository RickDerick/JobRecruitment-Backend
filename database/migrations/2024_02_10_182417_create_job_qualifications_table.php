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
        Schema::create('job_qualifications', function (Blueprint $table) {
            $table->string('jobsNo',20);
            $table->integer('lineNo',);
            $table->string('type');
            $table->string('minQualification',100);
            $table->string('qualificationCode',20);
            $table->string('qualificationDescription',250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_qualifications');
    }
};
