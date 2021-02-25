<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use App\Http\Requests\LinkRequest;

class LinkController extends Controller
{
    public function links()
    {
        return view('link.res',['links' => Link::all()]);
    }
    
    public function new_link()
    {
        return view('link.ledit');
    }
    
    public function edit_link($id)
    {
        return view('link.ledit',['links' => Link::where('id', $id)->first()]);
    }
    
    public function save(LinkRequest $request)
    {
        if ($request->id) {
            $link = Link::where('id', $request->id)->first();
            $link->fill($request->all())->save();
            $stat = 'обновлена';
        } else {
            Link::create(['path' => $request->path, 'name' => $request->name]);
            $stat = 'добавлена';
        }
        return redirect()->action('LinkController@links')->with('status', "Запись ".$request->name." была добавлена");
    }
    
    public function delete(Link $id) {
        $name = $id->name;
        $id->delete();
        return redirect()->back()->with("status", "Запись о " . $name . " удалена");
    }
}
