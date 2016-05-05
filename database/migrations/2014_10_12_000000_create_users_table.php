<?php

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
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedInteger('role');
            $table->string('password');
            $table->text('description');
            $table->string('location');
            $table->string('phone');
            $table->string('slug');
            $table->string('work_time');
            $table->string('user_picture');
            $table->decimal('rate_total',6,2);
            $table->integer('number_of_votes');
            $table->tinyInteger('premium');
            $table->string('premium_until');
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
        Schema::drop('users');
    }
}
