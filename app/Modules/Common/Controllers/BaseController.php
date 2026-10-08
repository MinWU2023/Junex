<?php


namespace App\Modules\Common\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Translate\Models\TranslateJob;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BaseController extends Controller
{

    protected $model;
    protected $modelSource;
    protected $modelName;
    protected $viewPath;
    protected $request;
    protected $collection;
    protected $validatorData = [];
    protected $orderBy = 'updated_at';
    protected $validatorMessages = [];

    protected $messages;


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;

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
            })->paginate($request->input('limit', 15));
            $this->sanitizeSelfParentRows($data);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.index', compact('name'));
    }


    public function trash()
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $data = $this->model->unActive()->orderByDesc($this->orderBy)->paginate($request->input('limit', 15));
            $this->sanitizeSelfParentRows($data);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.trash');
    }


    public function create()
    {
        return view($this->viewPath . '.create');
    }



    public function edit($id)
    {
        $data =  $this->checkTranslate($id);
        return view($this->viewPath . '.edit', $data);
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
            $this->model->create($add);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
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
        if (array_key_exists('parent_id', $update) && (int) $update['parent_id'] === (int) $id) {
            return response()->json([
                'code' => 422,
                'errors' => ['parent_id' => [__('上级不能选择自己')]],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $model->update($update);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    public function restore($id)
    {
        $model = $this->model->find($id);
        try {
            $model->active = 1;
            $model->save();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . '（' . $id . '）恢复失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $model = $this->model->find($id);
        try {
            $model->active = 0;
            $model->save();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . '（' . $id . '）软删除失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function multipleMoveTrash(Request $request)
    {
        $ids = $request->get('ids');

        $this->model->whereIn('id', $ids)->update(
            [
                'active' => 0
            ]
        );
        return $this->success();
    }

    public function multipleRestore(Request $request)
    {
        $ids = $request->get('ids');

        $this->model->whereIn('id', $ids)->update(
            [
                'active' => 1
            ]
        );
        return $this->success();
    }

    public function multipleDestroy(Request $request)
    {
        $ids = $request->get('ids');
        $this->model->whereIn('id', $ids)->delete();
        return $this->success();
    }

    protected function checkTranslate($id)
    {
        $model = $this->model->find($id);
        $jobs = null;
        $statuses= [];
        if ($this->modelSource){
            $jobs = TranslateJob::query()->where([
                'source_id' => $id,
                'model' => $this->modelSource->getMorphClass(),
            ])->get();
            foreach ($jobs as $job){
                if ($job->status==0 && (strtotime($job->updated_at)+60*60*24*7) < time() ){
                    $job->status = 2;
                    $job->error_msg = '翻译超时，未收到返回数据';
                    $job->error_at = date('Y-m-d H:i:s');
                    $job->save();
                    $job->refresh();
                }
            }

            $statuses= array_column($jobs->toArray(),'status');
        }
        $tr_success_at = '';
        if (isset($jobs[0])){
            //查询时间超时 5天内未返回 则判定失败
            if (in_array(2,$statuses)){
                $model->is_translate = 2; //存在翻译失败的任务
            }elseif(in_array(0,$statuses)){
                $model->is_translate = 3; //存在正在翻译的任务
            }elseif (!in_array(0,$statuses) && !in_array(2,$statuses)){
                $model->is_translate = 1; //都翻译成功了
                $tr_success_at = TranslateJob::query()->where([
                    'source_id' => $id,
                    'model' => $this->modelSource->getMorphClass(),
                ])->orderByDesc('updated_at')->first()->updated_at;
            }
        }else{
            if ($this->modelSource){
                $model->is_translate = 0;
            }
        }
        $model->save();
        $model->refresh();

        return [
            'model' => $model,
            'tr_success_at' => $tr_success_at
        ];
    }

    /**
     * treeTable 无法处理 id === parent_id，列表返回前纠正脏数据。
     */
    protected function sanitizeSelfParentRows($paginator)
    {
        if (!$paginator || !method_exists($paginator, 'getCollection')) {
            return $paginator;
        }

        $paginator->getCollection()->transform(function ($item) {
            if (isset($item->parent_id) && (int) $item->id === (int) $item->parent_id) {
                $item->parent_id = 0;
            }
            return $item;
        });

        return $paginator;
    }


}
