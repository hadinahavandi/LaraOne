<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_like', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('comment_fid')->unsigned()->nullable()->index();
$table->foreign('comment_fid')->references('id')->on('comments_comment');
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
        Schema::dropIfExists('likes');
    }
}
