<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfiProgramestimationemployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifi_programestimationemployee', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('employee_fid');
$table->integer('activity_fid');
$table->integer('programestimation_fid');
$table->integer('employmenttype_fid');
$table->string('totalwork',250);
$table->integer('workunit_fid');
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
        Schema::dropIfExists('programestimationemployees');
    }
}
