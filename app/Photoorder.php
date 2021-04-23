<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\File;
use Intervention\Image\ImageManagerStatic as Image;

class Photoorder extends Model
{
    protected $fillable = ['view','path'];
    protected $primaryKey = "id";

    public static function getCountImgs($letter) {
        return Photoorder::where('view', $letter)->count();
    }

    public static function getPathImagesByLetter($letter) {
        return Photoorder::select('path')->where('view', $letter)->get();
    }

    public static function saveAllPics($request, $letter) {
        if (gettype($request) === 'object') {
            //
        } else {
            foreach($request as $image) {
                $time_r = time();
                $name = $time_r . uniqid() . '.' . $image->getClientOriginalExtension();
                $name2 = 'tmb_' . $name;
                // $image->storeAs('img/albums/'.$id.'/', $name, 'my_files');
                Image::make($image)->resize(800, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path().'/img/server/'.$name, 100);
                Image::make($image)->resize(120, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path().'/img/server/'.$name2, 100);
                $createArr = [
                    'view' => $letter,
                    'path' => $name
                ];
                $isCreate = Photoorder::create($createArr);
                // $path = $request->pic->storeAs('img/server', $name, 'my_files');
            }
            dd($createArr);
        }
    }
}
