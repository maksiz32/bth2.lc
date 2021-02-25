<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tech;
use App\Categories;
use App\Http\Requests\TechRequest;

class TechController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin');
    }
    
    public function index()
    {
        return view('tech.index', ['teches' => Tech::orderBy('category')->get()]);
    }
    
    public function create(Tech $id) {
        return view ("tech.input", ["tech" => $id]);
    }
    
    protected function do_translit($st) { 
    $replacement = array( 
        "й"=>"i","ц"=>"ts","у"=>"u","к"=>"k","е"=>"e","н"=>"n", 
        "г"=>"g","ш"=>"sh","щ"=>"sch","з"=>"z","х"=>"kh","ъ"=>"\'", 
        "ф"=>"f","ы"=>"y","в"=>"v","а"=>"a","п"=>"p","р"=>"r", 
        "о"=>"o","л"=>"l","д"=>"d","ж"=>"zh","э"=>"je","ё"=>"e", 
        "я"=>"ya","ч"=>"ch","с"=>"c","м"=>"m","и"=>"i","т"=>"t", 
        "ь"=>"\'","б"=>"b","ю"=>"yu", 
        "Й"=>"I","Ц"=>"Ts","У"=>"U","К"=>"K","Е"=>"E","Н"=>"N", 
        "Г"=>"G","Ш"=>"Sh","Щ"=>"Sch","З"=>"Z","Х"=>"Kh","Ъ"=>"\'", 
        "Ф"=>"F","Ы"=>"Y","В"=>"V","А"=>"A","П"=>"P","Р"=>"R", 
        "О"=>"O","Л"=>"L","Д"=>"D","Ж"=>"Zh","Э"=>"Je","Ё"=>"E", 
        "Я"=>"Ya","Ч"=>"Ch","С"=>"C","М"=>"M","И"=>"I","Т"=>"T", 
        "Ь"=>"\'","Б"=>"B","Ю"=>"Yu", 
    ); 
    foreach($replacement as $i=>$u) { 
        $st = mb_eregi_replace($i,$u,$st); 
    } 
    return $st; 
    }
    
    public function store(TechRequest $request) {
    if ($request->has("id")) {
        $tech = Tech::where('id', $request->id)->first();
        $ltech = $this->do_translit($request->tech);
        $photo = str_ireplace(" ", "_", $ltech) . '.' . $request->file('photo1')->getClientOriginalExtension();
        $path = $request->file('photo1')->storeAs('img/tech', $photo, 'my_files');
        $request->request->add(['photo' => $photo]);
      $tech->fill($request->all())->save();
      $s = " исправлена";
      return redirect()->action("TechController@create", ['id' => $request->id])
              ->with("success", "Запись о " . $tech->name . $s);
    } else {
            $ltech = $this->do_translit($request->tech);
            $photo = str_ireplace(" ", "_", $ltech) . '.' . $request->file('photo1')->getClientOriginalExtension();
            $path = $request->file('photo1')->storeAs('img/tech', $photo, 'my_files');
            $request->request->add(['photo' => $photo]);
      $tech = Tech::create($request->all());
      $s = " создана";
    return redirect()->action("TechController@index")
            ->with("success", "Запись о " . $tech->name . $s);
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
        Tech::destroy($id);
        return view('tech.all', ['techs' => Tech::all()])->with('success', 'Запись удалена');
    }

    public function viewCategory() {
        return view ('tech.category', ['categories' => Categories::all()]);
    }

    public function makeCategory($id=null) {
        if (is_null($id)) {

        } else {

        }
    }
}
