<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookedRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_rooms', function (Blueprint $table) {
            $table->id('id');
            
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email');
            $table->string('phone');
            $table->boolean('confirmed');
            $table->timestamps();

            $table->unsignedBigInteger('room_id')->nullable();
            $table->index('room_id', 'booked_room_room_idx');
            $table->foreign('room_id', 'booked_room_room_fk')->on('rooms')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booked_rooms');
    }
}
