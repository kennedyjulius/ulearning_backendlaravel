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
        Schema::create('course_types', function (Blueprint $table) {
            $table->id();
            $table->String('user_token', 50);
            $table->String('name', 200);
            $table->String('thumbnail', 150);
            $table->String('video', 150)->nullable();
            $table->String('description', 150)->nullable();
            $table->smallInteger('type_id');
            $table->timestamps();
            $table->float('price');
            $table->smallInteger('lesson_num')->nullable;
            $table->smallInteger('video_length');
            $table->smallInteger('follow');
            $table->float('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_types');
    }
};
