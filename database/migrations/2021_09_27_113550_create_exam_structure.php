<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_structure', function (Blueprint $table) {
            $table->integer('exam_id')->unsigned();
            $table->integer('structure_id')->unsigned();
        
            $table->foreign('exam_id')->references('id')->on('exams')
                ->onDelete('cascade');
        
            $table->foreign('structure_id')->references('id')->on('structures')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_structure');
    }
}
