<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarserviceorderCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carserviceorder_car', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('title',500)->default('');
$table->integer('maxmodel_num')->nullable();
$table->integer('minmodel_num')->nullable();
$table->string('photo_igu',500)->default('');
$table->integer('carmaker_fid')->unsigned()->nullable()->index();
$table->foreign('carmaker_fid')->references('id')->on('carserviceorder_carmaker');
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
        Schema::dropIfExists('cars');
    }
}
