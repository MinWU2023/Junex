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

        throw UnauthorizedException::forPermissions([$permission]);
    }
}
