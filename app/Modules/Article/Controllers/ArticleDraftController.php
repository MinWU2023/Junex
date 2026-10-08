<?php

namespace App\Modules\Article\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\User;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Article\Models\ArticleFile;
use App\Modules\Article\Models\ArticleScheduledPublish;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use  App\Modules\Article\Collections\ArticleListCollection;

class ArticleDraftController extends BaseController
{
    private const TRANSLATABLE_FIELDS = [
        'content',
        'title',
        'keywords',
        'description'
    ];

    public function __construct(Article $article)
    {
        $this->modelName = 'Article';
        $this->model = $article;
        $this->modelSource = $article;
        $this->viewPath = 'Article.Views.draft';
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

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        $id = $request->get('id');

        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(
                Article::query()->with(['translations:name,article_id,locale', 'admin', 'articleCategory', 'scheduledPublish']),
                function ($query) use ($request) {
                    if ($name = $request->get('name')) {
                        $query->whereTranslationLike('name', '%' . $name . '%');
                    }
                    if ($id = $request->get('id')) {
                        $query->where('id', $id);
                    }
                    if ($category_id = $request->get('category_id')) {
                        $cate_ids = [$category_id];
                        ArticleController::getChildrenIds($cate_ids, $category_id);
                        $query->whereIn('article_category_id', $cate_ids);
                    }
                    if ($select_admin = $request->get('select_admin')) {
                        $query->where('admin_user_id', $select_admin);
                    }
                    if ($sort = $request->get('sort')) {
                        $temp = explode('-', $sort);
                        if (count($temp) === 2) {
                            if ($temp[0] === 'name') {
                                $query->orderByTranslation($temp[0], $temp[1]);
                            } else {
                                $query->orderBy($temp[0], $temp[1]);
                            }
                        }
                    } else {
                        $query->latest('updated_at');
                    }
                    $query->where('active', 0)->where('is_draft', 1);
                }
            );

            if (!in_array(\auth()->id(), User::ALLOW_ADMIN_ID)) {
                $data->whereHas('admin', function ($query) {
                    $query->where('admin_user_id', \auth()->id());
                });
            }

            $data = $data->paginate($request->input('limit', 15));

            return new ArticleListCollection($data);
        }

