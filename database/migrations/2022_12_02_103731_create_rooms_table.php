<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('id');
            
            $table->string('name');
            $table->double('price');
            $table->text('description')->nullable();
            $table->string('amenities')->nullable(); //(джакузі, балкон, wi-fi, телебачення ...)
            $table->string('count_one_bed')->nullable();//2*8, 1*2
            $table->string('count_two_bed')->nullable();//2*8, 1*2
            $table->string('count_rooms');//загальна кількість, буде вираховуватися вільна кількість кімнат
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'room_user_idx');
            $table->foreign('user_id', 'room_user_fk')->on('users')->references('id');

            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->index('hotel_id', 'room_hotel_idx');
            $table->foreign('hotel_id', 'room_hotel_fk')->on('hotels')->references('id');

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
        Schema::dropIfExists('rooms');
    }
}
