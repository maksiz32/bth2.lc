<?php

namespace App\Http\Controllers;


class MyipController extends Controller
{
    public function __invoke() {
    $ip = getenv('REMOTE_ADDR');
        return view('ip.myip', ['ip' => $ip]);
    }
}
