<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'phone' => 'bail|required|min:10|max:14',
            'email' => 'bail|required|email',
            'password' => ['required','min:6','confirmed','regex:/[a-z]/','regex:/[0-9]/'],
            'password_confirmation' => ''
        ];
    }

    public function messages()
    {
        return [
                'name.required' => "Заповніть ім'я",
                'name.min' => "Ім'я повинно мати не менше 3 символів",
                'phone.required' => 'Укажіть телефон',
                'phone.min' => 'Телефон повинен мати не менше 10 символів',
                'phone.max' => 'Телефон повинен мати не більше 14 символів',
                'email.required' => 'Заповніть поле для електронної адреси',
                'email.email' => 'Не правильний формат електронної адреси',
                'password.required' => 'Укажіть пароль',
                'password.min' => 'Пароль повинен включати мінімум 6 символів',
                'password.regex' => 'Пароль повинен включати хоча б одну літеру та цифру',
                'password.confirmed' => 'Паролі не збігаються'
            ];
    }
}
