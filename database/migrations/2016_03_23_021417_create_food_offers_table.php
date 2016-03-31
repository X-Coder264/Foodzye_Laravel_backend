<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('food_id')->unsigned()->index();
            $table->foreign('food_id')->references('id')->on('food')->onDelete('cascade');
            $table->decimal('price', 6, 2);
            $table->enum('currency', ['HRK', 'EUR', 'USD']);
            $table->text('description');
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
        Schema::drop('food_offers');
    }
}
