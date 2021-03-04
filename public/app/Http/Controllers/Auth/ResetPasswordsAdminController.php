<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordsAdminController extends Controller
{
    //use ResetsPasswords; //Просмотреть методы класса - надо ли его включать
    
    protected $redirectTo = '/';
    
    public function __construct()
    {
        $this->middleware('isadmin');
    }
      public function update(Request $request)
  {
    // Проверка длины пароля...

    $request->user()->fill([
      'password' => Hash::make($request->newPassword)
    ])->save();
  }
}
