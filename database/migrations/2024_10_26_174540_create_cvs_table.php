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
        Schema::create('cvs', function (Blueprint $table) {
            $table->bigIncrements('cv_id');
            $table->unsignedBigInteger('user_id')->unique();
          //  $table->string('image')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('domain')->nullable();
            $table->text('education')->nullable();
            $table->text('skills')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('portfolio')->nullable();
            $table->string('pdf')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
