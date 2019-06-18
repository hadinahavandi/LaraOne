<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('tel');
            $table->string('email');
            $table->string('address');
            $table->boolean('isactive');
            $table->string('fundationyear');
            $table->string('code');
            $table->string('photourl');
            $table->date('expire_at');
            $table->integer('company_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->integer('branchadmin_id')->unsigned();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('area_id')->references('id')->on('placeman_area');
            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('branchadmin_id')->references('id')->on('branchadmins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
