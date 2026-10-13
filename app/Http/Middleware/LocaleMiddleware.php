<?php

namespace App\Http\Middleware;

use App\Modules\Setting\Models\Locale;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
        $host = strtolower((string)$request->getHost());
        $localeCode = $this->resolveLocaleCode($host);

        App::setLocale($localeCode);
        config([
            'app.locale' => $localeCode,
            'translatable.locale' => $localeCode,
        ]);

        try {
            Carbon::setLocale($localeCode);
        } catch (\Throwable $e) {
            // ignore unsupported carbon locale
        }

        return $next($request);
    }

    /**
     * Match request host against locales.url (host only, ignore scheme/path/case).
     */
    protected function resolveLocaleCode(string $host): string
    {
        if ($host === '') {
            return (string)config('app.locale', 'en');
        }

        $exact = Locale::query()->where('url', $host)->first();
        if ($exact && $exact->language_code) {
            return (string)$exact->language_code;
        }

        $locales = Locale::query()->get(['url', 'language_code']);
        foreach ($locales as $row) {
            $normalized = $this->normalizeHost((string)$row->url);
            if ($normalized !== '' && $normalized === $host && $row->language_code) {
                return (string)$row->language_code;
            }
        }

        return (string)config('app.fallback_locale', config('app.locale', 'en'));
    }

    protected function normalizeHost(string $url): string
    {
        $url = strtolower(trim($url));
        if ($url === '') {
            return '';
        }

        $url = preg_replace('#^https?://#i', '', $url) ?? $url;
        $url = explode('/', $url, 2)[0];
        $url = explode('?', $url, 2)[0];
        $url = rtrim($url, '.');

        return $url;
    }
}
