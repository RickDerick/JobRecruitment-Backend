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
        Schema::create('jobs', function (Blueprint $table) {
            $table->string('code',20);
            $table->string('description',2048);
            $table->string('fullTitle',250);
            $table->string('shortTitle',30);
            $table->integer('budget',32);
            $table->string('status');
            $table->string('grade',20);
            $table->string('reportsTo',20);
            $table->string('payFrequency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
