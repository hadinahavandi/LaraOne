<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeman_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('city_id')->unsigned();
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('placeman_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
