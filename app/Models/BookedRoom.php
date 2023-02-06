<?php

namespace App\Models;

use DateTime;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedRoom extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'date_from', 'date_to','first_name','last_name','phone','email','confirmed'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
