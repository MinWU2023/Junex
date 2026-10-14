<?php

namespace App\Http\Controllers;

use App\Services\FrontJsI18nService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FrontLangController extends Controller
{
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
