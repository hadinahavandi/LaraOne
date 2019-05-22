<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_request', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('requesttype_fid')->unsigned()->nullable()->index();
$table->foreign('requesttype_fid')->references('id')->on('sas_requesttype');
$table->integer('device_fid')->unsigned()->nullable()->index();
$table->foreign('device_fid')->references('id')->on('sas_device');
$table->string('description_te',500);
$table->string('priority',500);
$table->string('attachment_flu',250);
$table->integer('status_fid')->unsigned()->nullable()->index();
$table->foreign('status_fid')->references('id')->on('sas_status');
$table->integer('sender__unit_fid')->unsigned()->nullable()->index();
$table->foreign('sender__unit_fid')->references('id')->on('sas_unit');
$table->integer('receiver__unit_fid')->unsigned()->nullable()->index();
$table->foreign('receiver__unit_fid')->references('id')->on('sas_unit');
$table->integer('current__unit_fid')->unsigned()->nullable()->index();
$table->foreign('current__unit_fid')->references('id')->on('sas_unit');
$table->string('adminacceptance_time',500);
$table->string('securityacceptance_time',500);
$table->string('fullsend_time',500);
$table->string('finalcommit_time',500);
$table->string('letternumber',500);
$table->string('letter_date',500);
$table->integer('sender__user_fid')->unsigned()->nullable()->index();
$table->foreign('sender__user_fid')->references('id')->on('users');
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
