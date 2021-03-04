<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['id_albums','photo'];
    protected $primaryKey = "id";
}
