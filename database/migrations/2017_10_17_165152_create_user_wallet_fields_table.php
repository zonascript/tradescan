<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWalletFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_wallet_fields', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned()->nullable();
        $table->string('wallet_invest_from')->nullable();
        $table->string('name_of_wallet_invest_from')->nullable();
        $table->string('wallet_get_tokens')->nullable();
        $table->string('ETH')->nullable();
        $table->string('BTC')->nullable();
        $table->timestamps();
        $table->engine = 'InnoDB';
      });
      Schema::table('user_wallet_fields', function($table) {
        $table->foreign('user_id')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallet_fields');
    }
}
