<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppmanApperrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appman_apperror', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('type',500)->default('');
$table->string('url',500)->default('');
$table->string('method',500)->default('');
$table->string('postingdata',500)->default('');
$table->string('receiveddata',500)->default('');
$table->string('error',500)->default('');
$table->integer('line_num')->nullable();
$table->string('appname',500)->default('');
$table->string('appversion',500)->default('');
$table->string('devicebrand',500)->default('');
$table->string('devicemodel',500)->default('');
$table->string('deviceos',500)->default('');
$table->string('deviceosversion',500)->default('');
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
        Schema::dropIfExists('apperrors');
    }
}
