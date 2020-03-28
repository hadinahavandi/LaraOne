<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarserviceorderRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carserviceorder_request', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('latitude_flt')->nullable();
            $table->integer('longitude_flt')->nullable();
            $table->integer('carmakeyear_num')->nullable();
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
            $table->integer('car_fid')->unsigned()->nullable()->index();
            $table->foreign('car_fid')->references('id')->on('carserviceorder_car');
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
        Schema::dropIfExists('requests');
    }
}
