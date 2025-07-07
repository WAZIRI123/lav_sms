<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('my_class_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('topic_id');
            $table->decimal('t1', 8, 2)->nullable();
            $table->decimal('t2', 8, 2)->nullable();
            $table->decimal('t3', 8, 2)->nullable();
            $table->decimal('t4', 8, 2)->nullable();
            $table->decimal('tca', 8, 2)->nullable();
            $table->decimal('exm', 8, 2)->nullable();
            $table->decimal('tex1', 8, 2)->nullable();
            $table->decimal('tex2', 8, 2)->nullable();
            $table->decimal('tex3', 8, 2)->nullable();
            $table->decimal('sub_pos', 8, 2)->nullable();
            $table->integer('cum')->nullable();
            $table->string('cum_ave')->nullable();
            $table->unsignedInteger('grade_id')->nullable();
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
