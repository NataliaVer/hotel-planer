<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;

use App\Models\User;

class UsersController extends Controller
{
    public function singin() {
        return view('singin');
    }

     public function submit() {
        return view('submit');
    }

    public function create(StoreUserRequest $request) {

        // dd($request->name);

        $validated = $request->validated();

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
