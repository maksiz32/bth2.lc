<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photoorder;

class PhotoorderController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin')/*->except('listOuPersons')*/;
    }

    public function input() {
        $countI = Photoorder::getCountImgs('A');
        return view('server.input', ['countImgs' => $countI]);
    }
    public function inputAction(Request $request) {
        //TODO
    }
}
