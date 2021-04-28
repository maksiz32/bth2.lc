<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Cript;

class AdWorkController extends Controller
{
    //Задаю общие переменные
    //Переменная префикса пути
    private $mainOuPath = "rgs.ru/Structure/ПАО Росгосстрах/Филиал ПАО Росгосстрах в Брянской области";
    
    //Переменная Фильтра2 (персоналии)
    private $filter2 = '(&(objectcategory=Person)(!(userAccountControl=514))'
        . '(!(userAccountControl=66050))(!(title=Страховой агент))'
        . '(!(title=Специалист по исследованию рынка))'
        . '(!(title=Страховой консультант))'
        . '(!(title=Tech))'
        . '(!(title=Разнорабочий))'
        . '(!(title=Уборщик))'
        . '(!(title=Уборщица))'
        . '(!(title=Охранник))'
        . '(!(title=Дворник))'
        . '(!(title=Водитель))'
        . '(!(title=Генеральный директор))'
        . '(!(givenname=Scan*)))';
    //Набираю все данные из домена по OU
    private function get_filter($company) {
        return '(&(objectcategory=organizationalUnit)'
        . '(&(!(ou='.$company.'))'
        . '(!(name=Groups))'
        . '(!(name=Inactive))'
        . '(!(name=Servers))'
        . '(!(name=Service Accounts))'
        . '(!(name=Scan))'
        . '(!(name=Технэкспро))))';
    }

    //Папка для сохранения подписей в виде html-страниц
    private $dir = "k:/Signatures/";

    public function __construct()
    {
        $this->middleware('isADAdmin')->only('listOuPersons', 'adViewEditPhoto', 
                                        'adViewEdit', 'adPhoto');
    }
    
