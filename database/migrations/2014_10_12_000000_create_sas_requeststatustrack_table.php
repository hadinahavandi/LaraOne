<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasRequeststatustrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_requeststatustrack', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('status_fid')->unsigned()->nullable()->index();
$table->foreign('status_fid')->references('id')->on('sas_status');
$table->integer('request_fid')->unsigned()->nullable()->index();
$table->foreign('request_fid')->references('id')->on('sas_request');
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
        Schema::dropIfExists('requeststatustracks');
    }
}
