<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hotel;
use App\Models\Room;

use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    public function show(Hotel $hotel, $dateFrom, $dateTo) {

        

        $user = $hotel->user;
        $photos = $user->photos;

        //dd($dateFrom);

        //умова whereBetween в значенні >= і <=, а нам потрібно > і <

        $booked_rooms = DB::table('booked_rooms')->select(DB::raw('count(*) as booked_rooms_count, room_id'))
                                                 ->where('confirmed', '=', true)
                                                 ->where(function($query) use ($dateFrom, $dateTo) {
                                                   $query->where('date_from', '>', $dateFrom)
                                                         ->where('date_from', '<', $dateTo)
                                                         ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                           $query->where('date_to', '>', $dateFrom)
                                                                 ->Where('date_to', '<', $dateTo);
                                                           })
                                                         ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                           $query->where('date_from', '<=', $dateFrom)
                                                                 ->Where('date_to', '>=', $dateTo);
                                                           });
                                                  })
                                                 // ->where('date_from', '>', $dateFrom) //$dateTo
                                                 // ->Where('date_from', '<', $dateTo)
                                                 // ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                 //    $query->where('date_to', '>', $dateFrom)
                                                 //          ->Where('date_to', '<', $dateTo);
                                                 //    })
                                                 // ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                 //    $query->where('date_from', '<=', $dateFrom)
                                                 //          ->Where('date_to', '>=', $dateTo);
                                                 //    })
                                                 ->groupBy('room_id');

                                                 // ->whereBetween('date_from', [$dateFrom, $dateTo])
                                                 // ->orwhereBetween('date_to', [$dateFrom, $dateTo])

                                                 // ->where('date_from', '>=', $dateFrom) //$dateTo
                                                 // ->Where('date_from', '<', $dateTo)
                                                 // ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                 //    $query->where('date_to', '>', $dateFrom)
                                                 //          ->Where('date_to', '<=', $dateTo);
                                                 //    })

        $rooms = DB::table('rooms')->where('hotel_id','=', $hotel->id)
                                    ->leftJoinSub($booked_rooms, 'booked_rooms', function ($join) {
                                        $join->on('rooms.id', '=', 'booked_rooms.room_id');
                                    })
                                   ->get();
        
        //dd($rooms);
        return view('hotel', compact('hotel', 'rooms', 'photos'));

    }
}
