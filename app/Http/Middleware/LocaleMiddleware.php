<?php

namespace App\Http\Middleware;

use App\Modules\Setting\Models\Locale;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /** @var array<string, string> 仅当 language_code 无对应 json 时才映射（不改已有 es/de 等短码） */
    protected array $localeAliases = [
        'spanish' => 'es',
        'german' => 'de',
        'japanese' => 'ja',
        'japan' => 'ja',
        'portuguese' => 'pt',
        'russian' => 'ru',
        'italian' => 'it',
        'french' => 'fr',
        'chinese' => 'zh',
        'english' => 'en',
    ];

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
        $localeCode = $this->normalizeLocaleCode($this->resolveLocaleCode($host));

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

        // 子域启发式：es.example.com → es（库未配 url 时仍能加载语言包）
        $sub = explode('.', $host)[0] ?? '';
        if ($sub !== '' && $sub !== 'www' && strlen($sub) <= 5) {
            $guess = $this->normalizeLocaleCode($sub);
            if (is_file(resource_path('lang/' . $guess . '.json'))) {
                return $guess;
            }
        }

        return (string)config('app.fallback_locale', config('app.locale', 'en'));
    }

    /**
     * 保证能命中 resources/lang/{locale}.json；有短码文件则优先短码。
     */
    protected function normalizeLocaleCode(string $code): string
    {
        $code = strtolower(trim(str_replace('_', '-', $code)));
        if ($code === '') {
            return 'en';
        }

        if (is_file(resource_path('lang/' . $code . '.json'))) {
            return $code;
        }

        if (isset($this->localeAliases[$code])) {
            $aliased = $this->localeAliases[$code];
            if (is_file(resource_path('lang/' . $aliased . '.json'))) {
                return $aliased;
            }
        }

        if (str_contains($code, '-')) {
            $short = explode('-', $code)[0];
            if (is_file(resource_path('lang/' . $short . '.json'))) {
                return $short;
            }
        }

        return $code;
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