    function removeDirectory($directory) {
        //Очищает все внутри переданной директории (папки и файлы), а затем и саму 
        //директорию пересоздает
            if ($objs = glob($directory."/*")) {
                foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
                }
            }
        @mkdir($directory);
        rmdir($directory);
    }    

    function LDAPSearch($ldapuser, $ldappass, $base_dn, $filter, $justthese) {
        $ldappass = decrypt($ldappass);
        //Можно через главный контроллер Домена - rgs-rootdc-01.rgs.ru
        $ds=ldap_connect("brn-dc.rgs.ru");  // LDAP сервер
            if (!$ds) {
                return view ('adirectory.errad')->with('message', 'Недоступен контроллер домена');
            } else { //If the server is correct and avalaible
                if (!@ldap_bind($ds, $ldapuser, $ldappass)) { //привязка LDAP with Password
                    ldap_close($ds);
                    return view ('adirectory.errad')->with('message', 'Некорректный пароль');
                } else {
            $ouRegions = ldap_search($ds, $base_dn, $filter, $justthese) or die ("Error in search query: ".ldap_error($ds));
            $ouRegions = ldap_get_entries($ds, $ouRegions);
                unset($ouRegions['count']);
            ldap_close($ds);
                return $ouRegions;
            }
        }
    }

    function LDAPModify ($ldapuser, $ldappass, $modification) {
        $ldappass = decrypt($ldappass);
        //Можно через главный контроллер Домена - rgs-rootdc-01.rgs.ru
        $ds=ldap_connect("brn-dc.rgs.ru");  // LDAP сервер
        if (!$ds) {
            return view ('adirectory.errad')->with('message', 'Недоступен контроллер домена');
        } else { //If the server is correct and avalaible
            if (!@ldap_bind($ds, $ldapuser, $ldappass)) { //привязка LDAP with a Password
                ldap_close($ds);
                    return false;
            } else {
    //Сохраняю данные 
            foreach($modification as $arrModify1) {
                if ($arrModify1) {
                    $myDN = $arrModify1['dn'];
                    unset($arrModify1['dn']);
                        foreach ($arrModify1 as $key=>$value) {
                            if (!is_array($value)) {
                                $arrModify = array($key => $value);
                                ldap_mod_replace($ds, $myDN, $arrModify);
                            } else {
                                $arrModify[$key] = array();
                                @ldap_mod_del($ds, $myDN, $arrModify);
                            }
                        }
                }
            }
            ldap_close($ds);
            return true;
            }
        }
    }
    function unique_multidim_array($array, $key) {
        //Аналог функции array_unique() для многомерных массивов
        $temp_array = array();
        $i = 0;
        $key_array = array();
    
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
    function fillFealds ($ouRegions, $ouForChange) {
        foreach ($ouForChange as $region) {
            $canName = explode("/", $region['canonicalname'][0]);
            $mainCount = count(explode("/", $this->mainOuPath));
            $slaveCount = count($canName);
            for ($i = $mainCount; $i < $slaveCount - 1; $i++) {
                foreach ($ouRegions as $regMain) {
                    if ($regMain['name'][0] == $canName[$i]) {
                        if(isset($regMain['postaladdress'])) {
                            $rT['postaladdress'] = $regMain['postaladdress'][0];
                        }
                        if ($canName[$mainCount] != 'Дирекция') {
                            if(isset($regMain['telephonenumber'])) {
                                $rT['telephonenumber'] = $regMain['telephonenumber'][0];
                            }
                        } else if ($canName[$slaveCount - 2] != 'Дирекция') {
                            foreach ($ouRegions as $reg2) {
                                if ($reg2['name'][0] == $canName[$slaveCount - 2]) {
                                    if(isset($reg2['telephonenumber'])) {
                                        $rT['telephonenumber'] = $reg2['telephonenumber'][0];
                                    }
                                }
                            }
                        }
                        if (isset($region['title']) && $region['title'][0] == 'Территориальный директор') {
                            $rT['telephonenumber'] = '(4832) 67-11-70, 67-11-82';
                        }
                        if(isset($regMain['postalcode'])) {
                            $rT['postalcode'] = $regMain['postalcode'][0];
                        }
                        if(isset($rT)) {
                            $rT['dn'] = $region['dn'];
                            $arrModifyP[] = $rT;
                        }
                        unset($rT);
                    }
                }
            }
        }
        
        //Удаляю повторяющиеся записи в массиве
        $arrModifyP = $this->unique_multidim_array($arrModifyP,'dn');
        return $arrModifyP;
    }

//
//    public function adldapt() {
//        $userName = getenv('REMOTE_USER');
//        //Можно через главный контроллер Домена - rgs-rootdc-01.rgs.ru
//        $ds=ldap_connect("brn-dc.rgs.ru");  // LDAP сервер
//        $ldapuser      = 'RGSMAIN\MVManzulin';  // Login Domain admin
//        $ldappass     = '123456Qw'; //Password
//        if ($ds) { //If the server is correct and avalaible
//            $r=ldap_bind($ds, $ldapuser, $ldappass);  //привязка LDAP with Password
//            //Working area
//            $base_dn = 'OU=Филиал ПАО Росгосстрах в Брянской области,ou=ПАО Росгосстрах,ou=Structure,dc=rgs,dc=ru';
//            $filter = '(&(objectcategory=organizationalUnit)'
//                    . '(&(!(ou=Филиал ПАО Росгосстрах в Брянской области))'
//                    . '(!(name=Groups))'
//                    . '(!(name=Inactive))'
//                    . '(!(name=Servers))'
//                    . '(!(name=Service Accounts))'
//                    . '(!(name=Технэкспро))))';
//            //$filter = '(distinguishedname=OU=Дирекция,OU=Филиал ПАО Росгосстрах в Брянской области,ou=ПАО Росгосстрах,ou=Structure,dc=rgs,dc=ru)';
//            $filter2 = 'departmentnumber=58365';
//            //$filter2 = '(&(objectcategory=Person)(!(userAccountControl=514))(!(userAccountControl=66050)))';
//            $justthese = array("ou", "canonicalName", "distinguishedname", "name", "displayname", "objectclass",
//                "postalCode", "postalAddress", "telephonenumber", "company", "givenName", "userAccountControl");
//            $justthese2 = array("canonicalName", "postalCode", "postalAddress", "telephoneNumber", 
//                "company", "givenName", "mail", "middlename", "sn", "title", "department", "samaccauntname", "ipphone");
//            $ouRegions = ldap_search($ds, $base_dn, $filter, $justthese) or die ("Error in search query: ".ldap_error($ds));
//            $ouPersons = ldap_search($ds, $base_dn, $filter2, $justthese2) or die ("Error in search query: ".ldap_error($ds));
//            
//            $ouRegions = ldap_get_entries($ds, $ouRegions);
//            unset($ouRegions['count']);
//            $ouRegions = array_filter($ouRegions, function ($var) {
//                if (!preg_match('/^(na_)/', $var['name'][0])) {
//                    return $var;
//                }
//            });
//            
//            ###############################
//            ## РАЗДЕЛИТЬ НА ТРИ МАССИВА:
//            ##
//            ## ОСП И ДИРЕКЦИЯ
//            ## ОТДЕЛЫ И ГРУППЫ
//            ## ПОЛЬЗОВАТЕЛИ
//            ##
//            ## А ПОТОМ РАЗМАЗЫВАТЬ
//            ## НО ИЗМЕНИТЬ ФУНКЦИИ НИЖЕ
//            ################################
//            
//            foreach ($ouRegions as $region) {
//                    $canName = explode("/", $region['canonicalname'][0]);
//                    if ($canName[4] !== 'Дирекция') {
//                    foreach ($ouRegions as $regionTemp) {
//                        if (($regionTemp['name'][0] == $canName[4])&&
//                                (isset($regionTemp['postaladdress']))){
//                            //dd($region);
//                            $regionT['dn'] = $region['dn'];
//                    $regionT['postaladdress'] = $regionTemp['postaladdress'][0];
//                    if (isset($regionTemp['telephonenumber'])){
//                    $regionT['telephonenumber'] = $regionTemp['telephonenumber'][0];
//                    }
//                    if (isset($regionTemp['postalcode'])){
//                    $regionT['postalcode'] = $regionTemp['postalcode'][0];
//                    }
//                        $arrModify[] = $regionT;
//                        }
//                    }
//                    } else {
//                    foreach ($ouRegions as $regionTemp) {
//                        if (($regionTemp['name'][0] == $canName[4])&&
//                                (isset($regionTemp['postaladdress']))){
//                            //dd($region);
//                            $regionT['dn'] = $region['dn'];
//                    $regionT['postaladdress'] = $regionTemp['postaladdress'][0];
//                    if (isset($regionTemp['postalcode'])){
//                    $regionT['postalcode'] = $regionTemp['postalcode'][0];
//                    }
//                        $arrModify[] = $regionT;
//                        }
//                    }
//                    }
//            }
//            foreach ($arrModify as $ldapM) {
//                $myDN = $ldapM['dn'];
//                unset($ldapM['dn']);
//                ldap_mod_replace($ds, $myDN, $ldapM);
//            }
//            
//            $ouPersons = ldap_get_entries($ds, $ouPersons);
//            ldap_close($ds);
//        }
//    
//        return view ('mysystemutil.test', ['ouRegions' => $ouRegions, 'ouPersons' => $ouPersons, 'can' => $canName]);
//    }
    
public function adldapView() {
        $userName = getenv('REMOTE_USER');
        $userRealName = Adldap::search()->users()->where('samaccountname', '=', $userName)->first();
        $company = $userRealName['company'][0];
        $a1 = explode(",", $userRealName['dn']);
        $companyDN = '';
        for($i=5;$i>=1;$i--) {
            ($i>1) ? $j=',' : $j='';
        $companyDN .= $a1[count($a1)-$i].$j;
        }
        unset($a1);
        $ldapuser = "RGSMAIN\\".$userName;  // Login only Domain admin
        return view ('adirectory.formad', ['ldapuser' => $ldapuser, 
            'company' => $company, 'companyDN' => $companyDN]);
}

public function adViewEditPhoto(Request $request, array $input = null) {
    if($request) {
        $input = $request->all();
            // if (!$input) {
            //     return redirect()->action('AdWorkController@adldapView');
            // }
    } elseif (!$input) {
        return redirect()->action('AdWorkController@adldapView');
    }
    $base_dn = $input['companyDN'];
    $company = $input['company'];
    $ldapuser = $input['ldapuser'];
    (array_key_exists('pass', $input))?$ldappass = encrypt($input['pass']):$ldappass = ''; //Password
    $justthese2 = array("canonicalName", "name", "givenName", "thumbnailPhoto", 
        "middlename", "sn", "title", "department", "oubkid", "sAMAccountName");
    
    $ouPersons = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->filter2, $justthese2);
        if (!is_array($ouPersons)) {
            return view ('adirectory.errad')->with('message', $ouPersons);
        }
        
    return view('adirectory.listphoto', ['ldapuser' => $ldapuser, 'ldappass' => encrypt($ldappass), 
        'ouPersons' => $ouPersons, 'companyDN' => $base_dn]);
}

