<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_device', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500);
$table->integer('devicetype_fid')->unsigned()->nullable()->index();
$table->foreign('devicetype_fid')->references('id')->on('sas_devicetype');
$table->string('code',500);
$table->string('note_te',500);
$table->integer('owner__unit_fid')->unsigned()->nullable()->index();
$table->foreign('owner__unit_fid')->references('id')->on('sas_unit');
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
        Schema::dropIfExists('devices');
    }
}
