<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CachePageMiddleware
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
        $key = $request->fullUrl();
        if (Cache::has($key)) {
            return response(Cache::get($key));
        }
        $response = $next($request);
        $cachingTime = 3600 * 24;
        if (strlen($response->getContent()) > 100){
            Cache::put($key,$response->getContent(),$cachingTime);
        }
        return $response;
    }
}
