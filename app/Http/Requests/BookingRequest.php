<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'target' => 'required|string|max:255',
            'id_avto' => 'required|integer',
            'date' => 'required',
            'time_start' => 'required|integer',
            'count_time' => 'required|integer',
            'phone' => 'digits:10',
        ];
    }
    public function messages() {
        return [
            'target.required' => 'Направление и цель поездки - это обязательное поле',
            'target.string' => 'Направление и цель поездки - это текстовое поле',
            'target.max' => 'Направление и цель поездки - введите менее 255 знаков',
            'id_avto.required' => 'Автомобиль - это обязательное поле',
            'id_avto.integer' => 'Автомобиль - ошибка ввода (внутренняя)',
            'date.required' => 'Дата поездки - это обязательное поле',
            'time_start.required' => 'Время начала поездки - это обязательное поле',
            'time_start.integer' => 'Время начала поездки - ошибка ввода (внутренняя)',
            'count_time.required' => 'Количество часов поездки - это обязательное поле',
            'count_time.integer' => 'Количество часов поездки - ошибка ввода (внутренняя)',
            'phone.digits' => 'В поле телефон введите 10 цифр, прим. 9101112233',
        ];
    }
}
