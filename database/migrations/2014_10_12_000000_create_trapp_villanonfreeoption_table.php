<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrappVillanonfreeoptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trapp_villanonfreeoption', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('villa_fid')->unsigned()->nullable()->index();
$table->foreign('villa_fid')->references('id')->on('trapp_villa');
$table->integer('option_fid')->unsigned()->nullable()->index();
$table->foreign('option_fid')->references('id')->on('trapp_option');
$table->boolean('is_optional');
$table->integer('price_num')->nullable();
$table->integer('maxcount_num')->nullable();
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
        Schema::dropIfExists('villanonfreeoptions');
    }
}
