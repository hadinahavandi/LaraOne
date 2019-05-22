<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfiEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifi_employee', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',250);
$table->string('family',250);
$table->string('fathername',250);
$table->boolean('ismale');
$table->string('mellicode',250);
$table->string('shsh',250);
$table->string('shshserial',250);
$table->string('personelcode',250);
$table->string('employmentcode',250);
$table->integer('role_fid');
$table->integer('nationality_fid');
$table->integer('paycenter_fid');
$table->integer('employmenttype_fid');
$table->string('born_date',250);
$table->string('childcount',250);
$table->boolean('ismarried');
$table->string('mobile',250);
$table->string('tel',250);
$table->string('address',250);
$table->string('zipcode',250);
$table->integer('common_city_fid');
$table->string('accountnumber',250);
$table->string('cardnumber',250);
$table->integer('bank_fid');
$table->boolean('is_neededinsurance');
$table->boolean('is_payabale');
$table->string('passportnumber',250);
$table->string('passportserial',250);
$table->string('education',250);
$table->string('entrance_date',250);
$table->integer('visatype_fid');
$table->string('visaexpire_date',250);
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
        Schema::dropIfExists('employees');
    }
}
