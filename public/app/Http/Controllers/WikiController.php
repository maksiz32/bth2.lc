<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WikiSystem;
use App\Wiki;
use App\WikiFile;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WikiController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADAdmin')->only(['viewSys','inputSys','delFile']);
    }
    
    public function viewSys(Request $request, $id=null) {
        if ($id) {
            $request = WikiSystem::find($id);
        }
        return view('wiki.createSystems', ['system' => $request]);
    }
    
    public function inputSys(Request $request) {
        if ($request->has('id')) {
            $r = WikiSystem::find($request->id);
            $mes = "изменена";
        } else {
            $r = new WikiSystem;
            $mes = "добавлена";
        }
        $r->system = $request->system;
        $r->save();
        return redirect(action('WikiController@viewSys'))->with('success', 'Запись '.$mes);
    }
    
    public function viewWiki(Request $request, $id=null) {
        $systems = WikiSystem::all()->sortBy('system');
        if ($id) {
            $request = Wiki::find($id);
        }
        return view('wiki.createWiki', ['systems' => $systems, 'wiki' => $request]);
    }
    
    public function inputWiki(Request $request) {
        if ($request->has('id')) {
            $r = Wiki::find($request->id);
            $mes = "изменена";
        } else {
            $r = new Wiki;
            $mes = "добавлена";
        }
        $r->id_systems = $request->id_systems;
        $r->error = $request->error;
        $r->fix = $request->fix;
        $r->save();
        $id = $r->id;
        
        if ($request->file('docs')) {
            foreach($request->docs as $doc) {
                $originalName = $doc->getClientOriginalName();
                $type = File::mimeType($doc);
                $name = time() . '_wiki' . '.' . $doc->getClientOriginalExtension();
                $path = $doc->storeAs('wikidoc', $name, 'my_files');
                $b = new WikiFile;
                $b->name = $originalName;
                $b->id_wiki = $id;
                $b->type = WikiFile::getTypeFile($type);
                $b->path = $path;
                $b->save();
                sleep(2);
            }
        }
        return redirect(action('WikiController@wikiOne',['id'=> $id]))->with('success', 'Запись '.$mes);
    }
    public function delFile($id) {
        $r = WikiFile::findOrFail($id);
        $idWiki = $r->id_wiki;
        Storage::disk("my_files")->delete('/'.$r->path);
        $r->delete();
        $wiki = Wiki::select('wikis.*', 'wiki_systems.system')
                ->join('wiki_systems', 'wiki_systems.id', '=', 'wikis.id_systems')
                ->where('wikis.id', $idWiki)->first();
        $files = WikiFile::where('id_wiki', $idWiki)->get();
        return view('wiki.one', ['wiki' => $wiki, 'files' => $files]);
    }
    
    public function main() {
        $mainsystems = WikiSystem::all()->sortBy('system');
        $systems = Wiki::select('wikis.error', 'wikis.id', 'wiki_systems.system', 
                'wiki_systems.id as id_sys')
                ->join('wiki_systems', 'wikis.id_systems', '=', 'wiki_systems.id')
                ->orderBy('wiki_systems.system')->get();
        //dd($systems);
        return view('wiki.main', ['systems' => $systems, 'mainSystems' => $mainsystems, 
            'search' => null]);
    }
    
    public function wikiOne($id) {
        $wiki = Wiki::select('wikis.*', 'wiki_systems.system')
                ->join('wiki_systems', 'wiki_systems.id', '=', 'wikis.id_systems')
                ->where('wikis.id', $id)->first();
        $files = WikiFile::where('id_wiki', $id)->get();
        //(count($files) < 1) ? $files = false: true;
        return view('wiki.one', ['wiki' => $wiki, 'files' => $files]);
    }
    
    public function systemOne($id) {
        $wiki = Wiki::select('wiki_systems.system', 'wikis.*')
                ->join('wiki_systems','wiki_systems.id','=','wikis.id_systems')
                ->where('wikis.id_systems', $id)->get()->sortBy('wikis.error');
        $sys = WikiSystem::find($id);
        return view('wiki.systemOne', ['wiki' => $wiki, 'system' => $sys]);
    }
        
    public function search(Request $request) {
        $this->validate($request, [
            'textSearch' => 'required|min:3'
        ],[
            'textSearch.required' => 'Поле поиска не может быть пустым',
            'textSearch.min' => 'Не менее 3-х символов'
        ]);
        //DB::enableQueryLog();
        $search = DB::select('select * from (select wikis.*, wiki_systems.system, '
                . 'wiki_systems.id as id_sys from wikis inner join wiki_systems on '
                . 'wiki_systems.id = wikis.id_systems) as allcells where system like ? or error like ? '
                . 'or fix like ? Order By id_sys', ['%'.$request->textSearch.'%',
                    '%'.$request->textSearch.'%','%'.$request->textSearch.'%']);
        //dd(DB::getQueryLog());
        return view('wiki.main', ['systems' => null, 'mainSystems' => null, 
            'search' => $search]);
    }
}
