<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsPostcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_postcategory', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('post_fid')->unsigned()->nullable()->index();
$table->foreign('post_fid')->references('id')->on('posts_post');
$table->integer('category_fid')->unsigned()->nullable()->index();
$table->foreign('category_fid')->references('id')->on('posts_category');
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
        Schema::dropIfExists('postcategorys');
    }
}
