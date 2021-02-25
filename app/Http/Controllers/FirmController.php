<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Firm;
use App\Http\Requests\FirmRequest;

class FirmController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin')->except('index','all');
    }
    
    public function index()
    {
        if (\RGSPortal::isAdmin(getenv('REMOTE_USER'))){
            return view('firms.all', ['firms' => Firm::orderBy('name')->get(), 'stat' => 'yes']);
        } else {
            return view('firms.all', ['firms' => Firm::where('isblock','1')->orderBy('name')->get(), 'stat' => null]);
        }
    }
    
    public function create(Firm $id) {
        return view ("firms.input", ["firm" => $id]);
    }
    
    public function all() {
        return view ("firms.all", ['firms' => Firm::orderBy('name')->get(), 'stat' => 'yes']);
    }
    
    public function noall() {
        return view ("firms.all", ['firms' => Firm::where('isblock','1')->orderBy('name')->get(), 'stat' => null]);
    }
    
    public function store(FirmRequest $request) {
    if ($request->has("id")) {
      $firm = Firm::where('id', $request->id)->first();
        $request->merge(['ipStart' => ip2long($request->ipStart)]);
        $request->merge(['ipEnd' => ip2long($request->ipEnd)]);
      $firm->fill($request->all())->save();
      $s = " исправлена";
      return redirect()->action("FirmController@index")
              ->with("success", "Запись о " . $firm->name . $s);
    } else {
        $request->merge(['ipStart' => ip2long($request->ipStart)]);
        $request->merge(['ipEnd' => ip2long($request->ipEnd)]);
      $firm = Firm::create($request->all());
      $s = " создана";
    return redirect()->action("FirmController@index")
            ->with("success", "Запись о " . $firm->name . $s);
    }
  }
  /*
    public function show($id)
    {
        return view('firms.all', ['firms' => Firm::findOrFail($id)]);
    }
    */
    public function destroy($id)
    {
        Firm::destroy($id);
        return view('firms.all', ['firms' => Firm::all()])->with('success', 'Запись удалена');
    }
}
