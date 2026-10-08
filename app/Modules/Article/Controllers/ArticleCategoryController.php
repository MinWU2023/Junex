<?php


namespace App\Modules\Article\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/**
 * Class ArticleCategoryController1
 * @package App\Modules\Category\Controllers
 */
class ArticleCategoryController extends BaseController
{

    protected $orderBy = 'sort';

    public function __construct(ArticleCategory $articleCategory)
    {
        $this->modelName = 'ArticleCategory';
        $this->model = $articleCategory;
        $this->modelSource =  $articleCategory;
        $this->viewPath = 'Article.Views.category';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required'
        ];
    }


    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->with(['translations:name,article_category_id,locale'])->orderByDesc('updated_at'), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    try {
                        $this->model->has('translation');
                        $query->whereTranslationLike('name', '%' . $name . '%');
                    } catch (\Exception $exception) {
                        $query->where('name', 'like', '%' . $name . '%');
                    }
                }
            })->paginate($request->input('limit', 1000));
            $this->sanitizeSelfParentRows($data);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.index', compact('name'));
    }


    public function update($id, Request $request)
    {

        if ($request->post('url_key')) {
            $this->validatorData['url_key'] = [
                'required',
                new UrlKeyRule($id, ArticleCategory::class),
            ];
        }
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
                'errors' => ['parent_id' => [__('上级分类不能选择自己')]],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $model->update($update);
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . '编辑文章分类(' . $model->id . ')' . $model->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all())
            ]);
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
            if (empty($request->get('url_key')) && isset($add[config('app.locale')]['name'])) $add['url_key'] = config('url.article_category') . Str::slug($add[config('app.locale')]['name'], '-', config('app.locale'));
            $create = $this->model->create($add);
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . '新增文章分类(' . $create->id . ')' . $create->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function destroy($id)
    {
        // 检查分类下是否有非临时文章
        $articleCount = DB::table('articles')->where([
            'article_category_id' => $id,
            'is_temp' => 0
        ])->count();

        if ($articleCount > 0) {
            return response()->json([
                'code' => 422,
                'message' => '该分类下有 ' . $articleCount . ' 篇文章，请先删除分类下的文章后再删除分类'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // 删除临时文章
        DB::table('articles')->where([
            'article_category_id' => $id,
            'is_temp' => 1
        ])->delete();
        $model = $this->model->find($id);
        try {
            $model->delete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . '用户' . \request()->user()->email . '将文章分类(' . $model->id . ')' . $model->name . '删除',
                'modelName' => $this->modelName,
            ]);
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Article\Models\ArticleCategory',
                'urlable_id' => $model->id
            ])->forceDelete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }
}