public function adViewEdit(Request $request) {
    $input = $request->all();
    if (!$input) {
        return redirect()->action('AdWorkController@adldapView');
    }
    $base_dn = $input['companyDN'];
    $company = $input['company'];
    $ldapuser = $input['ldapuser'];
    (array_key_exists('pass', $input))?$ldappass = encrypt($input['pass']):$ldappass = ''; //Password
    $justthese = array("ou", "canonicalName", "distinguishedname", "name", "displayname", "objectclass",
        "postalCode", "OUBKID", "postalAddress", "telephonenumber", "company", "givenName", "userAccountControl");
    $justthese2 = array("canonicalName", "name", "postalCode", "postalAddress", 
        "telephoneNumber", "company", "givenName", "thumbnailPhoto", 
        "middlename", "sn", "title", "department","ipphone", "oubkid", "sAMAccountName");
    
    $ouRegions = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->get_filter($company), $justthese);
    $ouPersons = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->filter2, $justthese2);
    if (!is_array($ouPersons)) {
        return view ('adirectory.errad')->with('message', $ouPersons);
    }
    if (!is_array($ouRegions)) {
        return view ('adirectory.errad')->with('message', $ouRegions);
    }
        $ouRegionsTop = array_filter($ouRegions, function ($var) {
            if (!preg_match('/^(na_)/', $var['name'][0])) {
            $canName = explode("/", $var['canonicalname'][0]);
            if (count($canName) == 5) {
                return $var;
            }
            }
        });
        $ouDepartments = array_filter($ouRegions, function ($var) {
            if (!preg_match('/^(na_)/', $var['name'][0])) {
            $canName = explode("/", $var['canonicalname'][0]);
            if (count($canName) > 5) {
                return $var;
            }
            }
        });
    return view ('adirectory.whochange', ['ouRegionsTop' => $ouRegionsTop, 
        'ldapuser' => $ldapuser, 'ldappass' => encrypt($ldappass), 
        'ouDepartments' => $ouDepartments, 'ouPersons' => $ouPersons,
        'companyDN' => $base_dn]);
}

