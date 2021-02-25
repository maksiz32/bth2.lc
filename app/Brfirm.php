<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brfirm extends Model
{
    protected $fillable = ['skk','name','isblock'];
    protected $primaryKey = "skk";
}
