<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Remain extends Model
{
    
    protected $fillable = ['tech_id','count'];
    protected $primaryKey = "id";
    
    public static function editRemain($id) {
        return DB::select("SELECT teches.tech, teches.model, remains.id as rem_id, teches.id as tech_id, remains.count FROM teches LEFT JOIN remains ON teches.id=remains.tech_id WHERE teches.id={$id}");
    }
    
    public static function newRem($request) {
        $rem = new Remain;
        $rem->tech_id = (int) $request->tech_id;
            $rem->count = (int) $request->count;
        if ($rem->save()) {
            $text = "Запись создана";
        } else {
            $text = "Ошибка создания записи";
        }
        return $text;
    }
    
    public static function editRem($request) {
        $rem = Remain::find($request->rem_id);
        $rem->count = (int) $request->count;
        if ($rem->save()) {
            $text = "Запись соохранена";
        } else {
            $text = "Ошибка сохранения записи";
        }
        return $text;
    }
}
