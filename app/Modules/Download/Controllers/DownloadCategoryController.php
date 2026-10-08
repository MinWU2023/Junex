<?php
namespace App\Modules\Download\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Download\Models\DownloadCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DownloadCategoryController extends BaseController{


    protected $orderBy = 'sort';

    public function __construct(DownloadCategory $downloadCategory){
        $this->modelName = 'DownloadCategory';
        $this->model = $downloadCategory;
        $this->modelSource =  $downloadCategory;
        $this->viewPath = 'Download.Views.category';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required',
        ];
    }


    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->orderByDesc($this->orderBy), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    try {
                        $this->model->has('translation');
                        $query->whereTranslationLike('name', '%' . $name . '%');
                    } catch (\Exception $exception) {
                        $query->where('name', 'like', '%' . $name . '%');
                    }
                }
            })->paginate($request->input('limit', 10000));
            $this->sanitizeSelfParentRows($data);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.index', compact('name'));

    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            if (empty($request->get('url_key')) && isset($add['en']['name'])) $add['url_key'] = Str::slug($add['en']['name']);
            $this->model->create($add);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


}
