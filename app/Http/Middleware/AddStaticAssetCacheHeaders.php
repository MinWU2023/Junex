<?php

namespace App\Http\Middleware;

use App\Services\StaticAssetCacheService;
use Closure;
use Illuminate\Http\Request;

/**
 * 当 STATIC_ASSET_CACHE_ENABLED=true 时，为经 PHP 输出的静态资源响应补充缓存头。
 * （Nginx 直接返回的静态文件由伪静态里的标记文件控制，见 deploy/baota-nginx-laravel.conf）
 */
class AddStaticAssetCacheHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            /** @var StaticAssetCacheService $svc */
            $svc = app(StaticAssetCacheService::class);
            if (!$svc->enabled()) {
                return $response;
            }
            if (!$svc->isStaticRequestPath($request->path()) && !$svc->isStaticRequestPath($request->getRequestUri())) {
                return $response;
            }

            $response->headers->set('Cache-Control', $svc->cacheControlHeader());
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $svc->maxAge()) . ' GMT');
            $response->headers->remove('Pragma');
        } catch (\Throwable $e) {
            // 不影响正常页面
        }

        return $response;
    }
}
