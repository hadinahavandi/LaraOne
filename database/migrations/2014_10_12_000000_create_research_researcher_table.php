<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchResearcherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_researcher', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('user_fid')->unsigned()->nullable()->index();
$table->foreign('user_fid')->references('id')->on('users');
$table->string('name',500)->default('');
$table->string('family',500)->default('');
$table->string('university',500)->default('');
$table->string('studyfield',500)->default('');
$table->string('interestarea',500)->default('');
$table->integer('tel_num')->nullable();
$table->integer('mob_num')->nullable();
$table->string('email',500)->default('');
$table->integer('workstatus_fid')->unsigned()->nullable()->index();
$table->foreign('workstatus_fid')->references('id')->on('research_workstatus');
$table->string('jobfield',500)->default('');
$table->string('role',500)->default('');
$table->bigInteger('bankcard_bnum')->nullable();
$table->string('licence_igu',500)->default('');
$table->string('city',500)->default('');
$table->string('area',500)->default('');
$table->integer('birthyear_num')->nullable();
$table->boolean('ismale');
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
        Schema::dropIfExists('researchers');
    }
}
