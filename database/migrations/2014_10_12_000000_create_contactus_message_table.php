<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactusMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactus_message', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('messagereceiver_fid');
$table->string('orderserial',250);
$table->string('questiontext',250);
$table->string('question_flu',250);
$table->string('sendername',250);
$table->string('sendertel',250);
$table->string('answertext',250);
$table->string('voice_flu',250);
$table->string('answer_flu',250);
$table->integer('unit_fid')->unsigned()->index();
$table->string('answervoice_flu',250);
$table->string('personelno',250);
$table->integer('subject_fid');
$table->integer('degree_fid');
            $table->foreign('unit_fid')->references('id')->on('contactus_unit');
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
