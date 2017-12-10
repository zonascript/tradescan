<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPersonalFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personal_fields', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->nullable();
          $table->string('name_surname')->nullable();
          $table->string('telegram')->nullable();
          $table->string('emergency_email')->nullable();
          $table->string('permanent_address')->nullable();
          $table->string('contact_number')->nullable();
          $table->string('date_place_birth')->nullable();
          $table->string('nationality')->nullable();
          $table->string('source_of_funds')->nullable();
          $table->string('presumptive_investment')->nullable();
          $table->timestamps();
          $table->engine = 'InnoDB';
        });
      Schema::table('user_personal_fields', function($table) {
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
        Schema::dropIfExists('user_personal_fields');
    }
}
