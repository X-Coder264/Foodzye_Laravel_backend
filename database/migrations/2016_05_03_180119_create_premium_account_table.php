<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiumAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_types', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('months_duration');
            $table->decimal('amount', 6, 2);
            $table->enum('currency', ['HRK', 'EUR', 'USD']);
            $table->string('picture');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('premium_accounts');
    }
}
