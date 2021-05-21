<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Birthday extends Model
{
    protected $fillable = ['nameF','nameN','nameOt','dolzh','work','date','photo','phone'];
    protected $primaryKey = "id";
    
    public static function monthM($id) {
        return DB::table('birthdays')
                ->select(DB::raw('MONTH(date) as month, DAY(date) as day'))
                ->where('birthdays.id', '=', $id)
                ->first();
    }

    public static function selectPhoneByName($nameSlice) {
        return Birthday::select('phone')->where('nameF', $nameSlice[0])
                        ->where('nameN', $nameSlice[1])->first();
    }
}
