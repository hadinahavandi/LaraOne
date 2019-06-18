<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrappVillaownerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trapp_villaowner', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 500);
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
            $table->string('nationalcode', 500);
            $table->string('address', 500);
            $table->string('shabacode', 500);
            $table->string('tel', 500);
            $table->string('backuptel', 500);
            $table->string('email', 500);
            $table->string('backupmobile', 500);
            $table->string('photo_igu', 250);
            $table->string('nationalcard_igu', 250);
            $table->integer('placeman_area_fid')->unsigned()->nullable()->index();
            $table->foreign('placeman_area_fid')->references('id')->on('placeman_area');
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
        Schema::dropIfExists('villaowners');
    }
}
