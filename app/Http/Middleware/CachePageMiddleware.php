<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CachePageMiddleware
{
    /**
     * 整页缓存必须带 locale，否则语种切换后会一直吐出首次缓存的英文 HTML。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 后台登录用户 / 显式刷新：不走整页缓存
        if ($request->boolean('nocache') || $request->boolean('refresh') || auth()->check()) {
            return $next($request);
        }

        $locale = strtolower((string)(app()->getLocale() ?: 'en'));
        $key = 'page_cache:' . $locale . ':' . md5($request->fullUrl());

        if (Cache::has($key)) {
            return response(Cache::get($key));
        }

        $response = $next($request);

        // 仅缓存成功的 HTML 页
        if ($response->getStatusCode() === 200 && strlen((string)$response->getContent()) > 100) {
            $contentType = (string)$response->headers->get('Content-Type', '');
            if ($contentType === '' || str_contains($contentType, 'text/html')) {
                Cache::put($key, $response->getContent(), 3600 * 24);
            }
        }

        return $response;
    }
}
