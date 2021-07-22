<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStructureExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('structure_id')->unsigned()->index();
            $table->integer('exam_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('structure_id')->references('id')->on('structures')->onDelete('CASCADE')->onUpdate('NO ACTION');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('CASCADE')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_exams');
    }
}
