<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photoorder;
use App\Http\Requests\PhotoorderRequest;
use DateTime;
use Illuminate\Support\Facades\Input;
use SplFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Mail;

class PhotoorderController extends Controller
{
    private $maxFilesUpload = 15;
    public function __construct()
    {
        $this->middleware('isADAdmin');
    }

    public function input($message = null) {
        $message = Input::get('message');
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

    public function pushPhotoToServer()
    {
        $netPath = '\\\\ktj-fs-01.rgs.ru\regions$\Кроссовые комнаты\Брянская область\Дирекция';
        // $netPath = '\\\\10.32.1.8\sys\запись$\Брянская область';
        $dirDate = date('m.Y', time());
        $letter = ['A', 'B', 'C'];
        foreach($letter as $let) {
            ${"arr".$let} = Photoorder::getPathImagesByLetter($let)->toArray();
        }
        foreach($letter as $let) {
            ${"arrKey".$let} = array_rand(${"arr".$let}, 3);
        }
        if(!file_exists("\"{$netPath}\\{$dirDate}\"")) {
            $commandLan = "mkdir \"{$netPath}\\{$dirDate}\"";
            $textPhp = iconv('UTF-8', 'cp1251', $commandLan);//Конвертирую в Windows-1251 (ANSI)
            exec($textPhp);
        }

        $pathMy = public_path().'/img/server/';
        $pathLan = "{$netPath}\\{$dirDate}";
        $pathLan = iconv('UTF-8', 'cp1251', $pathLan);//Конвертирую в Windows-1251 (ANSI)
        $sendedPhotos = "";
        foreach($letter as $let) {
            $sendedPhotos .= "{$let}: ";
            $sendedPaths = "";
            if (isset($newName)) {
                unset($newName);
            }
            foreach(${"arrKey".$let} as $arr) {
                $separator = (!isset($newName)) ? "" : ", ";
                $newName = uniqid() . uniqid();
                $ext = (new SplFileInfo($pathMy.${"arr".$let}[$arr]['path']))->getExtension();
                $sendedPaths .= $separator . $newName . '.' . $ext;
                copy($pathMy.${"arr".$let}[$arr]['path'], "{$pathLan}\\{$newName}.{$ext}");
            }
            $sendedPhotos .= $sendedPaths . "\r\n";
        }

        //НАДО ДОБАВИТЬ ОТПРАВКУ МЫЛА МНЕ, ЧТО ТАКИЕ-ТО ФОТКИ ВЫЛОЖЕНЫ УСПЕШНО
            $text = 'Фото серверной успешно вложены в папку ' . $dirDate . ':' . "\r\n" . "\r\n" . "\r\n" .
                $sendedPhotos . "\r\n" . "\r\n" . "\r\n" .
                'Не скучай!  ;-)';
            Mail::raw($text, function($formail) {
                $formail->from('report@bryansk.rgs.ru', "Фотоотчет");
                $formail->to(['it@bryansk.rgs.ru']);
                $formail->subject('Отправка фотоотчета серверной');
            });

        return redirect()->action('PhotoorderController@input', 
            ['message' => "Отчет был отправлен, проверяй!"]);
    }
}
