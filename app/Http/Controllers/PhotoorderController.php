<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photoorder;
use App\Http\Requests\PhotoorderRequest;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\File;

class PhotoorderController extends Controller
{
    private $maxFilesUpload = 15;
    public function __construct()
    {
        $this->middleware('isADAdmin')/*->except('listOuPersons')*/;
    }

    public function input($message = null) {
        $countI = Photoorder::getCountImgs('A');
        $imagesPath = Photoorder::getPathImagesByLetter('A');
        return view('server.input', ['countImgs' => $countI, 
            'images' => $imagesPath, 'message' => $message]);
    }
    public function inputAction(Request $request) {
        $countUploads = 0;
        $imgs = Input::file('pic');
        if (count($imgs) > $this->maxFilesUpload - 1) {
            array_splice($imgs, $this->maxFilesUpload - 1, 
                count($imgs) - $this->maxFilesUpload);
        }
        $countUploads = PhotoorderRequest::isValidImg($imgs);
        if ($countUploads > 0) {
            if (!file_exists(public_path('img/server'))) {
                @mkdir(public_path('img/server'), 0755);
            }
            $letter = $request->view;
            Photoorder::saveAllPics($imgs, $letter);
        } else {
            return redirect()->action('PhotoorderController@input', 
                ['message' => 'Добавляемые данные не прошли проверку']);
        }
        return redirect()->action('PhotoorderController@input', 
            ['message' => "Добавлены фотографии в тип {$letter}"]);
    }
    public function changeViewImg($var) {
        $count = Photoorder::getCountImgs($var);
        $images = Photoorder::getPathImagesByLetter($var);
        $arr = [
            "count" => $count,
            "imgs" => $images
        ];
        $req = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $req;
    }
}
