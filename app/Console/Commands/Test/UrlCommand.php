<?php

namespace App\Console\Commands\Test;

use App\Modules\Url\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Modules\Article\Models\ArticleCategory;


class UrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected static function newUrl($key,&$url_key)
    {
        $repeat = Url::where([
            'url' => $url_key,
        ])
            ->first();
        if ($repeat) {
            $url_key = config('url.'.$key) . $url_key . '-' . rand(1, 1000);
            self::newUrl($key,$url_key);
        }
    }


    

    protected function checkUrl()
    {
        $urlable_types = [
            'App\Modules\Article\Models\ArticleCategory',
            'App\Modules\Article\Models\Article',
            'App\Modules\Blog\Models\BlogCategory',
            'App\Modules\Blog\Models\Blog',
            'App\Modules\Blog\Models\BlogTag',
            'App\Modules\Download\Models\DownloadCategory',
            'App\Modules\Page\Models\Page',
            'App\Modules\Product\Models\ProductCategory',
            'App\Modules\Product\Models\Product',
            'App\Modules\Product\Models\ProductTag',
        ];

        foreach ($urlable_types as $urlable_type){
            $model =  new $urlable_type;
            if ($model->count() == DB::table('urls')->where('urlable_type',$urlable_type)->count()){
                $this->info($urlable_type.'链接准确，共'.$model->count().'个');
            }else{
                $this->warn($urlable_type.'count1:'.$model->count().'---count2:'.DB::table('urls')->where('urlable_type',$urlable_type)->count());
            }
        }
    }

    public function handle()
    {
        if ($this->confirm('确定全站重新生成新连接？,上线有收录后请勿操作！！！')){
            Log::info('执行了重置链接操作,时间:'.date('Y-m-d H:i:s'));
            Url::truncate();
            $urlable_types = [
                'article_category' => 'App\Modules\Article\Models\ArticleCategory',
                'article' => 'App\Modules\Article\Models\Article',
                'blog_category' => 'App\Modules\Blog\Models\BlogCategory',
                'blog_tag' => 'App\Modules\Blog\Models\BlogTag',
                'blog' => 'App\Modules\Blog\Models\Blog',
                'download_category' => 'App\Modules\Download\Models\DownloadCategory',
                'page' => 'App\Modules\Page\Models\Page',
                'product_category' => 'App\Modules\Product\Models\ProductCategory',
                'product' => 'App\Modules\Product\Models\Product',
                'product_tag' => 'App\Modules\Product\Models\ProductTag',
            ];
            foreach ($urlable_types as $key=> $urlable_type) {
                $models = new $urlable_type;
                if (method_exists($models,'scopeActive')){
                    $models->active()->chunk(200, function ($models) use ($key,$urlable_type, &$count) {
                        foreach ($models as $model) {
                            try {
                                if($key == 'article'){
                                    if(config('url.article') == 'diy/'){
                                        $article_category = ArticleCategory::find($model->article_category_id);
                                        $url_key = Str::slug($article_category->name,'-', config('app.locale')).'/'. Str::slug($model->name, '-', config('app.locale'));
                                    }else{
                                        $url_key = config('url.article').Str::slug($model->name, '-', config('app.locale'));
                                    }
                                }else{
                                    $url_key = config('url.'.$key). Str::slug($model->name, '-', config('app.locale'));
                                }
                              
                                $repeat = Url::where([
                                    'url' => $url_key,
                                ])->first();
                                if ($repeat) {
                                    self::newUrl($key,$url_key);
                                }
                                $model->url_key = $url_key;
                                $model->save();
                                DB::table('urls')->updateOrInsert([
                                    'url'=> $url_key,
                                    'urlable_type'=> $urlable_type,
                                    'urlable_id'=> $model->id,
                                ],[
                                    'created_at' => date('Y-m-d H:i:s'),    
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                                // Url::query()->lockForUpdate()->updateOrCreate([
                                //     'url'=> $url_key,
                                //     'urlable_type'=> $urlable_type,
                                //     'urlable_id'=> $model->id,
                                // ]);
                            } catch (\Exception $exception) {
                                $this->error($exception->getMessage());
                                $this->warn('数据ID:' . $model->id . ',新url:' . $url_key);
                                $this->warn('url生成异常，请联系技术查看');
                            }
                        }
                    });
                }else{
                    $models->chunk(200, function ($models) use ($key,$urlable_type, &$count) {
                        foreach ($models as $model) {
                            try {
                                if($key == 'article'){
                                    $article_category = ArticleCategory::find($model->article_category_id);
                                    $url_key = Str::slug($article_category->name,'-', config('app.locale')).'/'. Str::slug($model->name, '-', config('app.locale'));
                                }else{
                                    $url_key = config('url.'.$key). Str::slug($model->name, '-', config('app.locale'));
                                }
                                $repeat = Url::where([
                                    'url' => $url_key,
                                ])->first();
                                if ($repeat) {
                                    self::newUrl($key,$url_key);
                                }
                                $model->url_key = $url_key;
                                $model->save();
                                DB::table('urls')->updateOrInsert([
                                    'url'=> $url_key,
                                    'urlable_type'=> $urlable_type,
                                    'urlable_id'=> $model->id,
                                ],[
                                    'created_at' => date('Y-m-d H:i:s'),    
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                                // Url::query()->lockForUpdate()->updateOrCreate([
                                //     'url'=> $url_key,
                                //     'urlable_type'=> $urlable_type,
                                //     'urlable_id'=> $model->id,
                                // ]);
                            } catch (\Exception $exception) {
                                $this->error($exception->getMessage());
                                $this->warn('数据ID:' . $model->id . ',新url:' . $url_key);
                                $this->warn('url生成异常，请联系技术查看');
                            }
                        }
                    });
                }
            }
            $this->info('全站url生成成功');
        }else{
            $this->info('已取消');
        }
    }

}
