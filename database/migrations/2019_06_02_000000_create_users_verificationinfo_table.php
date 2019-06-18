<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersVerificationinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_verificationinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phone')->unsigned()->index();
            $table->integer('code')->unsigned();
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
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
        Schema::dropIfExists('users_verificationinfo');
    }
}
