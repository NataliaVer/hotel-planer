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

use App\Http\Requests\UserHotelStoreRequest;
use App\Http\Requests\UserHotelUpdateRequest;

class UserHotelController extends Controller
{

    public function userhotel() {
        // if (Auth::check()) {
            $user = Auth::user();
            $hotel = $user->hotel;
            $photos = $user->photos;

            //dd($hotels);
            
            return view('userhotel', compact('hotel', 'photos'));
        // }
    }

    public function userhotelCreate() {
        return view('uploaduserhotel');
    }

    public function userhotelStore(UserHotelStoreRequest $request) {
        $user = Auth::user();

        $data = $request->validated();

        $hotel = $user->hotel()->create($data);
        $hotel->fresh();

        if($request->hasFile('baground_photo')) {
            // dd($data);
            // die();
            $photoData = [
                'user_id' => $user->id,
                'hotel_id' => $hotel->id,
                'photo' => '',
                'kind_photo' => 'baground_photo'];
            $fileName = time().$request->file('baground_photo')->hashName();
            $path = $request->file('baground_photo')->storeAs('images', $fileName, 'public');
            $photoData['photo'] = '/storage/'.$path;
            Photo::create($photoData);
        }

        if($request->hasFile('all_photos')) {
            $photos = $request->all_photos;
            // dd($request->all_photos[0]);
            $photoData = [
                    'user_id' => $user->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'all_photos'];

            for($i=0;$i<count($photos);$i++) {
                // dd($photos[$i]);
                $fileName = time() . '_' . $photos[$i]->hashName();
                $path = $photos[$i]->storeAs('images', $fileName, 'public');
                $photoData['photo'] = '/storage/'.$path;
                Photo::create($photoData); //createMany
                // $uploadPhoto[] = $photoData;
            }
        }

        return redirect()->route('userhotel');
    }

    public function userhotelEdit(Hotel $hotel) {
        //dd($hotel->hotel_name);

        return view('edituserhotel', compact('hotel'));
    }

    public function userhotelUpdate(UserHotelUpdateRequest $request, Hotel $hotel) {

        $user = Auth::user();

        $data = $request->validated();

        $hotel->update($data);

        if($request->hasFile('baground_photo')) {
            // dd($data);
            // die();
            $photoData = [
                'user_id' => $user->id,
                'hotel_id' => $hotel->id,
                'photo' => '',
                'kind_photo' => 'baground_photo'];
            $fileName = time().$request->file('baground_photo')->hashName();
            $path = $request->file('baground_photo')->storeAs('images', $fileName, 'public');
            $photoData['photo'] = '/storage/'.$path;

            $photo = $user->photos()->where('kind_photo', 'baground_photo')->first();
            //опрацювати видалення файлів
            if($photo) {
                if (File::exists(mb_substr($photo->photo,1))) {
                    unlink(public_path($photo->photo));
                }
                $photo->update($photoData);
            } else {
                Photo::create($photoData);
            }
        }
        if($request->hasFile('all_photos')) {
            // $uploadPhoto = [];
            $photos = $request->all_photos;
            // dd($request->all_photos[0]);
            $photoData = [
                    'user_id' => $user->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'all_photos'];

            $photos_old = $user->photos()->where('kind_photo', 'all_photos')->get();

            foreach ($photos_old as $photo) {
                if (File::exists(mb_substr($photo->photo,1))) {
                    unlink(public_path($photo->photo));
                }
            }
            $photos_old_del = $user->photos()->where('kind_photo', 'all_photos')->delete();

            for($i=0;$i<count($photos);$i++) {
                // dd($photos[$i]);
                $fileName = time() . '_' . $photos[$i]->hashName();
                $path = $photos[$i]->storeAs('images', $fileName, 'public');
                $photoData['photo'] = '/storage/'.$path;
                Photo::create($photoData); //createMany
                // $uploadPhoto[] = $photoData;
            }
            // dd($uploadPhoto);
            // Photo::createMany($uploadPhoto);
        }
        

        return redirect()->route('userhotel');
    }


    public function userhotelDestroy(Hotel $hotel) {
        //видалити готель можна, якщо для нього не створено бронювань,
        //тут можна буде зробити розділення прав, і додати можливість
        //видалення всіх данних, лише для адміна

        //спочатку перевіримо чи є бронювання на даному готелі
        $room_ids = $hotel->rooms->pluck('id')->toArray();
        $booked_rooms = DB::table('booked_rooms')->whereIn('room_id', $room_ids)
                                                 ->count();
        // dd($booked_rooms);

        if(!$booked_rooms>0) {
            //видалити разом з фото
            $rooms = $hotel->rooms;

            foreach ($rooms as $room) {
                $photos = $hotel->photos;
                foreach ($photos as $photo) {
                    if (File::exists(mb_substr($photo->photo,1))) {
                        unlink(public_path($photo->photo));
                    }
                }
                $room->photos()->delete();
            }

            $hotel->rooms()->delete();
            $hotel->photos()->delete();
            $hotel->delete();

            // return redirect()->route('userhotel');
            $response['status'] = true;
            $response['message'] = 'Готель успішно видалено';
            return $response;
        }
        
        // return back()->withErrors([
        //         'message' => 'Неможливо видалити готель, для нього є бронювання'
        //     ]);
        $response['status'] = false;
        $response['message'] = 'Неможливо видалити готель, для нього є бронювання';
        return $response;

    }

}
