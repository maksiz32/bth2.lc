<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessIp extends Model
{
    protected $fillable = ['id_firms'];
    protected $primaryKey = "id";
}
