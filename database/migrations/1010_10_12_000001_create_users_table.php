<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('email')->unique();
          $table->string('password')->nullable();
          $table->integer('valid_step')->default(0);
          $table->timestamp('valid_at')->nullable();
          $table->string('token')->nullable();
          $table->string('ip_token')->nullable();
          $table->integer('confirmed')->default(0);
          $table->timestamp('confirmed_at')->nullable();
          $table->integer('reg_attempts')->default(0);
          $table->integer('reset_attempts')->default(0);
          $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
