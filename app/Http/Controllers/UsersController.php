<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UsersController extends Controller
{
    public function singin() {
        return view('singin');
    }

     public function submit() {
        return view('submit');
    }

    public function create(Request $request) {

        // dd($request->name);

        $validated = $request->validate([
            'name' => 'required|min:3',
            'phone' => 'bail|required|min:10|max:14',
            'email' => 'bail|required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => ''
        ],
        [
            'name.required' => "Заповніть ім'я",
            'name.min' => "Ім'я повинно мати не менше 3 символів",
            'phone.required' => 'Укажіть телефон',
            'phone.min' => 'Телефон повинен мати не менше 10 символів',
            'phone.max' => 'Телефон повинен мати не більше 14 символів',
            'email.required' => 'Заповніть поле для електронної адреси',
            'email.email' => 'Не правильний формат електронної адреси',
            'password.required' => 'Укажіть пароль',
            'password.confirmed' => 'Паролі не збігаються'
        ]);

        User::create([
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'password'      => $request->password,
            'remember_token'=> $request->remember_token
        ]);

        return view('singin');
    }

    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //dd($credentials);

        if (Auth::attempt($credentials, true)) {

            $request->session()->regenerate();

            return redirect()->intended('/');            
        }

        return back()->withErrors([
                'message' => 'Електронна адреса або пароль неправильні, спробуйте ще раз'
            ]);
    }

    public function logout(Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

         return redirect('/');
    }
}
