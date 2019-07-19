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

            $table->string('name', 500)->default('');
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
            $table->bigInteger('nationalcode_bnum')->nullable();
            $table->string('address', 500)->default('');
            $table->bigInteger('shabacode_bnum')->nullable();
            $table->bigInteger('tel_bnum')->nullable();
            $table->bigInteger('backuptel_bnum')->nullable();
            $table->string('email', 500)->default('');
            $table->bigInteger('backupmobile_bnum')->nullable();
            $table->string('photo_igu', 500)->default('');
            $table->string('nationalcard_igu', 500)->default('');
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
