<?php

namespace App\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Page\Models\FrontPageControl;
use App\Modules\Page\Models\Page;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductVideo;
use App\Modules\Product\Models\ProductVideoCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class FrontPageCatalogService
{
    public const CACHE_KEY = 'front_page_closed_paths';

    public function tabs(): array
    {
        return [
            'all' => '全部',
            'home' => '首页',
            'product' => '产品',
            'content' => '内容',
            'company' => '公司',
            'account' => '账户',
            'other' => '其他',
            'cms' => '单页面',
        ];
    }

    /**
     * Fixed front pages declared in routes/web.php.
     *
     * @return array<int, array{path:string,name:string,tab:string,source:string,source_label:string}>
     */
    public function routePages(): array
    {
        $items = [
            ['path' => '', 'name' => '首页', 'tab' => 'home'],
            ['path' => 'products', 'name' => '产品列表', 'tab' => 'product'],
            ['path' => 'newstyle', 'name' => '新款展示', 'tab' => 'product'],
            ['path' => 'blogs', 'name' => '博客列表', 'tab' => 'content'],
            ['path' => 'videos', 'name' => '视频列表', 'tab' => 'content'],
            ['path' => 'faqs', 'name' => '常见问题', 'tab' => 'content'],
            ['path' => 'reviews', 'name' => '评论', 'tab' => 'content'],
            ['path' => 'about-us', 'name' => '关于我们', 'tab' => 'company'],
            ['path' => 'contact-us', 'name' => '联系我们', 'tab' => 'company'],
            ['path' => 'customer-services', 'name' => '客户服务', 'tab' => 'company'],
            ['path' => 'privacy-policy', 'name' => '隐私政策', 'tab' => 'company'],
            ['path' => 'login', 'name' => '登录', 'tab' => 'account'],
            ['path' => 'register', 'name' => '注册', 'tab' => 'account'],
            ['path' => 'forget', 'name' => '忘记密码', 'tab' => 'account'],
            ['path' => 'myinquirys', 'name' => '我的询盘', 'tab' => 'account'],
            ['path' => 'inquiry-list', 'name' => '询盘列表', 'tab' => 'account'],
            ['path' => 'search', 'name' => '搜索', 'tab' => 'other'],
            ['path' => 'inquirysuccess', 'name' => '询盘成功', 'tab' => 'other'],
            ['path' => 'notfound', 'name' => '404 页面', 'tab' => 'other'],
        ];

        return array_map(function (array $item) {
            $item['source'] = 'route';
            $item['source_label'] = '路由页面';
            return $item;
        }, $items);
    }

    /**
     * @return array<int, array{path:string,name:string,tab:string,source:string,source_label:string}>
     */
    public function cmsPages(): array
    {
        if (!Schema::hasTable('pages')) {
            return [];
        }

        $rows = [];
        $pages = Page::query()
            ->where('is_temp', 0)
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->get();

        foreach ($pages as $page) {
            $path = trim((string)$page->url_key, '/');
            if ($path === '') {
                continue;
            }
            $name = trim((string)($page->name ?? ''));
            if ($name === '') {
                $name = $path !== '' ? $path : ('页面#' . $page->id);
            }
            $rows[] = [
                'path' => $path,
                'name' => $name,
                'tab' => 'cms',
                'source' => 'page',
                'source_label' => '单页面',
            ];
        }

        return $rows;
    }

    public function sync(): void
    {
        if (!Schema::hasTable('front_page_controls')) {
            return;
        }

        $seen = [];
        foreach (array_merge($this->routePages(), $this->cmsPages()) as $item) {
            $path = $this->normalizePath($item['path']);
            if (isset($seen[$path])) {
                continue;
            }
            $seen[$path] = true;

            $row = FrontPageControl::query()->firstOrNew(['path' => $path]);
            if (!$row->exists) {
                $row->sitemap_on = 1;
                $row->access_on = 1;
            }
            $row->name = (string)$item['name'];
            $row->save();
        }
    }

    public function paginate(string $tab, string $keyword, int $page, int $perPage = 15): LengthAwarePaginator
    {
        $this->sync();
        $controls = $this->controlsByPath();
        $keyword = mb_strtolower(trim($keyword));

        $rows = collect($this->displayRows())->filter(function (array $row) use ($tab, $keyword) {
            if ($tab !== 'all' && $row['tab'] !== $tab) {
                return false;
            }
            if ($keyword === '') {
                return true;
            }
            $hay = mb_strtolower($row['name'] . ' ' . $row['url']);
            return str_contains($hay, $keyword);
        })->map(function (array $row) use ($controls) {
            $control = $controls->get($row['path']);
            $row['sitemap_on'] = $control ? (bool)$control->sitemap_on : true;
            $row['access_on'] = $control ? (bool)$control->access_on : true;
            return $row;
        })->values();

        $page = max(1, $page);
        $slice = $rows->slice(($page - 1) * $perPage, $perPage)->values();

        return new Paginator(
            $slice,
            $rows->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }

    public function setFlags(array $paths, string $field, bool $value): int
    {
        if (!in_array($field, ['sitemap_on', 'access_on'], true)) {
            return 0;
        }

        $paths = array_values(array_unique(array_map(function ($path) {
            return $this->normalizePath($path);
        }, $paths)));

        // 允许更新首页 path=''；不要因空串被 array_filter 清掉
        if ($paths === []) {
            return 0;
        }

        $this->sync();

        // 确保每条 path 都有控制记录（含首页空 path）
        foreach ($paths as $path) {
            $row = FrontPageControl::query()->firstOrNew(['path' => $path]);
            if (!$row->exists) {
                $row->sitemap_on = 1;
                $row->access_on = 1;
                $row->name = $path === '' ? '首页' : $path;
            }
            $row->{$field} = $value ? 1 : 0;
            $row->save();
        }

        $count = FrontPageControl::query()
            ->whereIn('path', $paths)
            ->where($field, $value ? 1 : 0)
            ->count();

        $this->forgetAccessCache();
        $this->forgetPageCaches($paths);

        return $count;
    }

    /**
     * @return string[]
     */
    public function closedPaths(): array
    {
        if (!Schema::hasTable('front_page_controls')) {
            return [];
        }

        return Cache::remember(self::CACHE_KEY, 60, function () {
            return FrontPageControl::query()
                ->where(function ($q) {
                    $q->where('access_on', 0)->orWhere('access_on', false);
                })
                ->pluck('path')
                ->map(function ($path) {
                    return $this->normalizePath($path);
                })
                ->values()
                ->all();
        });
    }

    public function generateSitemap(): int
    {
        $this->sync();

        // 仅排除「关闭 sitemap」的受管页面；内容详情/分类始终生成
        $disabled = FrontPageControl::query()
            ->where(function ($q) {
                $q->where('sitemap_on', 0)->orWhere('sitemap_on', false);
            })
            ->pluck('path')
            ->map(function ($path) {
                return $this->normalizePath($path);
            })
            ->flip();

        $locs = [];

        // 1) 路由页 / 单页面：sitemap_on=1 才进
        foreach ($this->displayRows() as $row) {
            $path = $this->normalizePath($row['path']);
            if (isset($disabled[$path])) {
                continue;
            }
            $locs[$this->absoluteUrl($path)] = true;
        }

        // 2) 产品分类 + 产品详情
        if (Schema::hasTable('product_categories')) {
            ProductCategory::query()
                ->with('url')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$locs) {
                    foreach ($rows as $row) {
                        $path = $this->modelFrontPath($row);
                        if ($path !== null) {
                            $locs[$this->absoluteUrl($path)] = true;
                        }
                    }
                });
        }
        if (Schema::hasTable('products')) {
            Product::query()
                ->active()
                ->with('url')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$locs) {
                    foreach ($rows as $row) {
                        $path = $this->modelFrontPath($row);
                        if ($path !== null) {
                            $locs[$this->absoluteUrl($path)] = true;
                        }
                    }
                });
        }

        // 3) 博客分类 + 博客详情
        if (Schema::hasTable('blog_categories')) {
            BlogCategory::query()
                ->with('url')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$locs) {
                    foreach ($rows as $row) {
                        $path = $this->modelFrontPath($row);
                        if ($path !== null) {
                            $locs[$this->absoluteUrl($path)] = true;
                        }
                    }
                });
        }
        if (Schema::hasTable('blogs')) {
            Blog::query()
                ->active()
                ->with('url')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$locs) {
                    foreach ($rows as $row) {
                        $path = $this->modelFrontPath($row);
                        if ($path !== null) {
                            $locs[$this->absoluteUrl($path)] = true;
                        }
                    }
                });
        }

        // 4) 视频分类 + 视频详情
        if (Schema::hasTable('product_video_categories')) {
            ProductVideoCategory::query()
                ->with('url')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$locs) {
                    foreach ($rows as $row) {
                        if (isset($row->active) && !(int)$row->active) {
                            continue;
                        }
                        $path = $this->modelFrontPath($row);
                        if ($path !== null) {
                            $locs[$this->absoluteUrl($path)] = true;
                        }
                    }
                });
        }
        if (Schema::hasTable('product_videos')) {
            ProductVideo::query()
                ->active()
                ->with('url')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$locs) {
                    foreach ($rows as $row) {
                        $path = $this->modelFrontPath($row, 'video');
                        if ($path !== null) {
                            $locs[$this->absoluteUrl($path)] = true;
                        }
                    }
                });
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach (array_keys($locs) as $loc) {
            $xml .= '  <url><loc>' . htmlspecialchars($loc, ENT_XML1) . '</loc></url>' . "\n";
        }
        $xml .= '</urlset>' . "\n";

        $file = public_path('sitemap.xml');
        if (file_put_contents($file, $xml, LOCK_EX) === false) {
            throw new \RuntimeException('无法写入 sitemap.xml');
        }

        return count($locs);
    }

    /**
     * 从模型解析前台 path（不含域名）。
     */
    private function modelFrontPath($model, string $fallbackPrefix = ''): ?string
    {
        $path = '';
        try {
            if ($model->relationLoaded('url') && $model->url && !empty($model->url->url)) {
                $path = (string)$model->url->url;
            } elseif (!empty($model->url_key)) {
                $path = (string)$model->url_key;
            }
        } catch (\Throwable $e) {
            $path = (string)($model->url_key ?? '');
        }

        $path = $this->normalizePath($path);
        if ($path === '') {
            return null;
        }

        // 视频详情固定路由兜底：/video/{slug}
        if ($fallbackPrefix === 'video' && !str_starts_with($path, 'video/')) {
            $prefix = trim((string)config('url.product_video', 'video/'), '/');
            if ($prefix !== '' && str_starts_with($path, $prefix . '/')) {
                $path = substr($path, strlen($prefix) + 1);
            }
            $path = 'video/' . ltrim($path, '/');
        }

        return $path;
    }

    public function forgetAccessCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * 关闭/开启访问后清掉整页缓存，避免 cachepage 继续吐旧 200。
     *
     * @param string[] $paths
     */
    public function forgetPageCaches(array $paths): void
    {
        $base = rtrim((string)config('app.url'), '/');
        foreach ($paths as $path) {
            $path = $this->normalizePath($path);
            $urls = [];
            if ($path === '') {
                $urls[] = $base;
                $urls[] = $base . '/';
            } else {
                $urls[] = $base . '/' . $path;
            }
            foreach ($urls as $url) {
                Cache::forget($url);
            }
        }
    }

    public function normalizePath($path): string
    {
        $path = trim((string)$path);
        $path = preg_replace('#^https?://[^/]+#i', '', $path) ?? $path;
        return trim($path, '/');
    }

    /**
     * @return array<int, array{path:string,name:string,tab:string,source:string,source_label:string,url:string}>
     */
    private function displayRows(): array
    {
        $rows = [];
        $seen = [];
        // Route pages first so overlapping CMS pages with the same path are skipped
        foreach (array_merge($this->routePages(), $this->cmsPages()) as $item) {
            $path = $this->normalizePath($item['path']);
            if (isset($seen[$path])) {
                continue;
            }
            $seen[$path] = true;
            $item['path'] = $path;
            $item['url'] = $path === '' ? '/' : '/' . $path;
            $rows[] = $item;
        }
        return $rows;
    }

    private function controlsByPath()
    {
        return FrontPageControl::query()->get()->keyBy(function (FrontPageControl $row) {
            return $this->normalizePath($row->path);
        });
    }

    private function absoluteUrl(string $path): string
    {
        $base = rtrim((string)request()->getSchemeAndHttpHost(), '/');
        if ($path === '') {
            return $base . '/';
        }
        return $base . '/' . ltrim($path, '/');
    }
}