public function adPhoto(Request $request) {
    $message = "Ошибка загрузки файла";
    if (!is_null($request->pic)) {
        //Надо бы через константу
        $max_size = 1024*1024*1; //Не более 2 Мб файл
        $message = "Разрешены изображения не более 1 Мб";
        if ($request->pic->getClientSize() <= $max_size) {
            $valid_mime = ['image/gif', 'image/jpeg', 'image/png', 'image/bmp'];
            $message = "Некорректный тип файла";
            if (in_array($request->pic->getClientMimeType(), $valid_mime)) {
                $input = $request->all();
                $name = uniqid();
                $path = $request->pic->storeAs('tmp', $name, 'my_files');
                $photo = file_get_contents($input['pic']);
                $base_dn = $input['companyDN'];
                $ldapuser = $input['ldapuser'];
                $ldappass = decrypt($input['ldappass']); //Password
                $modification = [
                    'arr' => [
                        'dn' => $input['dn'],
                        'thumbnailPhoto' => $photo
                    ]
                ];
                // dd($modification);
                $this->LDAPModify ($ldapuser, $ldappass, $modification);
                Storage::disk("my_files")->delete($path);
                $justthese2 = array("canonicalName", "name", "givenName", "thumbnailPhoto", 
                    "middlename", "sn", "title", "department", "oubkid", "sAMAccountName");
                
                $ouPersons = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->filter2, $justthese2);
                if (!is_array($ouPersons)) {
                    return view ('adirectory.errad')->with('message', $ouPersons);
                }
                $message = "Изображение обновлено";
            }
        }
    }
    return view('adirectory.listphoto', ['ldapuser' => $ldapuser, 'ldappass' => encrypt($ldappass), 
        'ouPersons' => $ouPersons, 'companyDN' => $base_dn, 'message' => $message]);
}
    
