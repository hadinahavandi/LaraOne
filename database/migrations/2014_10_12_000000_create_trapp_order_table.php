<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrappOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trapp_order', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('price_prc');
            $table->integer('reserve__finance_transaction_fid')->unsigned()->nullable()->index();
            $table->foreign('reserve__finance_transaction_fid')->references('id')->on('finance_transaction');
            $table->integer('cancel__finance_transaction_fid')->unsigned()->nullable()->index();
            $table->foreign('cancel__finance_transaction_fid')->references('id')->on('finance_transaction');
            $table->integer('villa_fid')->unsigned()->nullable()->index();
            $table->foreign('villa_fid')->references('id')->on('trapp_villa');
            $table->integer('orderstatus_fid')->unsigned()->nullable()->index();
            $table->foreign('orderstatus_fid')->references('id')->on('trapp_orderstatus');
            $table->string('start_date', 500);
            $table->integer('duration_num');
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
