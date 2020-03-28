<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTempuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_tempuser', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500)->default('');
$table->string('family',500)->default('');
$table->integer('mobile_num')->nullable();
$table->string('email',500)->default('');
$table->integer('tel_num')->nullable();
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
        Schema::dropIfExists('tempusers');
    }
}
