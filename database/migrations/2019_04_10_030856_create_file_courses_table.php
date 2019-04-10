<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_courses', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('course_id');
            $table->primary(['file_id', 'course_id']);
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_courses');
    }
}
