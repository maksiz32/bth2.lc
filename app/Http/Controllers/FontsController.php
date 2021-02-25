<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Font;

class FontsController extends Controller
{
    public function __invoke() {
        $myFonts = Font::orderBy('name')->get();
        return view('myfonts.font',['myfonts' => $myFonts]);
    }
}
