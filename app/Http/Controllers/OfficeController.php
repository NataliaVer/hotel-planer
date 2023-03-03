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

use App\Http\Requests\userofficeUpdateRequest;

class OfficeController extends Controller
{
    public function useroffice() {

            return view('useroffice');

    }

    public function userofficeEdit() {
            
            return view('useredit');
    }

    public function userofficeUpdate(userofficeUpdateRequest $request) {

            $user = Auth::user();

            $data = $request->validated();

            $user->update($data);

            return redirect()->route('useroffice');

    }

    public function userofficecheckPassword(Request $request) {

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