public function adModify(Request $request) {
    $input = $request->all();
    // $ds=ldap_connect("brn-dc.rgs.ru");  // LDAP сервер
    $base_dn = $input['companyDN'];
    $ldapuser = $input['ldapuser'];
    $ldappass = decrypt($input['ldappass']); //Password
    if (isset($input['main1'])) {
        $arrInput = $input['main1'];
        foreach ($arrInput as &$arrInp) {
            foreach ($arrInp as $key=>$value) {
                if ($value === null) {
                    $arrInp[$key] = array();
                }
            }
        }
        $modification = $arrInput;
        $this->LDAPModify ($ldapuser, $ldappass, $modification);
    }

    $justthese = array("ou", "canonicalName", "name", "objectclass",
                "postalCode", "postalAddress", "telephonenumber", "company");
    $ouRegions = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->get_filter($base_dn), $justthese);
    //Здесь набираю Головные подразделения
        $ouRegionsTD = array_filter($ouRegions, function ($var) {
            if (!preg_match('/^(na_)/', $var['name'][0])) {
                $canName = explode("/", $var['canonicalname'][0]);
            if (count($canName) == 5) {
                return $var;
            }
            }
        });
        //dd($ouRegionsTD);
    //Здесь набираю Отделы
        $ouDepartments = array_filter($ouRegions, function ($var) {
            if (!preg_match('/^(na_)/', $var['name'][0])) {
                $canName = explode("/", $var['canonicalname'][0]);
            if (count($canName) > 5) {
                return $var;
            }
            }
        });
        //dd($ouDepartments);
//Размазываю на отделы и группы
        $arrModify = $this->fillFealds($ouRegionsTD, $ouDepartments);
        if ($arrModify) {
            $this->LDAPModify ($ldapuser, $ldappass, $arrModify);
        }
                
