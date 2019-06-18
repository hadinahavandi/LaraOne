<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacemanPlacephotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeman_placephoto', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 500);
            $table->string('photo_igu', 250);
            $table->integer('phototype_fid')->unsigned()->nullable()->index();
            $table->foreign('phototype_fid')->references('id')->on('placeman_phototype');
            $table->integer('place_fid')->unsigned()->nullable()->index();
            $table->foreign('place_fid')->references('id')->on('placeman_place');
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
        Schema::dropIfExists('placephotos');
    }
}
