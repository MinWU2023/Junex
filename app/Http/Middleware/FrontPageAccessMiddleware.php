<?php

namespace App\Http\Middleware;

use App\Services\FrontPageCatalogService;
use Closure;
use Illuminate\Http\Request;

class FrontPageAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {
            return $next($request);
        }

        $prefix = trim((string)config('app.admin_prefix'), '/');
        $path = trim($request->path(), '/');
        if ($prefix !== '' && ($path === $prefix || str_starts_with($path, $prefix . '/'))) {
            return $next($request);
        }

        try {
            $closed = app(FrontPageCatalogService::class)->closedPaths();
        } catch (\Throwable $e) {
            return $next($request);
        }

        if (in_array($path, $closed, true)) {
            abort(404);
        }

        return $next($request);
    }
}