//Добавляю в Отделы и Группы данные введенные вручную
    if (isset($input['main2'])) {
        $arrInput = $input['main2'];
        foreach ($arrInput as &$arrInp) {
            foreach ($arrInp as $key=>$value) {
                if ($value === null) {
                    $arrInp[$key] = array();
                }
            }
        }
        $modification = $arrInput;
        //dd($modification);
        $this->LDAPModify ($ldapuser, $ldappass, $modification);
    }
        
        $justthise = array("ou", "canonicalName", "name", "objectclass",
                "postalCode", "postalAddress", "telephoneNumber", "company");
        $justthise2 = array("canonicalName", "postalCode", "postalAddress", "telephoneNumber", "givenName", 
                "company", "mail", "middlename", "sn", "title", "department", "samaccauntname", "ipphone");
    $ouRegions = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->get_filter($base_dn), $justthise);
    $ouPersons = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->filter2, $justthise2);
    $arrModifyP = $this->fillFealds($ouRegions, $ouPersons);

    //Размазываю данные в Пользователи            
    if ($arrModifyP) {
        $this->LDAPModify($ldapuser, $ldappass, $arrModifyP);
    }
                    
    //Добавляю в Пользователи данные введенные вручную
    if (isset($input['main3'])) {
        $arrInput = $input['main3'];
            foreach ($arrInput as &$arrInp) {
                foreach ($arrInp as $key=>$value) {
                    if ($value === null) {
                        $arrInp[$key] = array();
                    }
                }
            }
            $modification = $arrInput;
            // dd($modification);
        $this->LDAPModify ($ldapuser, $ldappass, $modification);
    }
            
    //Набираю все данные из Домена - 3 (Пользователей)!!!
        $justthese2 = array("canonicalName", "givenName", "company", "sn", "title", "department", "sAMAccountName","postalCode", "postalAddress", "telephoneNumber", "ipphone");
        $ouPersons = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->filter2, $justthese2);            

        $this->removeDirectory($this->dir);
        @mkdir($this->dir, 0755);
    foreach ($ouPersons as $perS) {
        isset($perS["sn"][0])?$sn=$perS["sn"][0]:$sn='';
        isset($perS["givenname"][0])?$gn=$perS["givenname"][0]:$gn='';
        isset($perS["title"][0])?$title=$perS["title"][0]:$title='';
        //isset($perS["department"][0])?$dep=$perS["department"][0]:$dep='';
        isset($perS["company"][0])?$comp=$perS["company"][0]:$comp='';
        isset($perS["postalcode"][0])?$pc=$perS["postalcode"][0]:$pc='';
        isset($perS["postaladdress"][0])?$pa=$perS["postaladdress"][0]:$pa='';
        isset($perS["telephonenumber"][0])?$tn=$perS["telephonenumber"][0]:$tn='';
        isset($perS["ipphone"][0])?$ipp=", вн. ".$perS["ipphone"][0]:$ipp='';
        $canName = explode("/", $perS["canonicalname"][0]);
        $dep = $canName[count($canName) - 2];
        ($dep === $canName[4])?$topOrg = '':$topOrg = $canName[4];
            if($title !== "Директор") {
                $textDir = '<div>'.$title.'</div>
                <div>'.$dep.'</div>
                <div>'.$topOrg.'</div>';
            } else {
                $textDir = '<div>Директор Филиала</div>';
            }
$text_php = '<!DOCTYPE html>
<html>
    <head>
    <style>
    @font-face {
        font-family: "Aktiv Grotesk Corp6";
        src: url("c:/!IT/signature/fonts/AktivGroteskCorpMedium-Regular.eot");
        src: url("c:/!IT/signature/fonts/AktivGroteskCorpMedium-Regular.eot?#iefix") format("embedded-opentype"),
            url("c:/!IT/signature/fonts/AktivGroteskCorpMedium-Regular.woff2") format("woff2"),
            url("c:/!IT/signature/fonts/AktivGroteskCorpMedium-Regular.woff") format("woff"),
            url("c:/!IT/signature/fonts/AktivGroteskCorpMedium-Regular.ttf") format("truetype");
        font-weight: 500;
        font-style: normal;
    }
    @font-face {
        font-family: "ArialNarrow";
        src: url("c:/!IT/signature/fonts/ArialNarrow.eot");
        src: url("c:/!IT/signature/fonts/ArialNarrow.eot?#iefix") format("embedded-opentype"),
            url("c:/!IT/signature/fonts/ArialNarrow.woff") format("woff"),
            url("c:/!IT/signature/fonts/ArialNarrow.ttf") format("truetype");
        font-weight: 600;
        font-style: normal;
    }
    @font-face {
        font-family: "ArialNarrowBold";
        src: url("c:/!IT/signature/fonts/ArialNarrow-Bold.eot");
        src: url("c:/!IT/signature/fonts/ArialNarrow-Bold.eot?#iefix") format("embedded-opentype"),
            url("c:/!IT/signature/fonts/ArialNarrow-Bold.woff") format("woff"),
            url("c:/!IT/signature/fonts/ArialNarrow-Bold.ttf") format("truetype");
        font-weight: 500;
        font-style: bold;
    }
    .RGSFont {
        font-family: "ArialNarrow";
    }
    .RGSFontBold {
        font-family: "ArialNarrowBold";
    }
    </style>
    </head>
    <body class="RGSFont">
        <br/>
        <br/>
        <div style="color: #737373">
        <div>С уважением,</div>
        <br/>
        <div><strong>'.$sn." ".$gn.'</strong></div><br/>'.
        $textDir
        .'<p>
        <br/>
        <div>'.$comp.'</div>
        <div>'.$pc.", ".$pa.'</div>
        <div>'.$tn.$ipp.'</div>
        <div><a href="https://www.rgs.ru"><span style="text-decoration: underline">www.RGS.ru</span></a></div>
        </p>
        </div>
        <div style="color: #990000; font-size: 2em;" class="RGSFontBold">
        <p>
        <img src="c:/!IT/signature/img/logo.png"/>
        <!--
        <strong><b>
            РОСГОССТРАХ
        </b></strong>
        -->
        </p>
        </div>
        <div style="color: #999; font-size: 1em">
        <div>ОГРАНИЧЕНИЕ ОТВЕТСТВЕННОСТИ</div>
        <div>Данное письмо может содержать конфиденциальную информацию. 
            Если данное письмо попало к вам по ошибке, пожалуйста, сообщите об 
            этом отправителю. Любое распространение содержания данного письма 
            третьими лицами, включающее печать, хранение, публикацию или 
            копирование запрещено. ПАО СК «Росгосстрах» не несет 
            ответственности за любое несанкционированное использование 
            сведений, содержащихся в письме.</div>
        </div>
    </body>
</html>';
//Открываю файл. Если его не существует, делается попытка его создать
if (isset($perS["samaccountname"])) {
    $f_name = $perS["samaccountname"][0];
}
$fo = fopen ($this->dir.$f_name.".htm", "w");

//Записываю в файл текст
$text_php = iconv('UTF-8', 'cp1251', $text_php);//Конвертирую в Windows-1251 (ANSI)
    fwrite ($fo, $text_php);
//Закрываю файл
    fclose ($fo);
}

