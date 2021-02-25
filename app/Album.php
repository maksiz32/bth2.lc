<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['path','name','show'];
    protected $primaryKey = "id";
}
