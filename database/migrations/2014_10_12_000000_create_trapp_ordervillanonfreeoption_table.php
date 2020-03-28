<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrappOrdervillanonfreeoptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trapp_ordervillanonfreeoption', function (Blueprint $table) {
            $table->increments('id');
            
$table->integer('order_fid')->unsigned()->nullable()->index();
$table->foreign('order_fid')->references('id')->on('trapp_order');
$table->integer('villanonfreeoption_fid')->unsigned()->nullable()->index();
$table->foreign('villanonfreeoption_fid')->references('id')->on('trapp_villanonfreeoption');
$table->integer('count_num')->nullable();
$table->integer('price_num')->nullable();
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
        Schema::dropIfExists('ordervillanonfreeoptions');
    }
}
