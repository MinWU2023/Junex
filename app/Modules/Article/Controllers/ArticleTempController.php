<?php
namespace App\Modules\Article\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Article\Models\ArticleFile;
use App\Modules\Url\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class ArticleController
 * @package App\Modules\Category\Controllers
 */
class ArticleTempController extends Controller
{


    public function preview($id, Request $request)
    {
        $translate = $request->get('translate');
        $model = Article::where([
            'is_temp' => 1,
            'id' => $id
        ])->first();
        is_array($translate) ? $data = array_merge($translate, $request->all()) : $data = $request->all();
        try {
            if ($model) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                $data = array_filter($data, function ($value) {
                    // 如果 value 不是 false, null, 空字符串, 数组为空或者 0，则返回 true
                    return ($value !== false && $value !== null && $value !== '' && (is_array($value) ? count($value) > 0 : true) && $value !== 0);
                });
                unset($data['url_key']);
                $model->update($data);
            } else {
                $data['is_temp'] = 1;
                $data['admin_user_id'] = auth()->user()->id;
                if (!$data['article_category_id']){
                    $data['article_category_id'] =  $this->getCate();
                }
                if (!isset($data['en']['name'])) {
                    $data['en']['name'] = '请输入名称';
                }
                if (!isset($data['en']['content'])) {
                    $data['en']['content'] = '请输入详情内容';
                }
                $data['url_key'] = 'preArticle-'.rand(1, 10000);
                $model = Article::create($data);
            }
            $this->createArticleFile($model, $request);
        }catch (\PDOException $exception){
            Log::error('articleModel:update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->data([
            'temp_model_id' => $model->id,
            'url_key' => url($model->url_key)
        ]);
    }



    protected function createArticleFile(Article $article, $request)
    {
        if ($filePaths = $request->get('filePath')) {
            $sorts = $request->get('fileSorts');
            $names = $request->get('fileNames');
            foreach ($filePaths as $key => $imgPath) {
                $add = [];
                $add['article_id'] = $article->id;
                $add['path'] = $imgPath;
                $add['name'] = $names[$key];
                $add['sort'] = $sorts[$key];
                ArticleFile::create($add);
            }
        }
    }



    protected function getCate()
    {
        $category = ArticleCategory::query()->first();
        if (!$category){
            $category = ArticleCategory::query()->create([
                'en' => [
                    'name' => 'previewArticleCate'
                ],
                'url_key' => Str::slug('previewArticleCate')
            ]);
        }
        return $category->id;
    }


    public function delete($id)
    {
        $is_del = false;
        $model = Article::with(['articleFiles'])->where([
            'is_temp' => 1,
            'id' => $id
        ])->first();
        if ($model) {
            $this->delTempModel($model->id);
            $is_del = true;
        }
        $models = Article::where('is_temp', 1)->where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1day")))->get();
        foreach ($models as $model) {
            $this->delTempModel($model->id);
            $is_del = true;
        }
        if ($is_del){
            $maxId = Article::query()->max('id');
// 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
// 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE articles AUTO_INCREMENT = $newStartingId;");
        }
        return $this->success();
    }



    protected function delTempModel($model_id)
    {
        DB::table('article_files')->where('article_id',$model_id)->delete();
        Article::where('id',$model_id)->delete();
        Url::withTrashed()->where([
            'urlable_type' => 'App\Modules\Article\Models\Article',
            'urlable_id' => $model_id
        ])->forceDelete();
    }


}
