<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use App\NewMail;
use App\Http\Requests\NewMailRequest;

class AddrEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin')->only(['index','save']);
        $this->middleware('isADEditor')->except(['index','save']);
    }
    
    public function index()
    {
        //В другой таблице БД
        return view("emails.email", ["mail" => Email::all()]);
    }
    
    public function save(Request $request)
    {
        Email::truncate();
        //Делаю создание вместо обновления - просто так для примера
        Email::create(["email" => $request->email]);
        return redirect()->back()->with("status", "Адрес рассылки изменен на"
                .'<br/><span class="badge badge-success">'.$request->email
                ."</span>");
    }
    
    public function main() {
        return view('emails.new_main', ['emails' => NewMail::all()]);
    }
    
    public function edit($id) {
            $request = NewMail::find($id);
        return view('emails.new_input', ['mail' => $request]);
    }
    
    public function saveNew(NewMailRequest $request) {
        if ($request->has('id')){
            $r = NewMail::find($request->id);
            $mes = 'изменен';
        } else {
            $r = new NewMail;
            $mes = 'добавлен';
        }
            $r->email = $request->email;
            $r->who = $request->who;
        $r->save();
        return redirect(action('AddrEmailController@main'))->with('success', 
                'Адрес '.$mes);
    }
    
    public function delete($id) {
        $r = NewMail::find($id);
        $r->delete();
        return redirect(action('AddrEmailController@main'))->with('success', 
                'Адрес удалён');
    }
}
