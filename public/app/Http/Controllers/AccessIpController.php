<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Firm;
use App\AccessIp;

class AccessIpController extends Controller
{
    public function __construct() {
        $this->middleware('isADEditor');
    }
    
    public function index() {
        $firms = Firm::where('isblock', 1)->get();
        $acss = AccessIp::select('access_ips.*','firms.id as idFirm',
                'firms.ipStart','firms.ipEnd','firms.name')
                ->join('firms','firms.id','=','access_ips.id_firms')
                ->where('isblock', 1)->get();
        return view('car.access',['firms' => $firms, 'acss' => $acss]);
    }
    
    public function save(Request $request) {
        $this->validate($request, [
            'id_firms' => 'required',
        ],[
            'id_firms.required' => 'Выбрать подразделение - это обязательное поле',
        ]);
        $r = AccessIp::create($request->only('id_firms'));
        return redirect(action('AccessIpController@index'));
    }
    
    public function destroy($id) {
        $r = AccessIp::findOrFail($id);
        $r->delete();
        return redirect(action('AccessIpController@index'));
    }
}
