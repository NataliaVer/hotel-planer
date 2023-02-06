<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id('id');
            $table->string('hotel_name');
            $table->string('country');
            $table->string('city');
            $table->string('settlement');
            $table->string('street');
            $table->string('number_house');
            $table->string('phone');
            $table->string('aditional_services');
            $table->text('description');
            $table->string('time_of_settlement');//10 cсимволів
            $table->string('time_of_eviction');//10 cсимволів
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'hotel_user_idx');
            $table->foreign('user_id', 'hotel_user_fk')->on('users')->references('id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
