<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_unit', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500);
$table->string('logo_igu',250);
$table->integer('unittype_fid')->unsigned()->nullable()->index();
$table->foreign('unittype_fid')->references('id')->on('sas_unittype');
$table->boolean('is_needsadminapproval');
$table->integer('user__user_fid')->unsigned()->nullable()->index();
$table->foreign('user__user_fid')->references('id')->on('users');
$table->integer('admin__user_fid')->unsigned()->nullable()->index();
$table->foreign('admin__user_fid')->references('id')->on('users');
$table->integer('security__user_fid')->unsigned()->nullable()->index();
$table->foreign('security__user_fid')->references('id')->on('users');
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
        Schema::dropIfExists('units');
    }
}
