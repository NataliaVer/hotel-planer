<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id('id');

            $table->string('photo', 300);
            $table->string('kind_photo'); // baground, room or all_photos
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id', 'photo_user_idx');
            $table->foreign('user_id', 'photo_user_fk')->on('users')->references('id');

            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->index('hotel_id', 'photo_hotel_idx');
            $table->foreign('hotel_id', 'photo_hotel_fk')->on('hotels')->references('id');

            $table->unsignedBigInteger('room_id')->nullable();
            $table->index('room_id', 'photo_room_idx');
            $table->foreign('room_id', 'photo_room_fk')->on('rooms')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
