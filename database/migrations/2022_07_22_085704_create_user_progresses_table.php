<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_progresses', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('course_id')->constrained('courses')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('lesson_id')->constrained('course_lessons')->onDelete('restrict')->onUpdate('restrict');
            $table->primary(['user_id', 'course_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_progresses');
    }
};
