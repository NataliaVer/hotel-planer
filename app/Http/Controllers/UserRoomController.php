<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Photo;

class UserRoomController extends Controller
{

    public function userrooms() {
        if (Auth::check()) {
            $user = Auth::user();
            $hotel = $user->hotel;
            $rooms = $user->rooms;
            $photos = $user->photos;

            //dd($rooms);

            return view('userrooms', compact('rooms', 'photos', 'hotel'));
        }
    }

    public function userroomCreate() {
        $user = Auth::user();
        $hotel = $user->hotel;

        return view('uploaduserrooms', compact('hotel'));
    }

    public function userroomStore() {
        $user = Auth::user();
        $hotel = $user->hotel;

        $data = request()->validate([
            'name' => 'required|max:150',
            'price' => 'required',
            'description' => 'required',
            'amenities' => '',
            'count_one_bed' => '',
            'count_two_bed' => '',
            'count_rooms' => 'required',
            'room_photos' => 'required',
            'hotel_id' => ''
            ],
            ['name.required' => 'Заповніть назву кімнати (Одномісний номер, Двомісний люкс і т.і.)',
             'name.max' => 'Занадто багато символів',
             'price.required' => 'Укажіть ціну',
             'description.required' => 'Укажіть ціну',
             'count_rooms.required' => 'Укажіть кількість кімнат даного виду в готелі',
             'room_photos.required' => 'Додайте фото для кімнати'
         ]);

        $room = new Room($data);
        //dd($room);

        $user->rooms()->save($room);

        $room->fresh();

        if(request()->hasFile('room_photos')) {
            $photos = request()->room_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'room_photos'];

            for($i=0;$i<count($photos);$i++) {
                // dd($photos[$i]);
                // die();
                $fileName = time() . '_' . $photos[$i]->hashName();
                // $extension = $photos[$i]->extension();
                $path = $photos[$i]->storeAs('images', $fileName, 'public');
                $photoData['photo'] = '/storage/'.$path;
                Photo::create($photoData); //createMany
                // $uploadPhoto[] = $photoData;
            }
        }

        return redirect()->route('userrooms');
    }

    public function userroomEdit(Room $room){

        $user = Auth::user();
        $hotel = $user->hotel;

        return view('edituserroom', compact('room', 'hotel'));

    }

    public function userroomUpdate(Room $room) {

        $user = Auth::user();
        $hotel = $user->hotel;

        $data = request()->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'amenities' => 'required',
            'count_one_bed' => '',
            'count_two_bed' => '',
            'count_rooms' => 'required',
            'room_photos' => ''
            ],
            ['name.required' => 'Заповніть назву кімнати (Одномісний номер, Двомісний люкс і т.і.)',
             'name.max' => 'Занадто багато символів',
             'price.required' => 'Укажіть ціну',
             'description.required' => 'Укажіть ціну',
             'count_rooms.required' => 'Укажіть кількість кімнат даного виду в готелі'
         ]);

        //dd($data);

        $room->update($data);

            if(request()->hasFile('room_photos')) {
            $photos = request()->room_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'room_photos'];


            $photos = $room->photos;
            foreach ($photos as $photo) {

                if (File::exists(mb_substr($photo->photo,1))) {
                        unlink(public_path($photo->photo));
                    }
            }

            // $photo = $user->photos()->where('kind_photo', 'room_photos')->where('room_id', $room->id)->delete();
            $photo = $room->photos()->delete();

            for($i=0;$i<count($photos);$i++) {
                $fileName = time() . '_' . $photos[$i]->hashName();
                // $extension = $photos[$i]->extension();
                $path = $photos[$i]->storeAs('images', $fileName, 'public');
                $photoData['photo'] = '/storage/'.$path;
                Photo::create($photoData); //createMany
            }
            // dd($uploadPhoto);
            // Photo::createMany($uploadPhoto);
        }

        return redirect()->route('userrooms');
    }

    public function userroomDestroy(Room $room) {
        //видалити кімнату можна, якщо для неї не створено бронювань,
        //тут можна буде зробити розділення прав, і додати можливість
        //видалення всіх данних, лише для адміна

        $booked_rooms = $room->booked_rooms;

        if(!$booked_rooms == null && !count($booked_rooms)>0) {
            //видалити разом з фото
            $photos = $room->photos;
            foreach ($photos as $photo) {
                if (File::exists(mb_substr($photo->photo,1))) {
                        unlink(public_path($photo->photo));
                    }
            }

            $photo = $room->photos()->delete();
            $room->delete();

            // return redirect()->route('userrooms');
            $response['status'] = true;
            $response['message'] = 'Кімнату успішно видалено';
            return $response;
        }
        
        // return back()->withErrors([
        //         'message' => 'Неможливо видалити кімнату, для неї є бронювання'
        //     ]);

        $response['status'] = false;
        $response['message'] = 'Неможливо видалити кімнату, для неї є бронювання';
        return $response;
    }
}
