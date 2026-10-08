<?php


namespace App\Modules\Photo\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\FileInfo\Models\FileInfo;
use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\PageFile;
use App\Modules\Photo\Models\PhotoAlbum;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PictureController extends BaseController
{
    protected $orderBy = 'id';

    public function __construct(FileInfo $fileInfo)
    {
        $this->modelName = 'FileInfo';
        $this->model = $fileInfo->where('mimeType','like','%image%');
        $this->viewPath = 'Photo.Views.picture';
    }

    public function pop(Request  $request){
        $albums = PhotoAlbum::query()->orderByDesc('sort')->get();
        $select_album_id = $request->get('select_album_id',0);
        $from_tinymce = $request->has('from_tinymce');
        if ($select_album_id){
            $images = FileInfo::query()
                ->where('mimeType','like','%image%')
                ->where('photo_album_id',$select_album_id)
                ->orderByDesc('created_at')
                ->paginate()
                ->appends($request->query());
        }else{
            $images = FileInfo::query()
                ->where('mimeType','like','%image%')
                ->orderByDesc('created_at')
                ->paginate()
                ->appends($request->query());
        }
        return view($this->viewPath . '.pop',compact('images','select_album_id','albums','from_tinymce'));
    }


    public function index()
    {
        $request = \request();
        $albums = PhotoAlbum::all();
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(FileInfo::query()->where('mimeType','like','%image%'),function ($query)use($request){
                if ($album_id = $request->get('album_id')){
                    $query->where('photo_album_id',$album_id);
                }
            })->orderByDesc('created_at')->paginate($request->input('limit', 15));

            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        $album_id = intval($request->get('album_id'));
        return view($this->viewPath . '.index',compact('albums','album_id'));
    }

    public function multipleMoveAlbumShow(Request $request){
        $albums = PhotoAlbum::all();
        return view($this->viewPath . '.multipleMoveAlbumShow',compact('albums'));
    }

    public function multipleMoveAlbum(Request  $request){
        $ids = explode(',', $request->get('ids'));
        foreach ($ids as $id) {
            $file = FileInfo::query()->find($id);
            if ($file){
                $file->photo_album_id = $request->get('photo_album_id');
                $file->save();
            }
        }
        return $this->success();
    }


    public function multipleMoveRemove(Request $request){
        if ($ids = $request->get('ids')){
            FileInfo::query()->whereIn('id',$ids)->delete();
        }
        return $this->success();
    }

}