if(extension_loaded('zip')) {
// проверяем выбранные файлы
$zip = new \ZipArchive(); // подгружаем библиотеку zip
$zip_name = "RGS_AD_".time().".zip"; // имя файла
if($zip->open($zip_name, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE)!==TRUE) {
    $error .= "* Sorry ZIP creation failed at this time";
    die("cannot open {$zip_name} for writing.");
}


$iterator = new \DirectoryIterator($this->dir);
foreach ($iterator as $file) {
    if ($file->isFile()) {
$zip->addFile($this->dir.$file); // добавляем файлы в zip архив
}
}
$zip->close();
if(file_exists($zip_name)) {
    
### ВАРИАНТ С ОТКЛИКОМ ###
#  А ЕСЛИ БЕЗ return  ?
return response()->download($zip_name)->deleteFileAfterSend(true);
#
#
#
// отдаём файл на скачивание
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="'.$zip_name.'"');
readfile($zip_name);
// удаляем zip файл если он существует
unlink($zip_name);
}
}
    //dd($myDN);
    return view ('adirectory.whochange', ['ouRegionsTop' => $ouRegionsTop, 
            'ldapuser' => $ldapuser, 'ldappass' => encrypt($ldappass), 
            'ouDepartments' => $ouDepartments, 'ouPersons' => $ouPersons]);
            
}

    public function listOuPersons() {
        $ldapuser="RGSMAIN\\MVManzulin";
        $ldappass=encrypt("123456Qw");

        $base_dn="OU=Филиал ПАО Росгосстрах в Брянской области,OU=ПАО Росгосстрах,OU=Structure,DC=rgs,DC=ru";
        $justthese2 = array("sn", "givenName", "title", "sAMAccountName", "department");
        $ouPersons = $this->LDAPSearch($ldapuser, $ldappass, $base_dn, $this->filter2, $justthese2);
        foreach($ouPersons as $pers) {
            isset($pers["sn"][0])?$sn=$pers["sn"][0]:$sn='';
            isset($pers["givenname"][0])?$givenname=$pers["givenname"][0]:$givenname='';
            isset($pers["title"][0])?$title=$pers["title"][0]:$title='';
            isset($pers["samaccountname"][0])?$samaccountname=$pers["samaccountname"][0]:$samaccountname='';
            isset($pers["department"][0])?$department=$pers["department"][0]:$department='';
            $arrPers[] = [
                'name' => $sn." ".$givenname,
                'work' => $title,
                'user_name' => $samaccountname,
                'dep' => $department
            ];
        }
        $r = json_encode($arrPers, JSON_UNESCAPED_UNICODE);
        echo $r;
    }
}
