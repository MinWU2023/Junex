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

class AlbumController extends BaseController
{
    protected $orderBy = 'sort';

    public function __construct(PhotoAlbum $photoAlbum)
    {
        $this->modelName = 'PhotoAlbum';
        $this->model = $photoAlbum;
        $this->viewPath = 'Photo.Views.album';
    }


    public function photo($id){
        $photos = FileInfo::query()->where('photo_album_id',$id)->get();
        return view($this->viewPath . '.photo',compact('photos'));
    }

    public function uploadShow($id){
        $model = $this->model->find($id);
        return view($this->viewPath . '.upload',compact('model'));
    }

    public function upload(Request $request){
        $validator = $this->getValidationFactory()->make($request->all(), [
            'album_id' => 'required',
            'imgPath' => 'required|array'
        ],[
            'imgPath.array' => '上传失败，请添加相册图片',
            'imgPath.required' => '上传失败，请添加相册图片'
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $imgPaths =  $request->get('imgPath');
        $album_id = $request->get('album_id');
        foreach ($imgPaths as $imgPath){
            $file = FileInfo::query()->where('true_path',$imgPath)->first();
            if ($file){
                $file->photo_album_id = $album_id;
                $file->save();
            }
        }
        return  $this->success();
    }
}
