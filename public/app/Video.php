<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['file','name'];
    protected $primaryKey = "id";
}
