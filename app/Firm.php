<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    protected $fillable = ['name','nameEng','skk','isblock','nameNSO','famNSO','otchNSO','ipStart','ipEnd','addr','tel'];
    protected $primaryKey = "id";
}
