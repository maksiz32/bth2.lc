<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
     * 
     */

    public function index()
    {
        
        return view('home');
    }

    public function menuBth()
    {
        return view('home2');
    }

    public function noGroupAccess()
    {
        return view('sorry');
    }
    
}
