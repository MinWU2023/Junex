<?php


namespace App\Modules\Article\Controllers;


use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\User;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Article\Models\ArticleFile;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Requests\ArticleRequest;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\Product;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


/**
 * Class ArticleController
 * @package App\Modules\Category\Controllers
 */
class ArticleController extends BaseController
{


    public function __construct(Article $article)
    {
        $this->modelName = 'Article';
        $this->model = $article;
        $this->modelSource =  $article;
        $this->viewPath = 'Article.Views.article';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required',
            'translate.' . config('app.locale') . '.content' => 'required',
            'article_category_id'=>'required'
        ];
        $this->messages = [
            'translate.' . config('app.locale') . '.name.required' => '标题(' . config('app.locale') . ')不能为空',
            'translate.' . config('app.locale') . '.content.required' => '内容(' . config('app.locale') . ')不能为空',
            'article_category_id.required' => '请选择分类',
        ];
    }


    private const TRANSLATABLE_FIELDS = [
     'content', 'title', 'keywords', 'description'
    ];


    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Article::with(['translations:name,article_id,locale', 'articleCategory' => function ($query) {
                $query->with(['translations']);
            }, 'admin']), function ($query) use ($request) {
                if ($category_id = $request->get('category_id')) {
                    $cate_ids = [$category_id];
                    self::getChildrenIds($cate_ids, $category_id);
                    $query->whereIn('article_category_id', $cate_ids);
                }
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            });
            if (!in_array(\auth()->id(), User::ALLOW_ADMIN_ID)) {
                $data->whereHas('admin', function ($query) {
                    $query->where('admin_user_id', \auth()->id());
                });
            };
            $data = $data->active()->orderByDesc('updated_at')->paginate($request->input('limit', 15));;
            return new CommonResourceCollection($data);
        }
        return view($this->viewPath . '.index', compact('name'));
    }


    public static function getChildrenIds(&$cate_ids, $id)
    {
        $childrens = ArticleCategory::query()->where('parent_id', $id)->get();
        foreach ($childrens as $children) {
            if ($children) {
                $cate_ids[] = $children->id;
                self::getChildrenIds($cate_ids, $children->id);
            }
        }
    }

    public function trash()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Article::with(['translations:name,article_id,locale', 'articleCategory']), function ($query) use ($request) {
                if ($category_id = $request->get('category_id')) {
                    $query->where('article_category_id', $category_id);
                }
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->unActive()->where('is_draft', 0)->orderByDesc('updated_at')->paginate($request->input('limit', 15));;
            return new CommonResourceCollection($data);
        }
        return view('Article.Views.article.trash', compact('name'));
    }

    public function store(Request $request)
    {
        $action = $request->get('action');
        // 如果是保存草稿，只验证基本字段
        if ($action === 'draft') {
            $this->validatorData = [
                'sort' => 'required|numeric',
                'translate.' . config('app.locale') . '.name' => 'required',
            ];
        }
        
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->messages);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            $add['add_date'] = date('Ym');
            $add['admin_user_id'] = auth()->id();
            
            if (empty($request->get('url_key')) && isset($add[config('app.locale')]['name'])) {
                $article_category = ArticleCategory::find($request->get('article_category_id'));
                if (config('url.article') == 'diy/' && $article_category) {
                    $add['url_key'] = Str::slug($article_category->name, '-', config('app.locale')) . '/' . Str::slug($add[config('app.locale')]['name'], '-', config('app.locale'));
                } else {
                    $add['url_key'] = config('url.article') . Str::slug($add[config('app.locale')]['name'], '-', config('app.locale'));
                }
            }
            $article = $this->model->create($add);
            $this->createArticleFile($article, $request);
            
            if ($action === 'draft') {
                $article->is_draft = 1;
                $article->active = 0;
                $article->save();
            }
            
            $actionText = $action === 'draft' ? '保存草稿' : '新增文章';
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . $actionText . '(' . $article->id . ')' . $article->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    public function restore($id)
    {
        $article = Article::find($id);
        try {
            $article->active = 1;
            $article->save();
        } catch (\PDOException $exception) {
            Log::error('ArticleController:restore:文章（' . $id . '）恢复失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $action = $request->get('action');
        
        // 如果是保存草稿，只验证基本字段
        if ($action === 'draft') {
            $this->validatorData = [
                'sort' => 'required|numeric',
                'translate.' . config('app.locale') . '.name' => 'required',
            ];
        }
        
        if ($request->post('url_key')) {
            $this->validatorData['url_key'] = [
                'required',
                new UrlKeyRule($id, Article::class),
            ];
        }
        
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->messages);
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
            DB::table('article_files')->where('article_id', $model->id)->delete();
            $this->createArticleFile($model, $request);
            
            $actionText = $action === 'draft' ? '保存草稿' : '修改文章';
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . $actionText . '(' . $model->id . ')' . $model->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $article = Article::find($id);
        try {
            $article->active = 0;
            $article->save();
        } catch (\PDOException $exception) {
            Log::error('ArticleController:remove:文章（' . $id . '）软删除失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function changeProperty($id, Request $request)
    {
        $model = $this->model->find($id);
        switch ($request->type) {
            case 'article_show':
                $model->is_show = !$model->is_show;
                break;
            case 'article_menu':
                $model->is_menu = !$model->is_menu;
                break;
            case 'article_sort':
                $model->sort = intval($request->get('sort'));
                break;
        }
        $model->save();
        return $this->success();
    }

    protected function createArticleFile(Article $article, $request)
    {
        if ($filePaths = $request->get('filePath')) {
            $sorts = $request->get('fileSorts');
            $names = $request->get('fileNames');
            foreach ($filePaths as $key => $imgPath) {
                if (isset($names[$key])) {
                    $add = [];
                    $add['article_id'] = $article->id;
                    $add['path'] = $imgPath;
                    $add['name'] = $names[$key];
                    $add['sort'] = $sorts[$key];
                    ArticleFile::create($add);
                }
            }
        }
    }


    public function destroy($id)
    {
        $model = $this->model->find($id);
        try {
            $model->delete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . \request()->user()->email . '将文章(' . $model->id . ')' . $model->name . '删除',
                'modelName' => $this->modelName,
            ]);
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Article\Models\Article',
                'urlable_id' => $model->id
            ])->forceDelete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function multipleDestroy(Request $request)
    {
        $ids = $request->get('ids');
        $this->model->whereIn('id', $ids)->delete();
        Url::withTrashed()->where(['urlable_type' => 'App\Modules\Article\Models\Article'])->whereIn('urlable_id', $ids)->forceDelete();
        return $this->success();
    }


    public function getAllArticles($id)
    {
        if ($id == 0) {
            $checkedData = [];
            $selectCategory = [];
        } else {
            $checkedCategories = Product::where('id', $id)->with('article')->first();
            if ($checkedCategories->article) {
                $checkedData = array_column($checkedCategories->article->toArray(), 'name');
                $selectCategory = array_column($checkedCategories->article->toArray(), 'name', 'id');
            }
        }
        $categories = Article::active()->with(['translations:name,article_id,locale'])->get();
        $data = [];
        foreach ($categories as $k => $category) {
            $data[$k]['label'] = $category->name;
            $data[$k]['id'] = $category->id;
        }

        $selectCategoryData = [];
        foreach ($selectCategory as $k => $value) {
            $selectCategoryData[] = [
                'id' => $k,
                'name' => $value
            ];
        }


        return json_encode([
            'categories' => $data,
            'currentSelect' => $checkedData,
            'selectCategory' => $selectCategoryData
        ]);
    }
}
