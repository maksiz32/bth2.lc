<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tech extends Model
{
    protected $fillable = ['photo','tech','model','category'];
    protected $primaryKey = "id";
}
