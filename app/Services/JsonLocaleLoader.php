<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use ReflectionClass;

/**
 * 强制把 resources/lang/{locale}.json 写入 Translator，
 * 避免 FileLoader 路径异常导致线上 __() 读不到词条。
 */
class JsonLocaleLoader
{
    public function load(string $locale): array
    {
        $locale = strtolower(trim($locale));
        if ($locale === '') {
            return [
                'ok' => false,
                'reason' => 'empty_locale',
                'path' => null,
                'keys' => 0,
                'share_in_file' => null,
            ];
        }

        $path = resource_path('lang/' . $locale . '.json');
        if (!is_file($path)) {
            return [
                'ok' => false,
                'reason' => 'file_missing',
                'path' => $path,
                'keys' => 0,
                'share_in_file' => null,
            ];
        }

        $raw = (string)file_get_contents($path);
        // 去掉 UTF-8 BOM，避免首 key 异常
        if (strncmp($raw, "\xEF\xBB\xBF", 3) === 0) {
            $raw = substr($raw, 3);
        }

        $lines = json_decode($raw, true);
        if (!is_array($lines) || $lines === []) {
            return [
                'ok' => false,
                'reason' => 'json_invalid:' . json_last_error_msg(),
                'path' => $path,
                'keys' => 0,
                'share_in_file' => null,
            ];
        }

        App::setLocale($locale);
        if (!app()->bound('translator')) {
            return [
                'ok' => false,
                'reason' => 'no_translator',
                'path' => $path,
                'keys' => count($lines),
                'share_in_file' => $lines['Share'] ?? null,
            ];
        }

        $translator = app('translator');
        $translator->setLocale($locale);

        try {
            $ref = new ReflectionClass($translator);
            $prop = $ref->getProperty('loaded');
            $prop->setAccessible(true);
            $loaded = $prop->getValue($translator);
            if (!is_array($loaded)) {
                $loaded = [];
            }
            $loaded['*']['*'][$locale] = $lines;
            $prop->setValue($translator, $loaded);
        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'reason' => 'reflect_fail:' . $e->getMessage(),
                'path' => $path,
                'keys' => count($lines),
                'share_in_file' => $lines['Share'] ?? null,
            ];
        }

        if (method_exists($translator, 'getLoader')) {
            $loader = $translator->getLoader();
            if (is_object($loader) && method_exists($loader, 'addJsonPath')) {
                $loader->addJsonPath(resource_path('lang'));
            }
        }

        return [
            'ok' => true,
            'reason' => null,
            'path' => $path,
            'keys' => count($lines),
            'share_in_file' => $lines['Share'] ?? null,
            'after_share' => __('Share'),
        ];
    }
}
