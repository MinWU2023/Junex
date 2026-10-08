<?php

namespace App\Http\Middleware;

use App\Modules\Page\Models\FrontPageControl;
use App\Services\FrontPageCatalogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class FrontPageAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {
            return $next($request);
        }

        $prefix = trim((string)config('app.admin_prefix'), '/');
        $path = $this->normalizeRequestPath($request);

        // 后台不拦截
        if ($prefix !== '' && ($path === $prefix || str_starts_with($path, $prefix . '/'))) {
            return $next($request);
        }

        // 静态资源 / 常见公开文件不拦截
        if ($this->shouldSkip($path)) {
            return $next($request);
        }

        if ($this->isAccessClosed($path)) {
            abort(404);
        }

        return $next($request);
    }

    protected function normalizeRequestPath(Request $request): string
    {
        $path = trim((string)$request->path(), '/');
        // Laravel 首页 path 可能是 "/"，统一成空串
        if ($path === '/' || $path === '.') {
            $path = '';
        }
        return $path;
    }

    protected function shouldSkip(string $path): bool
    {
        if ($path === '') {
            return false; // 首页也要受控
        }

        $skipPrefixes = [
            'storage/', 'front/', 'css/', 'js/', 'ui/', 'vendor/', 'fonts/',
            'build/', 'imgs/', 'images/', 'uploads/',
        ];
        foreach ($skipPrefixes as $prefix) {
            if (str_starts_with($path, rtrim($prefix, '/') . '/') || $path === rtrim($prefix, '/')) {
                return true;
            }
        }

        $skipExact = [
            'favicon.ico', 'robots.txt', 'sitemap.xml',
            'mix-manifest.json', 'web.config',
        ];

        return in_array($path, $skipExact, true);
    }

    protected function isAccessClosed(string $path): bool
    {
        $closed = $this->loadClosedPaths();
        if ($closed === []) {
            return false;
        }

        // 精确匹配
        if (in_array($path, $closed, true)) {
            return true;
        }

        // 兼容库里误存成 "/about-us" 的情况
        if (in_array('/' . ltrim($path, '/'), $closed, true)) {
            return true;
        }

        return false;
    }

    /**
     * @return string[]
     */
    protected function loadClosedPaths(): array
    {
        try {
            return app(FrontPageCatalogService::class)->closedPaths();
        } catch (\Throwable $e) {
            Log::warning('FrontPageAccessMiddleware closedPaths failed, fallback DB', [
                'message' => $e->getMessage(),
            ]);
        }

        try {
            if (!Schema::hasTable('front_page_controls')) {
                return [];
            }
            return FrontPageControl::query()
                ->where('access_on', 0)
                ->pluck('path')
                ->map(function ($path) {
                    return trim((string)$path, '/');
                })
                ->all();
        } catch (\Throwable $e) {
            Log::error('FrontPageAccessMiddleware DB fallback failed', [
                'message' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
