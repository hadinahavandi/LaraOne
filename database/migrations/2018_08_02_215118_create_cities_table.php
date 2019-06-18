<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeman_city', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('province_id')->unsigned();
            $table->timestamps();
            $table->foreign('province_id')->references('id')->on('placeman_province');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
