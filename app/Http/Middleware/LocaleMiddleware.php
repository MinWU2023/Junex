<?php

namespace App\Http\Middleware;

use App\Modules\Setting\Models\Locale;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /** @var array<string, string> 子域/后台全称 → resources/lang/{code}.json */
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
        'jp' => 'ja',
    ];

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = strtolower((string)$request->getHost());
        $localeCode = $this->normalizeLocaleCode($this->resolveLocaleCode($host));

        // 同时写入 Application + Translator，避免仅改 config 时 __() 仍用旧 locale
        App::setLocale($localeCode);
        if (app()->bound('translator')) {
            app('translator')->setLocale($localeCode);
        }
        config([
            'app.locale' => $localeCode,
            'translatable.locale' => $localeCode,
        ]);

        // 强制注入 resources/lang/{locale}.json（规避 Loader 路径不一致导致线上 __() 仍回原文）
        try {
            app(\App\Services\JsonLocaleLoader::class)->load($localeCode);
        } catch (\Throwable $e) {
            // 不阻断请求
        }

        try {
            Carbon::setLocale($localeCode);
        } catch (\Throwable $e) {
            // ignore unsupported carbon locale
        }

        $request->attributes->set('front_locale', $localeCode);

        return $next($request);
    }

    /**
     * 按域名解析语种：精确匹配 → 去 www 匹配 → 子域启发式。
     */
    protected function resolveLocaleCode(string $host): string
    {
        if ($host === '') {
            return (string)config('app.fallback_locale', 'en');
        }

        $candidates = array_values(array_unique(array_filter([
            $host,
            preg_replace('/^www\./', '', $host) ?: '',
            'www.' . preg_replace('/^www\./', '', $host),
        ])));

        try {
            $locales = Locale::query()->get(['url', 'language_code']);
        } catch (\Throwable $e) {
            $locales = collect();
        }

        foreach ($locales as $row) {
            $normalized = $this->normalizeHost((string)$row->url);
            if ($normalized === '' || !(string)$row->language_code) {
                continue;
            }
            $rowHosts = array_values(array_unique(array_filter([
                $normalized,
                preg_replace('/^www\./', '', $normalized) ?: '',
                'www.' . preg_replace('/^www\./', '', $normalized),
            ])));
            foreach ($candidates as $candidate) {
                if (in_array($candidate, $rowHosts, true)) {
                    return (string)$row->language_code;
                }
            }
        }

        // 子域启发式（先去掉 www）：es.x.com / www.es.x.com / spanish.x.com
        $hostNoWww = preg_replace('/^www\./', '', $host) ?: $host;
        $sub = strtolower((string)(explode('.', $hostNoWww)[0] ?? ''));
        if ($sub !== '' && $sub !== 'www') {
            // 后台 language_code 与子域一致时优先（即使 url 配错）
            foreach ($locales as $row) {
                if (strtolower((string)$row->language_code) === $sub && (string)$row->language_code !== '') {
                    return (string)$row->language_code;
                }
            }
            $guess = $this->normalizeLocaleCode($sub);
            if ($this->langFileExists($guess)) {
                return $guess;
            }
        }

        return (string)config('app.fallback_locale', config('app.locale', 'en'));
    }

    /**
     * 映射到真实存在的 json 语言包短码。
     */
    protected function normalizeLocaleCode(string $code): string
    {
        $code = strtolower(trim(str_replace('_', '-', $code)));
        if ($code === '') {
            return 'en';
        }

        if (isset($this->localeAliases[$code])) {
            $code = $this->localeAliases[$code];
        }

        if ($this->langFileExists($code)) {
            return $code;
        }

        if (str_contains($code, '-')) {
            $short = explode('-', $code)[0];
            if ($this->langFileExists($short)) {
                return $short;
            }
        }

        return $code;
    }

    protected function langFileExists(string $code): bool
    {
        return $code !== '' && is_file(resource_path('lang/' . $code . '.json'));
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
        $url = explode(':', $url, 2)[0]; // 去掉端口
        $url = rtrim($url, '.');

        return $url;
    }
}
