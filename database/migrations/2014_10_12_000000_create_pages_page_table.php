<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_page', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500)->default('');
$table->string('title',500)->default('');
$table->string('content_te',500)->default('');
$table->boolean('is_published');
$table->string('keywords',500)->default('');
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
        Schema::dropIfExists('pages');
    }
}
