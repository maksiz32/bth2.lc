<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{
    function removeDirectory($dir) {
        if ($objs = glob($dir."/*")) {
            foreach($objs as $obj) {
        is_dir($obj) ? removeDirectory($obj) : unlink($obj);
            }
        }
    @mkdir($dir);
    rmdir($dir);
    }
    function sizePhoto($idSize) {
        switch ($idSize) {
            case 0:
                $arrSize = [
                    'first' => 1200,
                    'second' => 1600
                ];
                return $arrSize;
                break;
            case 1:
                $arrSize = [
                    'first' => 768,
                    'second' => 1024
                ];
                return $arrSize;
                break;
            case 2:
                $arrSize = [
                    'first' => 600,
                    'second' => 800
                ];
                return $arrSize;
                break;
        }
    }
    public function input() {
        return view('images.input');
    }
    
    public function resize(ImageRequest $request) {
            $i=1;
            $dir = 'c:\\img-resize/';
            $this->removeDirectory($dir);
            @mkdir($dir, 0755);
        foreach ($request->img as $image) {
            $fileName = getenv('REMOTE_USER').'-'.$i.'.'.$image->getClientOriginalExtension();
            $h = Image::make($image)->height();
            $w = Image::make($image)->width();
            $sizeArr = $this->sizePhoto($request->size);
            $sizeMe = $sizeArr['first'];
            $sizeBig = $sizeArr['second'];
            if ($h >= $w) {
                $hB = Image::make($image)->resize($sizeMe,null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->height();
            while ($hB < $sizeBig) {
                $sizeMe+=50;
                $hB = Image::make($image)->resize($sizeMe,null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->height();
            }
                $imgMe = Image::make($image)->resize($sizeMe,null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($dir.$fileName, 100);
            } else {
                $hB = Image::make($image)->resize(null,$sizeMe, function ($constraint) {
                    $constraint->aspectRatio();
                    })->width();
            while ($hB < $sizeBig) {
                $sizeMe+=50;
                $hB = Image::make($image)->resize(null,$sizeMe, function ($constraint) {
                    $constraint->aspectRatio();
                    })->width();
            }
            $imgMe = Image::make($image)->resize(null,$sizeMe, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($dir.$fileName, 100);
            }
            $i++;
        }
        if(extension_loaded('zip')) {
// проверяем выбранные файлы
    $zip = new \ZipArchive(); // подгружаем библиотеку zip
    $zip_name = "RGS_MZ_".time().".zip"; // имя файла
    if($zip->open($zip_name, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE)!==TRUE) {
    die("cannot open {$zip_name} for writing.");
    }

    $iterator = new \DirectoryIterator($dir);
        foreach ($iterator as $file) {
            if ($file->isFile()) {
            $zip->addFile($dir.$file, $file); // добавляем файлы в zip архив
            }
        }
    $zip->close();
    if(file_exists($zip_name)) {
    
    return response()->download($zip_name)->deleteFileAfterSend(true);

// отда1-0 файл на скачивание
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="'.$zip_name.'"');
readfile($zip_name);
// удаля1-0 zip файл если он существует
unlink($zip_name);
}
}
    rmdir($dir);
    return redirect(url('/'));
    }
}
