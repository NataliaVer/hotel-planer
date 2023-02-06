<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BookedRoom;
use App\Models\Room;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserBookedRoomController extends Controller
{
    public function userbookedrooms() {

        $user = Auth::user();
        $rooms = $user->rooms;

        return view('userbookedrooms',compact('rooms'));
    }

    public function searchBookedRooms($dateFrom, $dateTo) {

        $user = Auth::user();

        $newBookedRoom = new BookedRoom();

        if (!$dateFrom || !$dateTo || !$newBookedRoom->validateDate($dateFrom, 'Y-m-d') || !$newBookedRoom->validateDate($dateTo, 'Y-m-d')) {
            $response['status'] = false;
            $response['message'] = 'Передано не корректну дату';

            return $response;
        }

        $rooms = DB::table('rooms')
                   ->select('name', 'price', 'count_one_bed', 'count_two_bed', DB::raw('id as room_id'))
                   ->where('rooms.user_id', '=', $user->id);

        $booked_rooms = DB::table('booked_rooms')->select('*')
                                                 ->whereBetween('booked_rooms.date_from', [$dateFrom, $dateTo])
                                                 // ->orWhere('created_at', '<=', $dateTo)
                                                 ->JoinSub($rooms, 'rooms', function ($join) {
                                                     $join->on('booked_rooms.room_id', '=', 'rooms.room_id');
                                                 })->get();

        $response['status'] = true;
        $response['booked_rooms'] = $booked_rooms;

        // dd($response);

        return $response;
    }

    public function confirmOrCancelBookedRoom($id, $action) {

        $booked_room = BookedRoom::find($id);

        if(!$booked_room) {
            $response['status'] = false;
            $response['message'] = 'Бронювання не знайдено, обновіть сторінку і спробуйте ще раз';

            return $response;
        }

        if($action == 'confirm') {
            $booked_room->update(["confirmed" => 1]);
        } elseif ($action == 'cancel') {
            $booked_room->update(["confirmed" => 0]);
        } else {
            $booked_room->delete();
        }
        // dd($booked_room);

        $response['status'] = true;
        $response['message'] = 'Дію підтверджено';

        return $response;
    }

    public function allUserRoom() {
        $user = Auth::user();

        $response['status'] = true;
        $response['rooms'] = $user->rooms;

        return $response;
    }

    public function allUserRoomToDate(Request $req) {
        $id = $req->get('id');
        $dateFrom = $req->get('dateFrom');
        $dateTo = $req->get('dateTo');

        $user = Auth::user();
        $newBookedRoom = new BookedRoom();

        if (!$dateFrom || !$dateTo || !is_numeric($id) || !$newBookedRoom->validateDate($dateFrom, 'Y-m-d') || !$newBookedRoom->validateDate($dateTo, 'Y-m-d')) {
            $response['status'] = true;
            $response['rooms'] = $user->rooms;

            return $response;
        }

        $rooms = $user->rooms->pluck('id')->toArray();

        //від загальної кількості кімнат певного виду відняти уже заброньовані кімнати
        //без тієї що змінюємо (один запит на Add та Edit), якщо її id передано в запиті

        $booked_rooms = DB::table('booked_rooms')->select(DB::raw('count(*) as booked_rooms_count, room_id'))
                                                ->whereIn('room_id', $rooms)
                                                ->where('id', "<>", ($id ? $id : ""))
                                                ->where('confirmed', '1')
                                                // ->where('date_from', '>', $dateFrom) //$dateTo
                                                // ->where('date_from', '<', $dateTo)
                                                // ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                //    $query->where('date_to', '>', $dateFrom)
                                                //          ->Where('date_to', '<', $dateTo);
                                                //    })
                                                // ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                //    $query->where('date_from', '<=', $dateFrom)
                                                //          ->Where('date_to', '>=', $dateTo);
                                                //    })
                                                // ->groupBy('room_id');
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
                                                ->groupBy('room_id');
                                                //->get();
        //BookedRoom::whereIn('room_id', $rooms)->where('confirmed', '0')->get();

        $roomsAvailable = DB::table('rooms')->where('user_id','=', $user->id)
                                    ->leftJoinSub($booked_rooms, 'booked_rooms', function ($join) {
                                        $join->on('rooms.id', '=', 'booked_rooms.room_id');
                                    })
                                    // ->where('booked_rooms_count', '>', 'count_rooms')
                                    ->get();

        //вибрати вільні кімнати на дати

        // dd($roomsAvailable);

        $response['status'] = true;
        $response['rooms'] = $roomsAvailable;

        return $response;
    }

    public function dataOfBookedRoom ($id) {

        $booked_room = BookedRoom::find($id);

        if(!$booked_room) {
            $response['status'] = false;
            $response['message'] = 'Бронювання не знайдено, обновіть сторінку і спробуйте ще раз';

            return $response;
        }

        $response['status'] = true;
        $response['booked_room'] = $booked_room;

        return $response;
    }

    public function addNewReservation (Request $req) {

        //зробити перевірку доступності кімнати на дату

        $data = Validator::make($req->all(), [
                'room_id' => 'bail|required',
                'date_from' => 'bail|required',
                'date_to' => 'bail|required',
                'first_name' => 'bail|required',
                'last_name' => 'bail|required',
                'phone' => 'bail|required|min:10|max:14',
                'email' => 'bail|required|email',
                'confirmed' => ''
            ],
            [
                'room_id.required' => 'Сталася помилка, перезавантажте сторінку і спробуйте ще раз',
                'date_from.required' => 'Заповніть поля дати',
                'date_to.required' => 'Заповніть поля дати',
                'first_name.required' => "Укажіть ім'я",
                'last_name.required' => 'Укажіть прізвище',
                'phone.required' => 'Укажіть телефон',
                'phone.min' => 'Довжина поля телефону не менше 10 символів',
                'phone.max' => 'Довжина поля телефону не більше 14 символів',
                'email.required' => 'Укажіть електронну ардесу']);

        if($data->fails()){
            $response['status'] = false;
            $response['message'] = $data->errors();

            return $response;
        }

        $bookedRoom = BookedRoom::create([
                'room_id' => $req->room_id,
                'first_name' => $req->first_name,
                'last_name' => $req->last_name,
                'email' => $req->email,
                'phone' => $req->phone,
                'confirmed' => $req->confirmed,
                'date_from' => $req->date_from,
                'date_to' => $req->date_to
            ]);

        $room = $bookedRoom->room;

        // [
        //     'room_id' => '6',
        //     'confirmed' => false,
        //     'date_from' => '2023-01-05',
        //     'date_to' => '2023-01-10',
        //     'first_name' => 'Natalia',
        //     'last_name' => 'Rybalka',
        //     'email' => 'test14@example.com',
        //     'phone' => '+3801111114'
        // ]

        $response['status'] = true;
        $response['booked_room'] = $bookedRoom;
        $response['name_room'] = (!$room ? '' : $room->name);

        return $response;
    }

    public function editNewReservation (Request $req) {

        $id = $req->post('id');

            $data = Validator::make($req->all(), [
                'room_id' => 'bail|required',
                'date_from' => 'bail|required',
                'date_to' => 'bail|required',
                'first_name' => 'bail|required',
                'last_name' => 'bail|required',
                'phone' => 'bail|required|min:10|max:14',
                'email' => 'bail|required|email',
                'confirmed' => ''
            ],
            ['room_id.required' => 'Сталася помилка, перезавантажте сторінку і спробуйте ще раз',
             'date_from.required' => 'Заповніть поля дати',
             'date_to.required' => 'Заповніть поля дати',
             'first_name.required' => "Укажіть ім'я",
             'last_name.required' => 'Укажіть прізвище',
             'phone.required' => 'Укажіть телефон',
             'phone.min' => 'Довжина поля телефону не менше 10 символів',
             'phone.max' => 'Довжина поля телефону не більше 14 символів',
             'email.required' => 'Укажіть електронну ардесу']);

            if($data->fails()){
                $response['status'] = false;
                $response['message'] = $data->errors();

                return $response;
            }

        $bookedRoom = BookedRoom::find($id);

        if ($bookedRoom) {

            $updated = $bookedRoom->update([
                'room_id' => $req->room_id,
                'first_name' => $req->first_name,
                'last_name' => $req->last_name,
                'email' => $req->email,
                'phone' => $req->phone,
                'confirmed' => $req->confirmed,
                'date_from' => $req->date_from,
                'date_to' => $req->date_to
            ]);
            $bookedRoom->fresh();
            $room = $bookedRoom->room;

            $response['status'] = true;
            $response['booked_room'] = $bookedRoom;
            $response['name_room'] = (!$room ? '' : $room->name);

            return $response;

        } else {
            $response['status'] = false;
            $response['message'] = 'Бронювання не знайдено, перезавантажте сторінку і спробуйте ще раз';

        return $response;
        }

    }
}
