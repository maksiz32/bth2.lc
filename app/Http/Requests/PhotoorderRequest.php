<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\File\File;

class PhotoorderRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public static function validateOneImg($request) {
        $max_size = 1024*1024*1.5; //Не более 1.5 Mб файл
        // $message = "Разрешены изображения не более 1.5 Mб";
        $valid_mime = ['image/gif', 'image/jpeg', 'image/png', 'image/bmp'];
        if (($request->getClientSize() <= $max_size) && (in_array($request->getClientMimeType(), $valid_mime))) {
            return true;
        } else {
            return false;
        }
    }
    public static function isValidImg($request) {
        $validImgs = 0;
        if (gettype($request) === 'object') {
            (PhotoorderRequest::validateOneImg($request)) ? $validImgs++ : true;
        } else {
            foreach ($request as $obj) {
                (PhotoorderRequest::validateOneImg($obj)) ? $validImgs++ : true;
            }
        }
        return $validImgs;
    }
}
