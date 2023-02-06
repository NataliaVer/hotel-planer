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

class OfficeController extends Controller
{
    public function useroffice() {
        if (Auth::check()) {
            return view('useroffice');
        }
    }

    public function userofficeEdit() {
        if (Auth::check()) {
            
            return view('useredit');
        }
    }

    public function userofficeUpdate() {
        if (Auth::check()) {
            $user = Auth::user();

            $data = request()->validate([
                'phone' => 'bail|required|min:10|max:14',
                'email' => 'bail|required|email'
            ],
            [
                'phone.required' => 'Укажіть телефон',
                'phone.min' => 'Довжина поля телефону не менше 10 символів',
                'phone.max' => 'Довжина поля телефону не більше 14 символів',
                'email.required' => 'Укажіть електронну ардесу',
                'email.email' => 'Введіть корректну електронну адресу'
            ]);

            $user->update($data);

            return redirect()->route('useroffice');

            //тут також потрібно буде додати зміну пароля

        }
    }

    public function userofficecheckPassword(Request $request) {
        // $pass = $request->post('password');

        if (! Hash::check($request->password, $request->user()->password)) {
            $response['status'] = false;
            $response['message'] = 'Пароль не збігається з поточним';

            return $response;
        }

        $response['status'] = true;
        $response['message'] = 'Ok';

        return $response;
    }

    public function userofficeUpdatePass(Request $request) {
        //валідація пароля і збереження в бд
        $user = Auth::user();

        $data = Validator::make($request->all(),[
            'password' => 'required|confirmed',
            'password_confirmation' => ''
        ],
        [
            'password.required' => 'Укажіть пароль',
            'password.confirmed' => 'Паролі не збігаються'
        ]);

        if($data->fails()){
                $response['status'] = false;
                $response['message'] = $data->errors();

                return $response;
            }

        $user->update([
            'password'      => $request->password
        ]);

        Auth::logout();

        $response['status'] = true;
        $response['message'] = 'Пароь успішно змінено';

        return $response;
    }

}
