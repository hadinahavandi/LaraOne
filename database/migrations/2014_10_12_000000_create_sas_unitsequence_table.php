<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasUnitsequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_unitsequence', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('source__unit_fid')->unsigned()->nullable()->index();
$table->foreign('source__unit_fid')->references('id')->on('sas_unit');
$table->integer('destination__unit_fid')->unsigned()->nullable()->index();
$table->foreign('destination__unit_fid')->references('id')->on('sas_unit');
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
        Schema::dropIfExists('unitsequences');
    }
}
