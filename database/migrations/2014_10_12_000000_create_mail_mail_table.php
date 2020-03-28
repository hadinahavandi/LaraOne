<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_mail', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('mailpost_fid')->unsigned()->nullable()->index();
$table->foreign('mailpost_fid')->references('id')->on('mail_mailpost');
$table->string('email',500)->default('');
$table->integer('mailstatus_fid')->unsigned()->nullable()->index();
$table->foreign('mailstatus_fid')->references('id')->on('mail_mailstatus');
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
        Schema::dropIfExists('mails');
    }
}
