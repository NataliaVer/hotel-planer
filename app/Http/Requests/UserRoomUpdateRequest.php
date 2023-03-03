<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoomUpdateRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'amenities' => 'required',
            'count_one_bed' => '',
            'count_two_bed' => '',
            'count_rooms' => 'required',
            'room_photos' => ''
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Заповніть назву кімнати (Одномісний номер, Двомісний люкс і т.і.)',
            'name.max' => 'Занадто багато символів',
            'price.required' => 'Укажіть ціну',
            'description.required' => 'Укажіть ціну',
            'count_rooms.required' => 'Укажіть кількість кімнат даного виду в готелі'
        ];
    }
}
