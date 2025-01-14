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
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('application_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->string('cv')->nullable();
            $table->string('test_result');
            $table->string('status')->default('pending');
            $table->timestamp('application_date');
            $table->timestamps();


        $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
