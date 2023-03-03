<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userofficeUpdateRequest extends FormRequest
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
            'phone' => 'bail|required|min:10|max:14',
            'email' => 'bail|required|email'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Укажіть телефон',
            'phone.min' => 'Довжина поля телефону не менше 10 символів',
            'phone.max' => 'Довжина поля телефону не більше 14 символів',
            'email.required' => 'Укажіть електронну ардесу',
            'email.email' => 'Введіть корректну електронну адресу'
         ];
    }
}
