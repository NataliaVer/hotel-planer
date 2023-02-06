<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\BookedRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function getroominformation(Room $room) {

        if (!$room) {
            $response['status'] = false;
            $response['information'] = 'Сталася помилка, кімнату не знайдено';
        }

        $user = $room->user;
        $hotel = $user->hotel;
        $photos = $user->photos;

        $response['status'] = true;
        $response['information'] = [
            'hotel_name' => $hotel->hotel_name,
            'address' => $hotel->city.', '.$hotel->settlement.', '.$hotel->street.', '.$hotel->number_house
        ];

        $newJSON = response()->json($response);
        return $newJSON;
        // dd($room);

    }

    public function bookingRoom(Request $req) {

        $data = Validator::make($req->all(), [
                'date_from' => 'bail|required',
                'date_to' => 'bail|required',
                'first_name' => 'bail|required',
                'last_name' => 'bail|required',
                'phone' => 'bail|required|min:10|max:14',
                'email' => 'bail|required|email'
            ],
            ['date_from.required' => 'Заповніть поля дати',
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

        $id = $req->post('id');

        $room = Room::find($id);

        if (!$room) {
            $response['status'] = false;
            $response['message'] = 'Кімнату не знайдено, перезавантажте сторінку і спробуйте ще раз';
        }

        // $boked_room = $room->boked_rooms()->create([
        //             'date_from' => '2023-01-05',
        //             'date_to' => '2023-01-10',
        //             'first_name' => 'Natalia6',
        //             'last_name' => 'Rybalka6',
        //             'email' => 'test146@example.com',
        //             'phone' => '+3801111116']);

        $boked_room = $room->booked_rooms()->create([
                'first_name' => $req->first_name,
                'last_name' => $req->last_name,
                'email' => $req->email,
                'phone' => $req->phone,
                'confirmed' => false,
                'date_from' => $req->date_from,
                'date_to' => $req->date_to
            ]);

        $response['status'] = true;
        $response['id'] = $room->id;

        return $response;
    }
}
