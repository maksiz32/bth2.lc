<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'path' => 'required',
            'name' => 'required',
        ];
    }
    
    public function messages() {
        return [
            'path.required' => 'Это обязательное поле',
            //'path.url' => 'Поле должно содержать только быть URL адресом',
            'name.required' => 'Это обязательное поле',
        ];
    }
}
