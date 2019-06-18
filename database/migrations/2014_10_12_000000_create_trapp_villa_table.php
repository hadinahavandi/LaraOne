<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrappVillaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trapp_villa', function (Blueprint $table) {
            $table->increments('id');

            $table->string('roomcount_num', 500);
            $table->string('capacity_num', 500);
            $table->string('maxguests_num', 500);
            $table->string('structurearea_num', 500);
            $table->string('totalarea_num', 500);
            $table->integer('placeman_place_fid')->unsigned()->nullable()->index();
            $table->foreign('placeman_place_fid')->references('id')->on('placeman_place');
            $table->boolean('is_addedbyowner');
            $table->integer('viewtype_fid')->unsigned()->nullable()->index();
            $table->foreign('viewtype_fid')->references('id')->on('trapp_viewtype');
            $table->integer('structuretype_fid')->unsigned()->nullable()->index();
            $table->foreign('structuretype_fid')->references('id')->on('trapp_structuretype');
            $table->boolean('is_fulltimeservice');
            $table->string('timestart_clk', 500);
            $table->integer('owningtype_fid')->unsigned()->nullable()->index();
            $table->foreign('owningtype_fid')->references('id')->on('trapp_owningtype');
            $table->integer('areatype_fid')->unsigned()->nullable()->index();
            $table->foreign('areatype_fid')->references('id')->on('trapp_areatype');
            $table->string('description_te', 500);
            $table->string('documentphoto_igu', 250);
            $table->string('normalprice_prc', 500);
            $table->string('holidayprice_prc', 500);
            $table->string('weeklyoff_num', 500);
            $table->string('monthlyoff_num', 500);
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
        Schema::dropIfExists('villas');
    }
}
