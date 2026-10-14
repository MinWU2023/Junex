<?php

namespace App\Http\Controllers;

use App\Services\FrontJsI18nService;
use App\Services\JsonLocaleLoader;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class FrontLangController extends Controller
{
    /**
     * 浏览器可直接打开排查线上 json 是否生效。
     * 例：/lang_check?locale=es
     */
    public function diagnose(Request $request, JsonLocaleLoader $loader)
    {
        $locale = strtolower(trim((string)$request->query('locale', app()->getLocale() ?: 'es')));
        $path = resource_path('lang/' . $locale . '.json');
        $exists = is_file($path);
        $decoded = null;
        $jsonError = null;
        $rawPreview = null;
        if ($exists) {
            $raw = (string)file_get_contents($path);
            if (strncmp($raw, "\xEF\xBB\xBF", 3) === 0) {
                $raw = substr($raw, 3);
                $rawPreview = 'HAS_BOM';
            }
            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) {
                $jsonError = json_last_error_msg();
            }
        }

        App::setLocale($locale);
        if (app()->bound('translator')) {
            app('translator')->setLocale($locale);
        }

        $keys = ['Share', 'New Blog', 'Home', 'Previous Post', 'LEAVE A MESSAGE', 'Product Tags', 'Categories'];

        // 注入前
        $before = [];
        foreach ($keys as $key) {
            $val = __($key);
            $before[$key] = [
                'value' => $val,
                'ok' => $val !== $key,
                'json_value' => is_array($decoded) ? ($decoded[$key] ?? null) : null,
                'in_json' => is_array($decoded) ? array_key_exists($key, $decoded) : false,
            ];
        }

        // 强制注入后再测
        $inject = $loader->load($locale);
        $after = [];
        foreach ($keys as $key) {
            $val = __($key);
            $after[$key] = [
                'value' => $val,
                'ok' => $val !== $key,
            ];
        }

        $loaderPath = null;
        try {
            if (app()->bound('translator') && method_exists(app('translator'), 'getLoader')) {
                $fileLoader = app('translator')->getLoader();
                $ref = new \ReflectionClass($fileLoader);
                if ($ref->hasProperty('path')) {
                    $p = $ref->getProperty('path');
                    $p->setAccessible(true);
                    $loaderPath = $p->getValue($fileLoader);
                }
            }
        } catch (\Throwable $e) {
            $loaderPath = 'err:' . $e->getMessage();
        }

        $fileShare = is_array($decoded) ? ($decoded['Share'] ?? null) : null;
        $afterOk = (bool)($after['Share']['ok'] ?? false);

        if ($afterOk) {
            $hint = 'FORCE_INJECT_OK — 请确保已部署 LocaleMiddleware（含 forceLoad）。清缓存后刷前台。';
        } elseif ($fileShare && $fileShare !== 'Share') {
            $hint = 'FILE_OK_BUT_TRANSLATOR_FAIL — json 文件里已是西语，但 __() 读不到。检查 LocaleMiddleware / JsonLocaleLoader 是否上传。';
        } elseif ($fileShare === 'Share') {
            $hint = 'FILE_HAS_ENGLISH_VALUES — 线上 es.json 的 Share 值仍是英文 Share，请用本地 resources/lang/es.json（Compartir）覆盖上传。';
        } else {
            $hint = 'JSON missing/invalid — upload resources/lang/' . $locale . '.json';
        }

        return response()->json([
            'request_host' => $request->getHost(),
            'app_locale' => app()->getLocale(),
            'translator_class' => app()->bound('translator') ? get_class(app('translator')) : null,
            'translator_locale' => app()->bound('translator') ? app('translator')->getLocale() : null,
            'lang_path' => method_exists(app(), 'langPath') ? app()->langPath() : resource_path('lang'),
            'loader_path' => $loaderPath,
            'json_path' => $path,
            'json_exists' => $exists,
            'json_size' => $exists ? filesize($path) : 0,
            'json_mtime' => $exists ? date('c', filemtime($path)) : null,
            'json_valid' => is_array($decoded),
            'json_error' => $jsonError,
            'json_keys' => is_array($decoded) ? count($decoded) : 0,
            'json_bom' => $rawPreview,
            'file_Share_value' => $fileShare,
            'base_path' => base_path(),
            'inject' => $inject,
            'before_inject' => $before,
            'after_inject' => $after,
            'hint' => $hint,
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Serve front JS locale pack (optional; pages also inline the pack).
     */
    public function script(Request $request, string $locale, FrontJsI18nService $i18n): Response
    {
        $locale = strtolower($locale);
        $allowed = $this->allowedLocales();
        if (!in_array($locale, $allowed, true)) {
            abort(404);
        }

        $pack = $i18n->pack($locale);

        $payload = 'window.FrontI18n&&window.FrontI18n.setLocale('
            . json_encode($pack['locale'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            . ','
            . json_encode($pack['messages'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            . ');';

        return response($payload, 200, [
            'Content-Type' => 'application/javascript; charset=utf-8',
            'Cache-Control' => 'public, max-age=300',
        ]);
    }

    /** @return list<string> */
    protected function allowedLocales(): array
    {
        $fromDb = [];
        try {
            if (class_exists(\App\Modules\Setting\Models\Locale::class)) {
                $fromDb = \App\Modules\Setting\Models\Locale::query()
                    ->pluck('language_code')
                    ->filter()
                    ->map(fn ($c) => strtolower((string)$c))
                    ->unique()
                    ->values()
                    ->all();
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return array_values(array_unique(array_merge(['en', 'es'], $fromDb)));
    }
}
