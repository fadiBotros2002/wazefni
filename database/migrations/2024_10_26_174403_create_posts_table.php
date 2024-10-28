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
    Schema::create('posts', function (Blueprint $table) {
        $table->bigIncrements('post_id');
        $table->foreignId('user_id')->constrained('users');
        $table->string('title');
        $table->string('type');
        $table->text('description');
        $table->text('requirement');
        $table->string('location');
        $table->string('time');
        $table->string('salary');
        $table->integer('experience_year');
        $table->timestamp('posted_at');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
