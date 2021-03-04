<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['id_avto','who','target','ip','phone','date',
        'time_start','count_time'];
    protected $primaryKey = "id";
}
