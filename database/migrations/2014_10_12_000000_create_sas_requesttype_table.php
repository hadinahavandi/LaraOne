<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasRequesttypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_requesttype', function (Blueprint $table) {
            $table->increments('id');
            
$table->string('name',500);
$table->string('priority',500);
$table->boolean('is_needssecurityacceptance');
$table->integer('mother__requesttype_fid')->unsigned()->nullable()->index();
$table->boolean('is_hardwareneeded');
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
        Schema::dropIfExists('requesttypes');
    }
}
