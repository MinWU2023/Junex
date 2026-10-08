<?php
namespace App\Modules\Download\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Download\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\DownloadUser;

class DownloadController extends BaseController{

    public function __construct(Download $download)
    {
        $this->modelName = 'Download';
        $this->model = $download;
        $this->modelSource =  $download;
        $this->viewPath = 'Download.Views.download';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required',
            'download_category_id' => 'required|exists:download_categories,id'
        ];
    }

    
    private const TRANSLATABLE_FIELDS = [
        'content'
    ];
   


    public function index()
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Download::with(['translations:name,download_id,locale','downloadCategory']),function($query) use ($request){
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            });
            if ($request->get('category_id')){
                $data->whereHas('downloadCategory',function($categoryQuery)use($request){
                    if ($category_id = $request->get('category_id')) {
                        $categoryQuery->where('download_category_id', $category_id);
                    }
                });
            }
            $data = $data->orderByDesc('updated_at')->paginate($request->input('limit', 15));
            
            // 为每个下载项添加总下载次数
            $data->getCollection()->transform(function ($download) {
                $download->total_download_count = DownloadUser::where('download_id', $download->id)->sum('download_count');
                return $download;
            });
            
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.index');
    }

    public function downloadRecord($id)
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $models = tap( DownloadUser::where('download_id', $id),function($query) use ($request){
                if ($ip = $request->get('ip')) {
                    $query->where('ip','like', '%' . $ip . '%');
                }
            })->orderByDesc('created_at')->paginate($request->input('limit', 15));
            return new CommonResourceCollection($models);
        }
        $count = DownloadUser::where('download_id', $id)->sum('download_count');
        return view($this->viewPath . '.record', compact('id', 'count'));
    }


    public function resetDownloadKey()
    {
        $downloads = Download::all();
        foreach ($downloads as $download) {
            $download->download_key = Str::random(30);
            $download->save();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $model = $this->model->find($id);
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                if (array_key_exists($field, $update[config('app.locale')]) && empty(trim($update[config('app.locale')][$field]))) {
                    foreach (config('translatable.locales') as $locale) {
                        $update[$locale][$field] = null;
                    }
                }
            }
            $model->update($update);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    
    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            if (empty($request->get('url_key')) && isset($add[config('app.locale')]['name'])) $add['url_key'] = Str::slug($add[config('app.locale')]['name'], '-', config('app.locale'));
            $add['download_key'] = Str::random(30);
            $this->model->create($add);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }



}
