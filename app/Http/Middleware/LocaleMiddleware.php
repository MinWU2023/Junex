<?php

namespace App\Http\Middleware;

use App\Modules\Setting\Models\Locale;
use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
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
        $host = $request->getHost();

        $locale = Locale::where('url', $host)->first();

        if ($locale) {
            app()->setLocale($locale->language_code);
        } else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
