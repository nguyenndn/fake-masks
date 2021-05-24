<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('camera_id')->unsigned();
            $table->foreign('camera_id')->references('id')->on('cameras')->onDelete('cascade');
            $table->integer('people_entering');
            $table->integer('people_have_mask');
            $table->integer('people_no_mask');
            $table->integer('minutes');
            $table->integer('hours');
            $table->integer('date');
            $table->integer('month');
            $table->integer('year');
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
        Schema::dropIfExists('reports');
    }
}
