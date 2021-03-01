<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'id' => 'integer',
            'category' => 'required',
        ];
    }
    public function messages() {
        return [
            'id.integer' => 'Идентификатором может быть только число',
            'category.required' => 'Категория - это обязательное поле',
        ];
    }
}
