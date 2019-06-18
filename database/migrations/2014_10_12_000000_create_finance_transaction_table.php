<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_transaction', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('amount_prc');
            $table->string('transactionid');
            $table->string('status');
            $table->integer('user_fid')->unsigned()->nullable()->index();
            $table->foreign('user_fid')->references('id')->on('users');
            $table->string('description_te', 500);
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
        Schema::dropIfExists('transactions');
    }
}
