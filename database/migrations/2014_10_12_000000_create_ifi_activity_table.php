<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfiActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifi_activity', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('title',250);
$table->string('paycenter_type',250);
$table->string('planingcode',250);
$table->integer('taxtype_fid');
$table->string('alalhesab',250);
$table->boolean('isactive');
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
        Schema::dropIfExists('activitys');
    }
}
