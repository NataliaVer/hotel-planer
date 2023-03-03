<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserHotelUpdateRequest extends FormRequest
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
            'hotel_name' => 'required',
            'country' => 'bail|required|max:50',
            'city' => 'required',
            'settlement' => 'required',
            'street' => 'required',
            'number_house' => 'required',
            'phone' => 'bail|required|min:10|max:14',
            'aditional_services' => 'required',
            'description' => 'required',
            'time_of_settlement' => 'required',
            'time_of_eviction' => 'required',
            'baground_photo' => '',
            'all_photos' => ''
            ];
    }

    public function messages()
    {
        return [
            'hotel_name.required' => 'Заповніть назву готелю',
             'country.required' => 'Укажіть країну',
             'country.max' => 'Назва країни не повинна перевищувати 50 символів',
             'city.required' => 'Укажіть місто',
             'settlement.required' => "Укажіть населений пункт",
             'street.required' => 'Заповніть вулицю',
             'number_house.required' => 'Укажіть номер будинку',
             'phone.required' => 'Укажіть номер телефону',
             'phone.min' => 'Довжина поля телефону не менше 10 символів',
             'phone.max' => 'Довжина поля телефону не більше 14 символів',
             'aditional_services.required' => 'Заповніть додаткові послуги, наприклад: wi-fi, кафе, бар, басейн',
             'description.required' => 'Додайте опис свого готелю',
             'time_of_settlement.required' => 'Укажіть час заселення до готелю (якщо не має регламентованого, то укажіть 00:00)',
             'time_of_eviction.required' => 'Укажіть час виселення з готелю (якщо не має регламентованого, то укажіть 00:00)'
         ];
    }
}
