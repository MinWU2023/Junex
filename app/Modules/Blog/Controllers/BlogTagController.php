<?php
namespace App\Modules\Blog\Controllers;


use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Common\Collections\CommonCollection;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Locale;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BlogTagController extends BaseController{


    public function __construct(BlogTag $blogTag)
    {
        $this->modelName = 'BlogTag';
        $this->model = $blogTag->with(['translations']);
        $this->modelSource = $blogTag;
        $this->viewPath = 'Blog.Views.blogTag';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.'.config('app.locale').'.name' => 'required',
        ];
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(BlogTag::with(['translations:name,blog_tag_id,locale','blogs']),function ($query)use($request){
                if ($name = $request->post('name')){
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->orderByDesc($this->orderBy)->paginate($request->input('limit', 15));

            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        $locales = Locale::get();
        return view($this->viewPath . '.index', compact('name','locales'));
    }

    /**
     * 清除未关联博客关键词
     */
    public function removes(){
        $tags = BlogTag::with(['blogs'])->get();
        foreach ($tags as $tag) {
            if (!isset($tag->blogs[0])) {
                $tag->delete();
            }
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        if ($request->post('url_key')) {
            $this->validatorData['url_key'] = [
                'required',
                new UrlKeyRule($id,BlogTag::class),
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
            $model->update($update);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }



    public function detachTag(Request $request)
    {
        $blog = Blog::query()->find($request->get('blog'));
        if ($blog) {
            $blog->blogTags()->detach($request->get('tag'));
        }
        return $this->success();
    }


    public function allBlogTags()
    {
        $blogTags = BlogTag::all();
        $active = Addon::query()->where(['sign'=>'Adwords','status'=>1])->first();
        return ['data' => collect($blogTags)->map(function ($map) {
            return [
                'value' => $map->id,
                'label' => $map->name
            ];
        }),'active'=>$active?1:0];
    }


    public function export(Request $request)
    {
        $ids = $request->post('ids');
        $locale = $request->post('locale');
        $data = [
            [
                'id',
                'tag名',
            ],
        ];
        if ($ids) {
            $tags = BlogTag::whereIn('id', $ids)->get();
        } else {
            $tags = BlogTag::get();
        }
        foreach ($tags as $tag) {
            if (isset($tag->translate($locale)->name)) {
                $tag_name = $tag->translate($locale)->name;
            } else {
                $tag_name = $tag->name;
            }
            $data[] = [
                $tag->id,
                $tag_name
            ];
        }
        return new CommonCollection($data);
    }



}