        $admins = User::query()->get();
        return view($this->viewPath . '.index', compact('name', 'id', 'admins'));
    }

    public function edit($id)
    {
        $model = $this->model->with(['articleCategory'])->find($id);
        $data = $this->checkTranslate($id);
        $data['model'] = $model;

        // 清理临时文章
        $articles = Article::where('is_temp', 1)->where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1day")))->get();
        $is_del = false;
        foreach ($articles as $article) {
            DB::table('article_files')->where('article_id', $article->id)->delete();
            Article::where('id', $article->id)->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Article\Models\Article',
                'urlable_id' => $article->id
            ])->forceDelete();
            $is_del = true;
        }
        if ($is_del) {
            $maxId = Article::query()->max('id');
            $newStartingId = $maxId + 1;
            DB::statement("ALTER TABLE articles AUTO_INCREMENT = $newStartingId;");
        }

        return view($this->viewPath . '.edit', $data);
    }

    public function update($id, Request $request)
    {
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
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $model->admin_user_id) {
            return $this->badRequest('无权限修改');
        }

        $translate = $request->get('translate');
        $temp_ids = Article::where('is_temp', 1)->pluck('id')->toArray();
        $temp_ids[] = $id;
        $repeat = DB::table('article_translations')->where([
            'locale' => config('app.locale'),
            'name' => $translate[config('app.locale')]['name']
        ])->whereNotIn('article_id', $temp_ids)->first();
        if ($repeat) {
            $validator->errors()->add('field', '文章标题已存在，请修改');
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            $temp_article_id = $request->get('temp_article_id');
            $this->delTempArticle($temp_article_id);

            $update['updated_at'] = date('Y-m-d H:i:s');
            $update['active'] = 1;
            $update['is_draft'] = 0;
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

            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . '编辑文章(' . $model->id . ')' . $model->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all()),
                'data_source_id' => $id,
                'data_created_at' => $model->created_at
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
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

    protected function delTempArticle($temp_article_id)
    {
        $article = Article::where([
            'is_temp' => 1,
            'id' => $temp_article_id,
        ])->first();
        if ($article) {
            DB::table('article_files')->where('article_id', $article->id)->delete();
            $article->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Article\Models\Article',
                'urlable_id' => $article->id
            ])->forceDelete();
            $maxId = Article::query()->max('id');
            $newStartingId = $maxId + 1;
            DB::statement("ALTER TABLE articles AUTO_INCREMENT = $newStartingId;");
        }
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $model->admin_user_id) {
            return $this->badRequest('无权限');
        }
        try {
            DB::table('article_files')->where('article_id', $model->id)->delete();
            $model->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Article\Models\Article',
                'urlable_id' => $model->id
            ])->forceDelete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . \request()->user()->email . '将文章(' . $model->id . ')' . $model->name . '删除',
                'modelName' => $this->modelName,
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
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
                    $add['sort'] = isset($sorts[$key]) ? $sorts[$key] : 0;
                    ArticleFile::create($add);
                }
            }
        }
    }

    /**
     * 设置定时发布
     */
    public function setSchedule(Request $request, $id)
    {
        try {
            $article = Article::with(['translations', 'articleCategory'])->findOrFail($id);

            // 验证文章是否为草稿
            if ($article->is_draft != 1 || $article->active != 0) {
                return response()->json([
                    'code' => 1,
                    'msg' => '只能为草稿文章设置定时发布'
                ]);
            }

            // 验证发布时间
            $publishAt = $request->input('publish_at');
            if (empty($publishAt)) {
                return response()->json([
                    'code' => 1,
                    'msg' => '请选择发布时间',
                    'errors' => []
                ]);
            }

            // 验证时间格式和是否晚于当前时间
            try {
                $publishTime = \Carbon\Carbon::parse($publishAt);
                if ($publishTime->lte(now())) {
                    return response()->json([
                        'code' => 1,
                        'msg' => '发布时间必须晚于当前时间',
                        'errors' => []
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 1,
                    'msg' => '日期格式不正确，格式应为：2026-03-02 15:30:00',
                    'errors' => []
                ]);
            }

            // 验证文章必填字段
            $validationErrors = $this->validateArticleRequiredFields($article);
            if (!empty($validationErrors)) {
                return response()->json([
                    'code' => 1,
                    'msg' => '文章信息不完整，请先完善以下必填项：' . implode(', ', $validationErrors),
                    'errors' => $validationErrors
                ]);
            }

            // 创建或更新定时发布记录
            ArticleScheduledPublish::updateOrCreate(
                ['article_id' => $id],
                ['publish_at' => $publishTime]
            );

            return response()->json([
                'code' => 0,
                'msg' => '设置成功'
            ]);
        } catch (\Exception $e) {
            Log::error('设置定时发布失败: ' . $e->getMessage());
            return response()->json([
                'code' => 1,
                'msg' => '设置失败：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 验证文章必填字段
     */
    protected function validateArticleRequiredFields($article)
    {
        $errors = [];
        $locale = config('app.locale');

        // 1. 验证排序
        if (empty($article->sort) && $article->sort !== 0) {
            $errors[] = '文章排序';
        }

        // 2. 验证文章名（翻译字段）
        $translation = $article->translations->firstWhere('locale', $locale);
        if (!$translation || empty($translation->name)) {
            $errors[] = '文章标题';
        }

        // 3. 验证详情内容（翻译字段）
        if (!$translation || empty($translation->content)) {
            $errors[] = '文章内容';
        }

        if (empty($article->article_category_id) && $article->article_category_id !== 0) {
            $errors[] = '文章分类';
        }

        return $errors;
    }

    /**
     * 删除定时发布
     */
    public function deleteSchedule(Request $request, $id)
    {
        try {
            $schedule = ArticleScheduledPublish::where('article_id', $id)->first();

            if ($schedule) {
                $schedule->delete();
            }

            return response()->json([
                'code' => 0,
                'msg' => '已清除定时发布'
            ]);
        } catch (\Exception $e) {
            Log::error('删除定时发布失败: ' . $e->getMessage());
            return response()->json([
                'code' => 1,
                'msg' => '删除失败：' . $e->getMessage()
            ]);
        }
    }
}

