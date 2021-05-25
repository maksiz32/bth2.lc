<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;

class Avto extends Model
{
    protected $fillable = ['number','model','driver','carphoto','phone_driver'];

    public static function savePhoto($photo) {
        $name = uniqid() . '.' . $photo->getClientOriginalExtension();
        Image::make($photo)->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path().'/img/car/'.$name, 100);
        return $name;
    }
}