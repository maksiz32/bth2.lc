<?php
namespace App\Http\Controllers;

use App\Birthday;
use App\Email;
use Illuminate\Support\Facades\DB;

class AllController extends Controller
{
    public function __invoke($mounth = null) {
        if ($mounth === null) {
        return view("dop.all", ["notes" => Birthday::orderBy('nameF')->paginate(10), 
            "mounth" => $mounth, "mail" => Email::first()]);
        } else {
        return view("dop.all", ["notes" => Birthday::select(DB::raw('*, DAY(date) as day'))->whereMonth('date', $mounth)->orderBy('day')->paginate(100), 
            "mounth" => $mounth, "mail" => Email::first()]);
        /*
        return view("dop.all", ["notes" => Birthday::whereMonth('date', $mounth)->orderBy('date')->paginate(10), 
            "mounth" => $mounth, "mail" => Email::first()]);
         * 
         */
        }        
    }
}
