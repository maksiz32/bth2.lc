<?php
namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use Adldap\Models\User as UserModel;
use Illuminate\Support\Arr;

class GeneratePasswordsController extends Controller
{
    public function __invoke() {
        $userName = getenv('REMOTE_USER');
        $userRealName = Adldap::search()->users()->where('samaccountname', '=', $userName)->first();
        $thumb = $userRealName->getGroup();//Также есть getGroups() - выдает большую коллекцию
        foreach ($thumb as $key => $val){
        if (mb_strpos($val,"bryansk_portal_admins")) {
        //return true;
        }
        }
        return view('genpass.main', ['userRealName' => $userRealName, 'thumb' => $thumb]);
    }
}
