<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
    
    public function rules()
    {
        return [
            'img.*' => 'image',
        ];
    }
    
    public function messages() {
    return [
            'img.image' => 'Попытка отправить не-изображение',
        ];
    }
}
