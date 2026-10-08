<?php

namespace App\Http\Middleware;

use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleScheduledPublish;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogScheduledPublish;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductScheduledPublish;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CheckScheduledPublish
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 使用缓存锁，确保同一时间只有一个请求执行检查
        // 锁的有效期10秒，避免并发执行
        $lock = Cache::lock('scheduled_publish_check', 10);
        if ($lock->get()) {
            try {
                // 获取上次检查的时间
                $lastCheck = Cache::get('scheduled_publish_last_check', 0);
                $now = time();

                // 只有距离上次检查超过60秒才执行新的检查
                // 这样即使访问量很大，也只是每分钟查询一次数据库
                if ($now - $lastCheck >= 60) {
                    $this->publishScheduledProducts();
                    $this->publishScheduledArticles();
                    $this->publishScheduledBlogs();

                    // 更新最后检查时间，缓存120秒
                    Cache::put('scheduled_publish_last_check', $now, 120);
                }
            } catch (\Exception $e) {
                Log::error('自动发布检查失败: ' . $e->getMessage());
            } finally {
                // 释放锁
                $lock->release();
            }
        }

        return $next($request);
    }

    /**
     * 发布到期的定时产品
     */
    protected function publishScheduledProducts()
    {
        try {
            // 查找所有到期的定时发布记录
            $scheduledPublishes = ProductScheduledPublish::where('publish_at', '<=', now())->get();

            if ($scheduledPublishes->isEmpty()) {
                return;
            }

            foreach ($scheduledPublishes as $schedule) {
                $product = Product::find($schedule->product_id);

                if ($product && $product->is_draft == 1 && $product->active == 0) {
                    // 发布产品
                    $product->active = 1;
                    $product->is_draft = 0;
                    $product->save();
                    // 删除定时发布记录
                    $schedule->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error('发布定时产品失败: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 发布到期的定时文章
     */
    protected function publishScheduledArticles()
    {
        try {
            // 查找所有到期的定时发布记录
            $scheduledPublishes = ArticleScheduledPublish::where('publish_at', '<=', now())->get();

            if ($scheduledPublishes->isEmpty()) {
                return;
            }

            foreach ($scheduledPublishes as $schedule) {
                $article = Article::find($schedule->article_id);

                if ($article && $article->is_draft == 1 && $article->active == 0) {
                    // 发布文章
                    $article->active = 1;
                    $article->is_draft = 0;
                    $article->save();
                    // 删除定时发布记录
                    $schedule->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error('发布定时文章失败: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 发布到期的定时博客
     */
    protected function publishScheduledBlogs()
    {
        try {
            // 查找所有到期的定时发布记录
            $scheduledPublishes = BlogScheduledPublish::where('publish_at', '<=', now())->get();

            if ($scheduledPublishes->isEmpty()) {
                return;
            }

            foreach ($scheduledPublishes as $schedule) {
                $blog = Blog::find($schedule->blog_id);

                if ($blog && $blog->is_draft == 1 && $blog->active == 0) {
                    // 发布博客
                    $blog->active = 1;
                    $blog->is_draft = 0;
                    $blog->save();
                    // 删除定时发布记录
                    $schedule->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error('发布定时博客失败: ' . $e->getMessage());
            throw $e;
        }
    }
}
