<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class FrontJsI18nService
{
    /**
     * Build the FrontI18n dictionary for a locale (whitelist from resources/lang/js/keys.php).
     *
     * @return array{locale:string, messages:array<string,string>}
     */
    public function pack(?string $locale = null): array
    {
        $locale = strtolower((string)($locale ?: app()->getLocale() ?: 'en'));
        $path = resource_path('lang/' . $locale . '.json');

        if (!is_file($path)) {
            $fallback = (string)config('app.fallback_locale', 'en');
            $path = resource_path('lang/' . $fallback . '.json');
            $locale = is_file($path) ? $fallback : $locale;
        }

        $all = [];
        if (is_file($path)) {
            $decoded = json_decode((string)File::get($path), true);
            $all = is_array($decoded) ? $decoded : [];
        }

        return [
            'locale' => $locale,
            'messages' => $this->filterMessages($all),
        ];
    }

    /**
     * @param  array<string, mixed>  $all
     * @return array<string, string>
     */
    public function filterMessages(array $all): array
    {
        $keysFile = resource_path('lang/js/keys.php');
        if (!is_file($keysFile)) {
            $out = [];
            foreach ($all as $k => $v) {
                if (is_string($k) && (is_string($v) || is_numeric($v))) {
                    $out[$k] = (string)$v;
                }
            }
            return $out;
        }

        /** @var mixed $keys */
        $keys = require $keysFile;
        if (!is_array($keys)) {
            return [];
        }

        $out = [];
        foreach ($keys as $key) {
            if (!is_string($key) || $key === '') {
                continue;
            }
            $out[$key] = array_key_exists($key, $all) ? (string)$all[$key] : $key;
        }
        return $out;
    }
}
