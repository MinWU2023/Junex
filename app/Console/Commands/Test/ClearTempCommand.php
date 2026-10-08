<?php

namespace App\Console\Commands\Test;

use App\Modules\Article\Models\Article;
use App\Modules\Blog\Models\Blog;
use App\Modules\Page\Models\Page;
use App\Modules\Product\Models\Product;
use App\Modules\Url\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearTempCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:temp';

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

    protected function delPageTempModel($model_id)
    {
        DB::table('page_files')->where('page_id',$model_id)->delete();
        Page::where('id',$model_id)->delete();
        Url::withTrashed()->where([
            'urlable_type' => 'App\Modules\Page\Models\Page',
            'urlable_id' => $model_id
        ])->forceDelete();
    }

    public function deletePage()
    {
        $is_del = false;
        $models = Page::where('is_temp', 1)->get();
        foreach ($models as $model) {
            $this->delPageTempModel($model->id);
            $is_del = true;
        }
        if ($is_del){
            $maxId = Page::query()->max('id');
// 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
// 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE pages AUTO_INCREMENT = $newStartingId;");
        }
        $this->info('单页面临时页面清除成功');
    }

    protected function delTempProduct($product_id)
    {
        DB::table('product_attribute_values')->where('product_id', $product_id)->delete();
        DB::table('product_product_tag')->where('product_id',$product_id)->delete();
        DB::table('product_attribute_values')->where('product_id',$product_id)->delete();
        Product::where('id',$product_id)->delete();
        Url::withTrashed()->where([
            'urlable_type' => 'App\Modules\Product\Models\Product',
            'urlable_id' => $product_id
        ])->forceDelete();

    }


    public function deleteProduct()
    {
        $is_del = false;
        $products = Product::where('is_temp', 1)->get();
        foreach ($products as $model) {
            $this->delTempProduct($model->id);
            $is_del = true;
        }
        if ($is_del){
            $maxId = Product::query()->max('id');
// 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
// 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE products AUTO_INCREMENT = $newStartingId;");
        }
        $this->info('产品临时页面清除成功');
    }


    public function deleteArticle()
    {
        $is_del = false;
        $models = Article::where('is_temp', 1)->get();
        foreach ($models as $model) {
            $this->delArticleTempModel($model->id);
            $is_del = true;
        }
        if ($is_del){
            $maxId = Article::query()->max('id');
// 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
// 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE articles AUTO_INCREMENT = $newStartingId;");
        }
        $this->info('文章临时页面清除成功');
    }


    protected function delArticleTempModel($model_id)
    {
        DB::table('article_files')->where('article_id',$model_id)->delete();
        Article::where('id',$model_id)->delete();
        Url::withTrashed()->where([
            'urlable_type' => 'App\Modules\Article\Models\Article',
            'urlable_id' => $model_id
        ])->forceDelete();
    }



    protected function delBlogTempModel($model_id)
    {
        DB::table('blog_blog_tag')->where('blog_id',$model_id)->delete();
        DB::table('blog_files')->where('blog_id',$model_id)->delete();
        Blog::where('id',$model_id)->delete();
        Url::withTrashed()->where([
            'urlable_type' => 'App\Modules\Blog\Models\Blog',
            'urlable_id' => $model_id
        ])->forceDelete();
    }


    public function deleteBlog()
    {
        $is_del = false;
        $models = Blog::where('is_temp', 1)->get();
        foreach ($models as $model) {
            $this->delBlogTempModel($model->id);
            $is_del = true;
        }
        if ($is_del){
            $maxId = Blog::query()->max('id');
// 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
// 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE blogs AUTO_INCREMENT = $newStartingId;");
        }
        $this->info('博客临时页面清除成功');
    }





    public function handle()
    {
        $this->deleteProduct();
        $this->deleteBlog();
        $this->deleteArticle();
        $this->deletePage();
    }

}
