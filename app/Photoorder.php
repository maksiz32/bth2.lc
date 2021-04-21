<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photoorder extends Model
{
    protected $fillable = ['view','path'];
    protected $primaryKey = "id";

    public static function getCountImgs($letter) {
        return Photoorder::where('view', $letter)->count();
    }
}
