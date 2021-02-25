<?php
namespace App\Http\Controllers;

use App\Album;
use App\Photo;
use App\Video;
use App\Http\Requests\VideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware('isADEditor')->except('allphotos', 'video', 'album', 'searchVideo');
    }
    
    protected function countPhotoOnPage($countPhotosOnPage) {
        switch ($countPhotosOnPage) {
            case 1:
                $countPhotosOnPage = 16;
                break;
            case 2:
                $countPhotosOnPage = 32;
                break;
            case 3:
                $countPhotosOnPage = 64;
                break;
            case 4:
                $countPhotosOnPage = 128;
                break;
            case 5:
                $countPhotosOnPage = 999;
                break;
            default:
                $countPhotosOnPage = 16;
        }
        return $countPhotosOnPage;
    }
    
    public function allphotos() {
        $block = null;
        //Выясним, есть ли заблокированные альбомы
        if (\RGSPortal::isAdmin(getenv('REMOTE_USER'))){
            $block = Album::where('show', "1")->orderBy('id', 'desc')->get();
        }
        return view('albums.all_albums', 
                ['albums' => Album::where('show', "2")->orderBy('id', 'desc')
                ->paginate(20), 'blocks' => $block]);
    }
    
    public function editPhotoAlbum($id = null) {
        //Найдет запись, если есть id, либо отправит пустую модель,
        //чтобы не отлавливать isset
            $photo = Album::findOrNew($id);
        return view('albums.inp-ph-album', ['photo' => $photo]);
    }
    
    public function savePhotoAlbum(Request $request) {
        if ($request->has('id')) {
            $path1 = $request->id;
            $album = Album::where('id', $request->id)->first();
            $album->fill($request->all())->save();
            return redirect()->action('AlbumController@allphotos');
        } else {
        $path1 = (Album::max('id')) + 2;
        $path = public_path().'/img/albums/'.$path1;
        //dd($path);
        File::makeDirectory($path, 0775);
        $request->request->add(['path' => $path1]);
        Album::create($request->all());
        return redirect()->action('AlbumController@addInAlbum', ['id' => $path1]);
        }
    }
    
    /*Не будет удаления Альбома - только через его сокрытие
    public function delPhotoAlbum($id) {
        Album::destroy($id);
        return view('albums.all_photo', ['albums' => Album::where('show', "2")
                ->orderBy('id', 'desc')->paginate(20)])
                ->with("success", "Запись " . $id . " удалена");
    }
     * 
     */
    
    public function addInAlbum($id) {
        return view('albums.inp-photos', ['id' => $id, 'name' => Album::where('path', $id)->first()]);
    }
    
    public function album($id, $countPhotosOnPage, $page = null) {
        $paginatePhoto = $this->countPhotoOnPage($countPhotosOnPage);
        $photos = Photo::where('id_albums', $id)->paginate($paginatePhoto);
        $countP = count(Photo::where('id_albums', $id)->get());
        return view('albums.photo', ['photos' => $photos, 
            'name' => Album::where('path', $id)->first(), 
            'countPhotosOnPage' => $countPhotosOnPage, 
            'countP' => $countP, "?page=$page"]);
    }
    
    public function deletePhoto($id, $countPhotosOnPage = null, $page = null) {
        $name = DB::table('photos')->select('photo','id_albums')->where('id',$id)->first();
        Storage::disk("my_files")
                ->delete("/img/albums/".$name->id_albums."/".$name->photo,
                        "/img/albums/".$name->id_albums."/tmb_".$name->photo);
        Photo::destroy($id);
        return redirect()->action('AlbumController@album', ['id' => $name->id_albums, 
            "countPhotosOnPage" => $countPhotosOnPage, "?page=$page"])
                ->with('success',"Фотография " . $name->photo . " удалена");
    }
    
    public function savePhotos(Request $request) {
        foreach($request->photo1 as $image) {
        $time_r = time();
        $name = $time_r . '_albums' . '.' . $image->getClientOriginalExtension();
        $name2 = 'tmb_' . $name;
        $id = $request->id;
        $path = $image->storeAs('img/albums/'.$id.'/', $name, 'my_files');
        Image::make($image)->resize(null,160, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save(public_path().'/img/albums/'.$id.'/'.$name2, 100);
        Image::make(public_path().'/img/albums/'.$id.'/'.$name)
                ->save(public_path().'/img/albums/'.$id.'/'.$name, 100);
        /* Сохранение с автоматическим добавлением "водяного знака"
        Image::make($image)->resize(null,160, function ($constraint) {
                    $constraint->aspectRatio();
                    })->insert(public_path().'/img/tmb_watermark.png', 'bottom-right', 10, 10)
                            ->save(public_path().'/img/albums/'.$id.'/'.$name2, 100);
        Image::make(public_path().'/img/albums/'.$id.'/'.$name)
                ->insert(public_path().'/img/watermark.png', 'bottom-right', 200, 50)
                ->save(public_path().'/img/albums/'.$id.'/'.$name, 100);
         * 
         */
        $request->request->add(['photo' => $name, 'id_albums' => $id]);
        $tech = Photo::create($request->all());
        sleep(1);
        }
        return redirect()->action('AlbumController@album', ['id' => $id]);
    }
    
    public function actionPhoto($action, $id, $num = null, $countPhotosOnPage = null, $page = null) {
        $photo = Photo::where('id', $id)->first();
        $path0 = public_path().'/img/albums/'.$photo->id_albums.'/'.$photo->photo;
        $path1 = public_path().'/img/albums/'.$photo->id_albums.'/tmb_'.$photo->photo;
        Image::make($path0)->$action($num)->save($path0, 100);
        Image::make($path1)->$action($num)->save($path1, 100);
        return redirect()->action('AlbumController@album', ['id' => $photo->id_albums, 
            'countPhotosOnPage' => $countPhotosOnPage, "?page=$page"]);
    }
    
    //Тестовый метод для проверки и настройки добавления водяного знака к изображению
    //Буду использовать при загрузки изображений в альбом
    public function watermark($id, $countPhotosOnPage = null, $page = null) {
        $photo = Photo::where('id', $id)->first();
        $path0 = public_path().'/img/albums/'.$photo->id_albums.'/'.$photo->photo;
        $path1 = public_path().'/img/albums/'.$photo->id_albums.'/tmb_'.$photo->photo;
        Image::make($path0)->insert(public_path().'/img/watermark.png', 'bottom-right', 200, 50)->save($path0, 100);
        Image::make($path1)->insert(public_path().'/img/tmb_watermark.png', 'bottom-right', 10, 10)->save($path1, 100);
        return redirect()->action('AlbumController@album', ['id' => $photo->id_albums, 
            'countPhotosOnPage' => $countPhotosOnPage, "?page=$page"]);
    }
    
    public function video() {
        return view('albums.video', ['videos' => Video::orderBy('id','desc')->paginate(6)]);
    }
    
    public function inputVideo($id = null) {
        //Найдет запись, если есть id, либо отправит пустую модель,
        //чтобы не отлавливать isset
            $videos = Video::findOrNew($id);
        return view('albums.inpvideo', ['video' => $videos]);
    }
    
    public function saveVideo(VideoRequest $request) {
        if ($request->has("id")) {
            $video = Video::where('id', $request->id)->first();
            $video->fill($request->all())->save();
            $s = " исправлена";
        } else {
            $time_r = time();
            $name = $time_r . '_videoalbum' . '.' . $request->file1->getClientOriginalExtension();
            $path = $request->file1->storeAs('video', $name, 'my_files');
            $request->merge(['file' => $name]);
            //dd($request);
            $video = Video::create($request->all());
            $s = " создана";
        }
        return redirect()->action("AlbumController@video")
            ->with("success", "Запись " . $video->name . $s);
    }
    
    public function deleteVideo($id) {
        $name = DB::table('videos')->where('id',$id)->value('file');
        Video::destroy($id);
        Storage::disk("my_files","video")->delete($name);
        return redirect()->action("AlbumController@video")
            ->with("success", "Запись " . $id . " удалена");
    }
    
    public function searchVideo(Request $request) {
        $this->validate($request, [
            'videoSearch' => 'required|min:2'
        ],[
            'videoSearch.required' => 'Поле поиска не может быть пустым',
            'videoSearch.min' => 'Не менее 2-х символов'
        ]);
        return view("albums.search", ["notes" => Video::where('name', 'like', '%' . $request->videoSearch . '%')->paginate('10')]);
    }
    
    /*//Временный метод для переноса данных из старых альбомов, которые были без использования БД
    public function goSQL($id) {
        $directory = 'c:\\openserver\\domains\\bth2.lc\\public\\img\\albums\\'.$id;
        foreach (new \DirectoryIterator($directory) as $file) {
            if ($file->isDot() || $file->isDir() || $file->getExtension() == 'db' || $file->getExtension() == 'txt') continue;
            $files = Photo::create(['id_albums' => $id,
                        'photo' => $file->getFilename()]);
            }
            return ('Well done');
        }
     * 
     */
        
}
