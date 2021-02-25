<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class NewMail extends Model
{
    protected $guarded = [];
    protected $primaryKey = "id";
    
    public static function setMailNameSource($param) {
        switch ($param){
            case 1:
                return 'Уведомлений о Днях Рождения';
                break;
            case 2;
                return 'Уведомлений о заявке на авто';
                break;
        }
    }
    public function getMailNameSource($param) {
        switch ($param){
            case 'Дни Рождения':
                return 1;
                break;
            case 'Заявка на авто':
                return 2;
                break;
        }
    }
}
