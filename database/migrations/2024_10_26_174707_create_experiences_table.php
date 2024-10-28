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
        Schema::create('experiences', function (Blueprint $table) {
            $table->bigIncrements('experience_id');
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');
            $table->string('company_name');
            $table->string('domain');
            $table->text('job_description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
