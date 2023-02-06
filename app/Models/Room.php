<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'hotel_id', 'name', 'description', 'amenities', 'price', 'count_one_bed', 'count_two_bed', 'count_rooms'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booked_rooms() {
        return $this->hasMany(BookedRoom::class, 'room_id', 'id');
    }

    public function photos() {
        return $this->hasMany(Photo::class, 'room_id', 'id');
    }
}
