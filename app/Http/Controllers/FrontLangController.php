<?php

namespace App\Http\Controllers;

use App\Services\FrontJsI18nService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class FrontLangController extends Controller
{
    /**
     * 浏览器可直接打开排查线上 json 是否生效（非静态缓存问题）。
     * 例：/__lang_check?locale=es
     */
    public function diagnose(Request $request)
    {
        $locale = strtolower(trim((string)$request->query('locale', app()->getLocale() ?: 'es')));
        $path = resource_path('lang/' . $locale . '.json');
        $exists = is_file($path);
        $decoded = null;
        $jsonError = null;
        if ($exists) {
            $raw = (string)file_get_contents($path);
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
        $samples = [];
        foreach ($keys as $key) {
            $val = __($key);
            $samples[$key] = [
                'value' => $val,
                'ok' => $val !== $key,
                'in_json' => is_array($decoded) ? array_key_exists($key, $decoded) : false,
            ];
        }

        return response()->json([
            'request_host' => $request->getHost(),
            'app_locale' => app()->getLocale(),
            'lang_path' => method_exists(app(), 'langPath') ? app()->langPath() : resource_path('lang'),
            'json_path' => $path,
            'json_exists' => $exists,
            'json_size' => $exists ? filesize($path) : 0,
            'json_mtime' => $exists ? date('c', filemtime($path)) : null,
            'json_valid' => is_array($decoded),
            'json_error' => $jsonError,
            'json_keys' => is_array($decoded) ? count($decoded) : 0,
            'base_path' => base_path(),
            'samples' => $samples,
            'hint' => (is_array($decoded) && ($samples['Share']['ok'] ?? false))
                ? 'JSON OK — if page still English, clear page cache: php artisan cache:clear && view:clear'
                : 'JSON missing/invalid/outdated — upload resources/lang/' . $locale . '.json to json_path above (expect ~30KB, ~470 keys)',
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Serve front JS locale pack (optional; pages also inline the pack).
     * Prefer route without a real public/*.js path so nginx does not 404 static files.
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
            'Content-Type' => 'application/javascript; charset=UTF-8',
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
            // ignore during early boot / missing table
        }

        $defaults = ['en', 'es'];
        return array_values(array_unique(array_merge($defaults, $fromDb)));
    }
}
