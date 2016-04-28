<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('food_id')->unsigned()->index();
            $table->foreign('food_id')->references('id')->on('food')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->decimal('rate_total')->unsigned();
            $table->integer('number_of_votes', 6, 2);
            $table->decimal('price', 6, 2);
            $table->enum('currency', ['HRK', 'EUR', 'USD']);
            $table->text('description');
            $table->string('food_image');
            $table->string('name');
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
        Schema::drop('menu');
    }
}
