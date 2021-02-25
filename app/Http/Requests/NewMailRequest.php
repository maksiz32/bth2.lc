<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'email' => 'required|email',
            'who' => 'required|string',
        ];
    }
    public function messages() {
        return [
            'email.required' => 'Адрес почты - это обязательное поле',
            'email.email' => 'Адрес почты должен быть введен корректно',
            'who.required' => 'Описание адреса - это обязательное поле',
            'who.string' => 'Описание адреса - это текстовое поле',
        ];
    }
}
