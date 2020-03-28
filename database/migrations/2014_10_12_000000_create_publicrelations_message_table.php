<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicrelationsMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicrelations_message', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500)->default('');
$table->string('email',500)->default('');
$table->bigInteger('phone_bnum')->nullable();
$table->string('messagetext_te',500)->default('');
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
        Schema::dropIfExists('messages');
    }
}
