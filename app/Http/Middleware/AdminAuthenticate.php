<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminAuthenticate
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
        $permission = Route::currentRouteName();
        if (Auth::user()->can($permission)) {
            return $next($request);
        }

        $fallback = $this->fallbackPermission($permission);
        if ($fallback && Auth::user()->can($fallback)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }

    protected function fallbackPermission(?string $permission): ?string
    {
        if (!$permission) {
            return null;
        }

        if (str_starts_with($permission, 'admin.translateWorkbench.')
            && $permission !== 'admin.translateWorkbench.index') {
            return 'admin.translateWorkbench.index';
        }

        if (str_starts_with($permission, 'admin.imageWorkbench.')
            && $permission !== 'admin.imageWorkbench.index') {
            return 'admin.imageWorkbench.index';
        }

        return null;
    }
}
