<?php
namespace App\Repeats\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Repeats\Models\Article;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ArticleController extends \App\Modules\Article\Controllers\ArticleController
{

    public function __construct(Article $article)
    {
        parent::__construct($article);
        $this->viewPath = 'article';
        $this->model = $article->with(['translations']);
    }


    /**
     * 重写列表页面，对应视图位置app/Repeats/views/article/index.php
     */
    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Article::with(['translations', 'articleCategory'=>function($query){
                $query->with(['translations']);
            }]), function ($query) use ($request){
                if ($category_id = $request->get('category_id')) {
                    $query->where('article_category_id', $category_id);
                }
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->active()->orderByDesc('sort')->paginate($request->input('limit', 15));;
            return new CommonResourceCollection($data);
        }
        return view( $this->viewPath.'.index', compact('name'));
    }



    /**
     * 重写修改页面，对应视图位置app/Repeats/views/article/edit.php
     */
    public function edit($id)
    {
        $model = $this->model->find($id);
        return view($this->viewPath . '.edit',
            [
                'model' => $model,
            ]
        );
    }



    /**
     * 重写修改保存逻辑
     */
    public function update($id, Request $request)
    {
        $this->validatorData['url_key'] = [
            new UrlKeyRule($id),
        ];
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
            $model->update($update);
            DB::table('article_files')->where('article_id', $model->id)->delete();
            $this->createArticleFile($model, $request);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

}
