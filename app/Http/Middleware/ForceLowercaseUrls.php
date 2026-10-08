<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceLowercaseUrls
{
    /**
     * 需要强制转换小写的路由路径
     */
    private array $lowercaseRoutes = [
        'products',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $forceLowercaseUrls = config('app.forceLowercaseUrls');
        $forceLowercaseUrls = explode(',', $forceLowercaseUrls);
        // 合并
        $forceLowercaseRoutes = array_merge($this->lowercaseRoutes, $forceLowercaseUrls);
        // 只对指定的路由进行小写转换
        if (in_array(strtolower($path), $forceLowercaseRoutes, true) && $path !== strtolower($path)) {
            return redirect(strtolower($path), 301);
        }

        return $next($request);
    }
}
