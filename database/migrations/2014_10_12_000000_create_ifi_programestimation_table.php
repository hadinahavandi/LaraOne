<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfiProgramestimationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifi_programestimation', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('title',250);
$table->integer('department_fid');
$table->integer('class_fid');
$table->integer('programmaketype_fid');
$table->string('totalprogramcount',250);
$table->string('timeperprogram',250);
$table->boolean('is_haslegalproblem');
$table->string('approval_date',250);
$table->string('end_date',250);
$table->string('add_date',250);
$table->integer('producer_employee_fid');
$table->integer('executor_employee_fid');
$table->integer('paycenter_fid');
$table->integer('makergroup_paycenter_fid');
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
        Schema::dropIfExists('programestimations');
    }
}
