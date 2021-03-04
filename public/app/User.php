<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Adldap\Laravel\Traits\HasLdapUser;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes, HasLdapUser;
    
    protected $fillable = [
        'name', 'email', 'role', 'password',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /*
    public static function oneUser($id) {
        return DB::table('users')->select('*')
                ->where('id', '=', $id)
                ->first();
    }
     * 
     */
    
    public static function showAllUsers() {
        return DB::table('users')->paginate(10);
    }
}
