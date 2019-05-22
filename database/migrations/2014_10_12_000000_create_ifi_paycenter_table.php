<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfiPaycenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifi_paycenter', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('title',250);
$table->string('chapter',250);
$table->string('accountingcode',250);
$table->integer('paycenter_fid');
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
        Schema::dropIfExists('paycenters');
    }
}
