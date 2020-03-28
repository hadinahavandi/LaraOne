<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_comment', function (Blueprint $table) {
            $table->increments('id');

            $table->string('text',500)->default('');
            $table->integer('commenttype_fid')->unsigned()->nullable()->index();
            $table->foreign('commenttype_fid')->references('id')->on('comments_commenttype');
            $table->string('publish_time',500)->default('');
            $table->integer('rate_num')->nullable();
            $table->integer('tempuser_fid')->unsigned()->nullable()->index();
            $table->foreign('tempuser_fid')->references('id')->on('users');
            $table->integer('mother_comment_fid')->unsigned()->nullable()->index();
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
            $table->integer('subjectentity_fid')->unsigned()->nullable()->index();
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
        Schema::dropIfExists('comments');
    }
}
