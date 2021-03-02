<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Tech;
use App\Categories;
use App\Http\Requests\TechRequest;
use App\Remain;

class TechController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin');
    }
    
    public function index()
    {
        return view('tech.index', ['teches' => Tech::allTechWithCategory()]);
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
            if ($request->has("photo1")){
                $photo = uniqid() . '.' . $request->file('photo1')->getClientOriginalExtension();
                $path = $request->file('photo1')->storeAs('img/tech', $photo, 'my_files');
                $request->request->add(['photo' => $photo]);
            }
            $tech->fill($request->all())->save();
            $s = " исправлена";
            
            return redirect()->action("TechController@index")
                  ->with("success", "Запись о " . $tech->name . $s);
        } else {
            $photo = uniqid() . '.' . $request->file('photo1')->getClientOriginalExtension();
            $path = $request->file('photo1')->storeAs('img/tech', $photo, 'my_files');
            $request->request->add(['photo' => $photo]);
            $tech = Tech::create($request->all());
            $s = " создана";
            
            return redirect()->action("TechController@index")
                ->with("success", "Запись о " . $tech->name . $s);
        }
    }
    
    public function destroy($id)
    {
        Tech::destroy($id);
        return redirect()->action('TechController@index')->with('success', 'Запись удалена');
    }
    
    public function viewRemains() {
        return view('tech.remains', ['teches' => Tech::getTechsAndRemains()]);
    }
    
    public function editRemain($id) {
        $id = (int) $id;
        return view('tech.add-remain', ['rem' => Remain::editRemain($id)[0]]);
    }
    
    public function saveRemain(TechRequest $request) {
        if(!is_null($request->rem_id)) {
            $rem = Remain::editRem($request);
        } else {
            $rem = Remain::newRem($request);
        }
        return redirect()->action('TechController@viewRemains')->with('success', $rem);
    }

    public function viewCategory(Request $request, $id = null) {
        if (is_null($id)) {
            return view ('tech.category', ['categories' => Categories::all(), 'cat' => $request]);
        } else {
            return view ('tech.category', ['categories' => Categories::all(), 'cat' => Categories::find($id)]);
        }
    }

    public function makeCategory(CategoryRequest $request) {
        if (isset($request->id)) {
            $category = Categories::find($request->id);
            $category->category = $request->category;
            $text = 'изменена.';
        } else {
            $category = new Categories;
            $category->category = $request->category;
            $text = 'создана.';
        }
            $category->save();
        return redirect()->action('TechController@viewCategory')->with('success', 'Запись ' . $text);
    }
}
