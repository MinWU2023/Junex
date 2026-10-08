<?php

namespace App\Modules\Blog\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\User;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogFile;
use App\Modules\Blog\Models\BlogScheduledPublish;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Modules\Blog\Collections\BlogListCollection;

class BlogDraftController extends BaseController
{
    private const TRANSLATABLE_FIELDS = [
        'content',
        'title',
        'keywords',
        'description'
    ];

    public function __construct(Blog $blog)
    {
        $this->modelName = 'Blog';
        $this->model = $blog;
        $this->modelSource = $blog;
        $this->viewPath = 'Blog.Views.draft';
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

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        $id = $request->get('id');

        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(
                Blog::query()->with(['translations:name,blog_id,locale', 'admin', 'blogCategory', 'blogTags', 'scheduledPublish']),
                function ($query) use ($request) {
                    if ($name = $request->get('name')) {
                        $query->whereTranslationLike('name', '%' . $name . '%');
                    }
                    if ($id = $request->get('id')) {
                        $query->where('id', $id);
                    }
                    if ($category_id = $request->get('category_id')) {
                        $cate_ids = [$category_id];
                        BlogController::getChildrenIds($cate_ids, $category_id);
                        $query->whereIn('blog_category_id', $cate_ids);
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

            if ($request->get('keywords')) {
                $data->whereHas('blogTags', function ($query) use ($request) {
                    if ($keywords = $request->get('keywords')) {
                        $query->whereTranslationLike('name', $keywords);
                    }
                });
            }

            $data = $data->paginate($request->input('limit', 15));

            return new BlogListCollection($data);
        }

        $admins = User::query()->get();
        return view($this->viewPath . '.index', compact('name', 'id', 'admins'));
    }

    public function edit($id)
    {
        $model = $this->model->with(['blogCategory', 'blogTags'])->find($id);
        $data = $this->checkTranslate($id);
        $data['model'] = $model;

        // 清理临时博客
        $blogs = Blog::where('is_temp', 1)->where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1day")))->get();
        $is_del = false;
        foreach ($blogs as $blog) {
            DB::table('blog_files')->where('blog_id', $blog->id)->delete();
            DB::table('blog_blog_tag')->where('blog_id', $blog->id)->delete();
            Blog::where('id', $blog->id)->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Blog\Models\Blog',
                'urlable_id' => $blog->id
            ])->forceDelete();
            $is_del = true;
        }
        if ($is_del) {
            $maxId = Blog::query()->max('id');
            $newStartingId = $maxId + 1;
            DB::statement("ALTER TABLE blogs AUTO_INCREMENT = $newStartingId;");
        }

        return view($this->viewPath . '.edit', $data);
    }

    public function update($id, Request $request)
    {
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
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $model->admin_user_id) {
            return $this->badRequest('无权限修改');
        }

        $translate = $request->get('translate');
        $temp_ids = Blog::where('is_temp', 1)->pluck('id')->toArray();
        $temp_ids[] = $id;
        $repeat = DB::table('blog_translations')->where([
            'locale' => config('app.locale'),
            'name' => $translate[config('app.locale')]['name']
        ])->whereNotIn('blog_id', $temp_ids)->first();
        if ($repeat) {
            $validator->errors()->add('field', '博客标题已存在，请修改');
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            $temp_blog_id = $request->get('temp_blog_id');
            $this->delTempBlog($temp_blog_id);

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
            DB::table('blog_files')->where('blog_id', $model->id)->delete();
            $this->createBlogFile($model, $request);
            $this->createBlogTag($model, $request);

            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . '编辑博客(' . $model->id . ')' . $model->name,
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
            case 'blog_sort':
                $model->sort = intval($request->get('sort'));
                break;
        }
        $model->save();
        return $this->success();
    }

    protected function delTempBlog($temp_blog_id)
    {
        $blog = Blog::with(['blogTags'])->where([
            'is_temp' => 1,
            'id' => $temp_blog_id,
        ])->first();
        if ($blog) {
            DB::table('blog_files')->where('blog_id', $blog->id)->delete();
            $blog->blogTags()->detach($blog->blogTags);
            $blog->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Blog\Models\Blog',
                'urlable_id' => $blog->id
            ])->forceDelete();
            $maxId = Blog::query()->max('id');
            $newStartingId = $maxId + 1;
            DB::statement("ALTER TABLE blogs AUTO_INCREMENT = $newStartingId;");
        }
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $model->admin_user_id) {
            return $this->badRequest('无权限');
        }
        try {
            DB::table('blog_files')->where('blog_id', $model->id)->delete();
            $model->blogTags()->detach($model->blogTags);
            $model->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Blog\Models\Blog',
                'urlable_id' => $model->id
            ])->forceDelete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . \request()->user()->email . '将博客(' . $model->id . ')' . $model->name . '删除',
                'modelName' => $this->modelName,
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
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
                if (isset($names[$key])) {
                    $add = [];
                    $add['blog_id'] = $blog->id;
                    $add['path'] = $imgPath;
                    $add['name'] = $names[$key];
                    $add['sort'] = isset($sorts[$key]) ? $sorts[$key] : 0;
                    BlogFile::create($add);
                }
            }
        }
    }

    protected function createBlogTag(Blog $blog, $request)
    {
        DB::table('blog_blog_tag')->where('blog_id', $blog->id)->delete();
        $tag_names = $request->get('tag_names');
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

        return true;
    }

    /**
     * 设置定时发布
     */
    public function setSchedule(Request $request, $id)
    {
        try {
            $blog = Blog::with(['translations', 'blogCategory'])->findOrFail($id);

            // 验证博客是否为草稿
            if ($blog->is_draft != 1 || $blog->active != 0) {
                return response()->json([
                    'code' => 1,
                    'msg' => '只能为草稿博客设置定时发布'
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

            // 验证博客必填字段
            $validationErrors = $this->validateBlogRequiredFields($blog);
            if (!empty($validationErrors)) {
                return response()->json([
                    'code' => 1,
                    'msg' => '博客信息不完整，请先完善以下必填项：' . implode(', ', $validationErrors),
                    'errors' => $validationErrors
                ]);
            }

            // 创建或更新定时发布记录
            BlogScheduledPublish::updateOrCreate(
                ['blog_id' => $id],
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
     * 验证博客必填字段
     */
    protected function validateBlogRequiredFields($blog)
    {
        $errors = [];
        $locale = config('app.locale');

        // 1. 验证排序
        if (empty($blog->sort) && $blog->sort !== 0) {
            $errors[] = '博客排序';
        }

        // 2. 验证分类
        if (empty($blog->blog_category_id)) {
            $errors[] = '博客分类';
        }

        // 3. 验证博客名（翻译字段）
        $translation = $blog->translations->firstWhere('locale', $locale);
        if (!$translation || empty($translation->name)) {
            $errors[] = '博客标题';
        }

        // 4. 验证详情内容（翻译字段）
        if (!$translation || empty($translation->content)) {
            $errors[] = '博客内容';
        }

        return $errors;
    }

    /**
     * 删除定时发布
     */
    public function deleteSchedule(Request $request, $id)
    {
        try {
            $schedule = BlogScheduledPublish::where('blog_id', $id)->first();

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


