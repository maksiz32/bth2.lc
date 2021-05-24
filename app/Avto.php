<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Avto extends Model
{
    protected $fillable = ['number','model','driver','carphoto','phone_driver'];

    public static function savePhoto($photo) {
        // dd($photo);
        $name = uniqid() . uniqid() . '.' . $photo->getClientOriginalExtension();
        // dd($photo);
        $t = Image::make($photo)->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path().'/img/car/'.$name, 100);
        dd($t);
    }
}