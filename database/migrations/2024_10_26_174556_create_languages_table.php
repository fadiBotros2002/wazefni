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
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('language_id');
            $table->unsignedBigInteger('cv_id');
            $table->string('language_name');

            $table->enum('proficiency_level', ['Beginner', 'Intermediate', 'Advanced', 'Fluent']);
            $table->timestamps();///////

            $table->foreign('cv_id')->references('cv_id')->on('cvs')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
