<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItsapServicerequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itsap_servicerequest', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('title',250);
$table->string('role_systemuser_fid',250);
$table->integer('unit_fid');
$table->integer('servicetype_fid');
$table->string('description',250);
$table->string('priority',250);
$table->string('file1_flu',250);
$table->string('request_date',250);
$table->string('letterfile_flu',250);
$table->integer('securityacceptor_role_systemuser_fid');
$table->boolean('is_securityaccepted');
$table->string('securityacceptancemessage',250);
$table->string('securityacceptance_date',250);
$table->string('letternumber',250);
$table->string('letter_date',250);
$table->integer('last_servicestatus_fid');
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
        Schema::dropIfExists('servicerequests');
    }
}
