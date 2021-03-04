<?php
namespace App;

use Adldap\Laravel\Facades\Adldap;
/**
 * Description of BryanskPortal
 *
 * @author MVManzulin
 */
class BryanskPortal {
    
    public function __construct() {
        if (session()->has('aduser')) {
            return true;
        } else {
            $userName = getenv('REMOTE_USER');
            $userRealName = Adldap::search()->users()->where('samaccountname', '=', $userName)->first();
            $userNameTMP = explode(" ", $userRealName['cn'][0]);
            $userName = $userNameTMP[0] . " " . $userNameTMP[1];
            $userPhotoTh = $userRealName->getThumbnailEncoded();
            $adGroups = $userRealName->getGroupNames($recursive = true);
            $mail = $userRealName['mail'][0];
            session(['aduser' => $userName, 'adphoto' => $userPhotoTh,
                'roles' => $adGroups, 'mail' => $mail]);
        }
    }
    
    public function hasRole($user, $role) {
        //$userADName = Adldap::search()->users()->where('samaccountname', '=', $user)->first();
        /*$adGroups = $userADName->getGroups();//Также есть getGroups() - выдает большую коллекцию
        if (count($adGroups)>1) {
            foreach ($adGroups as $key => $val){
            if (mb_strpos($val,$role)) {
                return true;
            }
            }
        }
        $adGroups = $userADName->getGroups();//Также есть getGroup() - выдает только группы пользователя
        foreach ($adGroups as $group) {
            if  (in_array($role, $group->cn)) {
                return true;
            } else if ($group->memberof) {
                foreach ($group->memberof as $member) {
                    if (mb_strpos($member, $role)) {
                    return true;
                    }
                }
            }
        }*/
        if (session()->has('aduser')) {
            $roles = session()->get('roles');
            foreach ($roles as $group) {
            if  ($role === $group) {
                return true;
            }
            }
        }
            return false;
    }
    
    public function isAdmin($user) {
        if($this->hasRole($user, "bryansk_portal_admins")) {
            return true;
        }
            return false;
    }
    
    public function isADAdmin($user) {
        if($this->hasRole($user, "Regional Admins")) {
            return true;
        }
            return false;
    }
    
    public function isEditor($user) {
        if($this->hasRole($user, "bryansk_portal_editors")) {
            return true;
        }
            return false;
    }
    
    public function isBryansk($user) {
        if($this->hasRole($user, "region_bryansk")) {
            return true;
        }
            return false;
    }
    
    public function getTumb($user) {
        if (session()->has('adphoto')) {
            $adphoto = session()->get('adphoto');
            return $adphoto;
        } else {
            //$userName = getenv('REMOTE_USER');
            $userRealName = Adldap::search()->users()->where('samaccountname', '=', $user)->first();
            $userPhotoTh = $userRealName->getThumbnailEncoded();
            session(['adphoto' => $userPhotoTh]);
            return $userPhotoTh;
        }
    }
    
    public static function getName($user) {
        if (session()->has('aduser')) {
            $aduser = session()->get('aduser');
            return $aduser;
        } else {
            //$userName = getenv('REMOTE_USER');
            $userRealName = Adldap::search()->users()->where('samaccountname', '=', $user)->first();
            $userNameTMP = explode(" ", $userRealName['cn'][0]);
            $userName = $userNameTMP[0] . " " . $userNameTMP[1];
            $userPhotoTh = $userRealName->getThumbnailEncoded();
            $adGroups = $userRealName->getGroupNames($recursive = true);
            $mail = $userRealName['mail'][0];
            session(['aduser' => $userName, 'adphoto' => $userPhotoTh,
                'roles' => $adGroups, 'mail' => $mail]);
            return $userName;
        }
    }

    public static function getEmail($user) {
        if (session()->has('mail')) {
            $mail = session()->get('mail');
            return $mail;
        } else {
            //$userName = getenv('REMOTE_USER');
            $userRealName = Adldap::search()->users()->where('samaccountname', '=', $user)->first();
            $userNameTMP = explode(" ", $userRealName['cn'][0]);
            $userName = $userNameTMP[0] . " " . $userNameTMP[1];
            $userPhotoTh = $userRealName->getThumbnailEncoded();
            $adGroups = $userRealName->getGroupNames($recursive = true);
            $mail = $userRealName['mail'][0];
            session(['aduser' => $userName, 'adphoto' => $userPhotoTh,
                'roles' => $adGroups, 'mail' => $mail]);
            return $mail;
        }
    }
    
    public static function canBookingCar($ip){
        $ip = ip2long($ip);
        $res = AccessIp::select('firms.name')
                ->join('firms','firms.id','=','access_ips.id_firms')
                ->where('isblock', 1)->where('ipStart','<',$ip)
                ->where('ipEnd','>',$ip)->first();
        if(count($res) > 0){
            //return $res->name;
            return true;
        }else{
            return false;
        }
    }
    
    public static function canDeleteBook($user, Booking $book){
        
        if($book->who == self::getName($user)){
            //return $res->name;
            return true;
        }else{
            return false;
        }
    }
    
    public static function nameDep($ip) {
        $ip = ip2long($ip);
        $res = Firm::select('name')->where('isblock', 1)->where('ipStart','<',$ip)
                ->where('ipEnd','>',$ip)->first();
        if(count($res) > 0){
            return $res->name;
        }else{
            return "Не Брянская область";
        }
    }
}
