<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['firm','real_ip','created','tech','model','count_m','others'];
    protected $primaryKey = "id";
}
