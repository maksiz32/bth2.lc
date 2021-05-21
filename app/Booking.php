<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['id_avto','who','target','ip','phone','date',
        'time_start','count_time'];
    protected $primaryKey = "id";

    public static function selectAllDataByMounthAndDay($forBook) {
        return Booking::select('bookings.id as id', 'bookings.date', 'bookings.who',
                                'bookings.target', 'bookings.phone', 'bookings.time_start',
                                'count_time', 'avtos.number', 'avtos.model', 'avtos.driver',
                                'avtos.phone_driver', 'avtos.id as avid')
                        ->join('avtos', 'avtos.id', '=', 'bookings.id_avto')
                        ->whereMonth('bookings.date', $forBook['m'])
                        ->whereYear('bookings.date', $forBook['y'])
                        ->orderBy('bookings.date', 'desc')->get();
    }

    public static function getAvtosByDay($date) {
        return Booking::join('avtos', 'avtos.id', '=', 'bookings.id_avto')
                        ->where('bookings.date', $date)->get();
    }

    public static function getOneAvtoByDayAndAvtoId($date, $idAvto) {
        return Booking::where('date', $date)
                        ->where('id_avto', $idAvto)->get();
    }
}
