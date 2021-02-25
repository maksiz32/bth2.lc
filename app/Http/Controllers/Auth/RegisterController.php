<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;
    
    protected $redirectTo = '/';
    
    public function __construct()
    {
        $this->middleware('isadmin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => bcrypt($data['password']),
        ]);
    }
    protected function edit($id)
    {
        return view("auth.edit", ["user" => User::find($id)]);
    }
    
    public function allUsers() {
        return view('auth.allusers', ['users' => User::paginate(10)]);
    }
        
    protected function saveOne(UserRequest $request)
    {
        $arrUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        DB::table('users')->where('id', $request->id)->update($arrUpdate);
        return view("auth.allusers", ['users' => User::showAllUsers()]);
    }
    
    protected function chPass($id) {
        return view('auth.passwords.resetadm', ['user' => User::find($id)]);
    }
    //Создаем правила валидации
    public function admin_credential_rules(array $data) {
  $messages = [
    'password.required' => 'Введите пароль',
    'password_confirmation.required' => 'Введите пароль'
  ];

  $validator = Validator::make($data, [
    'password' => 'required|same:password',
    'password_confirmation' => 'required|same:password',     
  ], $messages);

  return $validator;
  }
  //Создаем действие
  public function postCredentials(Request $request)
{
  if(Auth::Check())
  {
    $request_data = $request->All();
    $validator = $this->admin_credential_rules($request_data);
    if($validator->fails()) {
      return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
    } else {        
        $user_id = $request->id;                       
        $obj_user = User::find($user_id);
        $obj_user->password = Hash::make($request_data['password']);;
        $obj_user->save(); 
        return redirect()->to("/allusers")->with("status", "Пароль пользователя ".$user->name."изменен.");
    }        
  }
  else
  {
    return redirect()->back()->with("error", "Ошибка при вводе пароля");
  }    
}

    protected function delete(User $id){
        $name = $id->name . " " . $id->role;
        $id->delete();
        return redirect()->back()->with("status", "Запись о " . $name . " удалена");        
    }
}
