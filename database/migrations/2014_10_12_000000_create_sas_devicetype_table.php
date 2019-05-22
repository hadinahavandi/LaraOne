<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasDevicetypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_devicetype', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500);
$table->integer('devicetype_fid')->unsigned()->nullable()->index();
$table->boolean('is_needssecurityacceptance');
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
        Schema::dropIfExists('devicetypes');
    }
}
