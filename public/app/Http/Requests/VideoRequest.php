<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            //'file' => 'mimetypes:video/avi,video/mpeg,video/quicktime',
        ];
    }
    
    public function messages() {
    return [
            'name.required' => 'Это обязательное поле',
            //'file.mimetypes' => 'Разрешены только видеофайлы',
        ];
    }
}
