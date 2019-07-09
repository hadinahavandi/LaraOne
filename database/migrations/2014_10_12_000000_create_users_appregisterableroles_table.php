<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAppregisterablerolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_appregisterableroles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('common_app_fid')->unsigned()->nullable()->index();
            $table->foreign('common_app_fid')->references('id')->on('common_app');
            $table->string('rolename');
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
        Schema::dropIfExists('users_appregisterableroles');
    }
}
