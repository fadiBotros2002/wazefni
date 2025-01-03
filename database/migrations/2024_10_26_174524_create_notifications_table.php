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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notification_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('application_id');
            $table->text('message');
            $table->timestamp('sent_at');
            $table->timestamps();


        $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        $table->foreign('application_id')->references('application_id')->on('applications')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
