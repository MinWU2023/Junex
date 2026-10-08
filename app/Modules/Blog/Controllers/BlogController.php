<?php

namespace App\Modules\Blog\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\User;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogFile;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class BlogController
 * @package App\Modules\Category\Controllers
 */
class BlogController extends BaseController
{
    public function __construct(Blog $blog)
    {
        $this->modelName = 'Blog';
        $this->model = $blog->with(['translations', 'blogTags']);
        $this->modelSource =  $blog;
        $this->viewPath = 'Blog.Views.blog';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'blog_category_id' => 'required',
            'translate.' . config('app.locale') . '.name' => 'required',
            'translate.' . config('app.locale') . '.content' => 'required',
        ];

        $this->validatorMessages = [
            'blog_category_id.required' => '请选择博客分类',
            'translate.' . config('app.locale') . '.name.required' => '标题(' . config('app.locale') . ')不能为空',
            'translate.' . config('app.locale') . '.content.required' => '内容(' . config('app.locale') . ')不能为空',
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
            $data = tap(Blog::with(['translations:name,blog_id,locale', 'blogCategory', 'admin']), function ($query) use ($request) {
                if ($category_id = $request->get('category_id')) {
                    $cate_ids = [$category_id];
                    self::getChildrenIds($cate_ids, $category_id);
                    $query->whereIn('blog_category_id', $cate_ids);
                }
                if ($name = $request->post('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            });
            if (!in_array(\auth()->id(), User::ALLOW_ADMIN_ID)) {
                $data->whereHas('admin', function ($query) {
                    $query->where('admin_user_id', \auth()->id());
                });
            };
            $data = $data->active()->orderByDesc('updated_at')->paginate($request->input('limit', 15));
            return new CommonResourceCollection($data);
        }
        return view($this->viewPath . '.index', compact('name'));
    }


    public static function getChildrenIds(&$cate_ids, $id)
    {
        $childrens = BlogCategory::query()->where('parent_id', $id)->get();
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
            $data = tap(Blog::with(['translations', 'blogCategory']), function ($query) use ($request) {
                if ($name = $request->post('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->unActive()->where('is_draft', 0)->orderByDesc('updated_at')->paginate($request->input('limit', 15));
            return new CommonResourceCollection($data);
        }
        return view($this->viewPath . '.trash', compact('name'));
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
        
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        if (empty($request->get('url_key'))) {
            $add['url_key'] = config('url.blog') . Str::slug($add[config('app.locale')]['name']);
        }
        $add['admin_user_id'] = auth()->id();
        
        try {
            $blog = $this->model->create($add);
            $this->createBlogFile($blog, $request);
            $this->createBlogTag($blog, $request);
            
            if ($action === 'draft') {
                $blog->is_draft = 1;
                $blog->active = 0;
                $blog->save();
            }
            
            $actionText = $action === 'draft' ? '保存草稿' : '新增博客';
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . $actionText . '(' . $blog->id . ')' . $blog->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    protected function createBlogTag(Blog $blog, $request)
    {
        $tag_names = $request->get('tag_names');
        if ($tag_names) {
            $tag_names = array_values(array_filter($tag_names));
            $tagIds = [];
            if (isset($tag_names[0])) {
                foreach ($tag_names as $tag_name) {
                    if ($tag_name = merge_spaces($tag_name)) {
                        $blogTag = BlogTag::whereTranslation('name', $tag_name)->first();
                        if ($blogTag) {
                            $blogTag->name = $tag_name;
                            $blogTag->save();
                        } else {
                            $blogTag = BlogTag::create([
                                'url_key' => config('url.blog_tag') . Str::slug($tag_name, '-', config('app.locale')),
                                'sort' => 0,
                                config('app.locale') => [
                                    'name' => $tag_name
                                ]
                            ]);
                        }
                        $tagIds[] = $blogTag->id;
                    }
                }
                $blog->blogTags()->sync($tagIds);
            }
        }
        return true;
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
                new UrlKeyRule($id, Blog::class),
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
        try {
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                if (array_key_exists($field, $update[config('app.locale')]) && empty(trim($update[config('app.locale')][$field]))) {
                    foreach (config('translatable.locales') as $locale) {
                        $update[$locale][$field] = null;
                    }
                }
            }
            $model->update($update);
            DB::table('blog_files')->where('blog_id', $model->id)->delete();
            $this->createBlogFile($model, $request);
            $this->createBlogTag($model, $request);
            
            $actionText = $action === 'draft' ? '保存草稿' : '编辑博客';
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

    public function changeProperty($id, Request $request)
    {
        $model = $this->modelSource->find($id);
        switch ($request->type) {
            case 'blog_sort':
                $model->sort = intval($request->get('sort'));
                break;
        }
        $model->save();
        return $this->success();
    }

    public function restore($id)
    {
        $blog = Blog::find($id);
        try {
            $blog->active = 1;
            $blog->save();
        } catch (\PDOException $exception) {
            Log::error('BlogController:restore:文章（' . $id . '）恢复失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $blog = Blog::find($id);
        try {
            $blog->active = 0;
            $blog->save();
        } catch (\PDOException $exception) {
            Log::error('BlogController:remove:文章（' . $id . '）软删除失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    protected function createBlogFile(Blog $blog, $request)
    {
        if ($filePaths = $request->get('filePath')) {
            $sorts = $request->get('fileSorts');
            $names = $request->get('fileNames');
            foreach ($filePaths as $key => $imgPath) {
                $add = [];
                $add['blog_id'] = $blog->id;
                $add['path'] = $imgPath;
                $add['name'] = $names[$key];
                $add['sort'] = $sorts[$key];
                BlogFile::create($add);
            }
        }
    }



    public function multipleDestroy(Request $request)
    {
        $ids = $request->get('ids');
        $this->model->whereIn('id', $ids)->delete();
        Url::withTrashed()->where(['urlable_type' => 'App\Modules\Blog\Models\Blog'])->whereIn('urlable_id', $ids)->forceDelete();
        return $this->success();
    }


    public function destroy($id)
    {
        $model = $this->model->find($id);
        try {
            $model->delete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . \request()->user()->email . '将博客(' . $model->id . ')' . $model->name . '删除',
                'modelName' => $this->modelName,
            ]);
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Blog\Models\Blog',
                'urlable_id' => $model->id
            ])->forceDelete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }
}
