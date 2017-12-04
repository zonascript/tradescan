<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHistoryFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_history_fields', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned()->nullable();
        $table->string('reg_email')->nullable();
        $table->string('reg_pwd')->nullable();
        $table->timestamp('reg_at')->nullable();
        $table->string('forgot_pwd_new')->nullable();
        $table->string('forgot_pwd_old')->nullable();
        $table->timestamp('forgot_pwd_at')->nullable();
        $table->string('change_email_new')->nullable();
        $table->string('change_email_old')->nullable();
        $table->timestamp('change_email_at')->nullable();
        $table->string('change_pwd_new')->nullable();
        $table->string('change_pwd_old')->nullable();
        $table->timestamp('change_pwd_at')->nullable();
        $table->string('wallet_currency_new')->nullable();
        $table->string('wallet_invest_from_new')->nullable();
        $table->string('wallet_get_tokens_new')->nullable();
        $table->string('wallet_currency_old')->nullable();
        $table->string('wallet_invest_from_old')->nullable();
        $table->string('wallet_get_tokens_old')->nullable();
        $table->timestamp('update_wallet_at')->nullable();
        $table->timestamps();

      });
      Schema::table('user_history_fields', function ($table) {
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
        Schema::dropIfExists('user_history_fields');
    }
}
