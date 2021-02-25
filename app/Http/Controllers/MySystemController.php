<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Firm;
use App\Brfirm;
use Adldap\Laravel\Facades\Adldap;
use App\BryanskPortal;
use Mail;

class MySystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin')->except('search');
    }
    
    public function skk() {
        $skk = Firm::all('id', 'skk');
        foreach ($skk as $skk1) {
            Firm::where('id', $skk1->id)->update(['skk1' => $skk1->skk]);
        }
        return ('Ok');
    }
    
    public function innewbase() {
        $skk = Firm::all();
        foreach ($skk as $skk1) {
            Brfirm::create(['skk' => $skk1->skk, 'name' => $skk1->name, 'isblock' => $skk1->isblock]);
        }
        return ('Ok');
    }
    
    public function test() {
        $name = 'Ya!';
        $email = BryanskPortal::getEmail(getenv('REMOTE_USER'));
        $text = 'Booking avto'."\r\n"."\r\n".
                'From User'."\r\n".
                'Avto'."\r\n".'To'."\r\n".
                'Driver'."\r\n".
                'Date'."\r\n".'Time start'."\r\n".'Time end';
        Mail::raw($text, function($formail) use($email, $name){
            $formail->from('report@bryansk.rgs.ru', 'Booking avto');
            $formail->to(['maks-manzulin@mail.ru', $email]);
            $formail->subject('Booking avto AVTO from USER '.$name);
        });
     
        return view('mysystemutil.test');
    }
    
}
