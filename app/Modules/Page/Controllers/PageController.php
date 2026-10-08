<?php


namespace App\Modules\Page\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\PageFile;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PageController extends BaseController
{
    protected $orderBy = 'sort';

    public function __construct(Page $page)
    {
        $this->modelName = 'Page';
        $this->model = $page->with(['translations']);
        $this->modelSource =  $page;
        $this->viewPath = 'Page.Views';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required',
            'translate.' . config('app.locale') . '.content' => 'required',
        ];
        $this->messages = [
            'translate.' . config('app.locale') . '.name.required' => '请填写名称(' . config('app.locale') . ')',
            'translate.' . config('app.locale') . '.content.required' => '请填写详情(' . config('app.locale') . ')',
        ];
    }

    private const TRANSLATABLE_FIELDS = [
        'brief_content', 'content', 'title', 'keywords', 'description'
    ];


    public function changeProperty($id, Request $request)
    {
        $model = $this->model->find($id);
        switch ($request->type) {
            case 'page_sort':
                $model->sort = intval($request->get('sort'));
                break;
        }
        $model->save();
        return $this->success();
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Page::query()->with(['translations:name,page_id,locale'])->orderByDesc($this->orderBy)->active(), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->paginate($request->input('limit', 10000));

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
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->orderByDesc($this->orderBy), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->unActive()->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.trash', compact('name'));
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->messages);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            if (empty($request->get('url_key')) && isset($add[config('app.locale')]['name'])) $add['url_key'] = config('url.page').Str::slug($add[config('app.locale')]['name'], '-', config('app.locale'));
            $page = $this->model->create($add);
            $this->createArticleFile($page, $request);
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.$request->user()->email.'新增单页面('.$page->id.')'.$page->name,
                'modelName'=> $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        if ($request->post('url_key')) {
            $this->validatorData['url_key'] = [
                'required',
                new UrlKeyRule($id,Page::class),
            ];
        }
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->messages);
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
            $update['updated_at'] = date('Y-m-d H:i:s');
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                if (array_key_exists($field, $update[config('app.locale')]) && empty(trim($update[config('app.locale')][$field]))) {
                    foreach (config('translatable.locales') as $locale) {
                        $update[$locale][$field] = null;
                    }
                }
            }
            $model->update($update);
            DB::table('page_files')->where('page_id', $model->id)->delete();
            $this->createArticleFile($model, $request);
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.$request->user()->email.'编辑单页面('.$model->id.')'.$model->name,
                'modelName'=> $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function restore($id)
    {
        $article = Page::find($id);
        try {
            $article->active = 1;
            $article->save();
        } catch (\PDOException $exception) {
            Log::error('PageController:restore:单页面（' . $id . '）恢复失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $article = Page::find($id);
        try {
            $article->active = 0;
            $article->save();
        } catch (\PDOException $exception) {
            Log::error('PageController:remove:单页面（' . $id . '）软删除失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    protected function createArticleFile(Page $page, $request)
    {
        if ($filePaths = $request->get('filePath')) {
            $sorts = $request->get('fileSorts');
            $names = $request->get('fileNames');
            foreach ($filePaths as $key => $imgPath) {
                $add = [];
                $add['page_id'] = $page->id;
                $add['path'] = $imgPath;
                $add['name'] = $names[$key];
                $add['sort'] = $sorts[$key];
                PageFile::create($add);
            }
        }
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        try {
            $model->delete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.\request()->user()->email.'将单页面('. $model->id . ')'.$model->name.'删除',
                'modelName'=> $this->modelName,
            ]);
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Page\Models\Page',
                'urlable_id' => $model->id
            ])->forceDelete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

}
