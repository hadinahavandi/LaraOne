<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacemanPlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeman_place', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 500);
            $table->string('logo_igu', 250);
            $table->string('description', 500);
            $table->boolean('isactive');
            $table->string('address', 500);
            $table->integer('area_fid')->unsigned()->nullable()->index();
            $table->foreign('area_fid')->references('id')->on('placeman_area');
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
            $table->string('latitude', 500);
            $table->string('longitude', 500);
            $table->string('visits', 500);
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
        Schema::dropIfExists('places');
    }
}
