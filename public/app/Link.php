<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['path','name'];
    protected $primaryKey = "id";
}
