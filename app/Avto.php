<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avto extends Model
{
    protected $fillable = ['number','model','driver','phone_driver'];
}
