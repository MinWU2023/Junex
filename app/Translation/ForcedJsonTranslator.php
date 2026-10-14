<?php

namespace App\Translation;

use Illuminate\Translation\Translator;

/**
 * 优先直接读 resources/lang/{locale}.json，绕过 FileLoader / loaded 缓存异常。
 */
class ForcedJsonTranslator extends Translator
{
    /** @var array<string, array<string, string>> */
    protected static array $jsonMap = [];

    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $locale = $locale ?: $this->locale ?: 'en';
        $locale = strtolower((string)$locale);

        if (is_string($key) && $key !== '') {
            $map = $this->jsonFor($locale);
            if (isset($map[$key]) && is_string($map[$key]) && $map[$key] !== '') {
                return $this->makeReplacements($map[$key], $replace);
            }

            // fallback_locale 再试一次
            if ($fallback) {
                $fb = strtolower((string)($this->fallback ?: 'en'));
                if ($fb !== $locale) {
                    $mapFb = $this->jsonFor($fb);
                    if (isset($mapFb[$key]) && is_string($mapFb[$key]) && $mapFb[$key] !== '') {
                        return $this->makeReplacements($mapFb[$key], $replace);
                    }
                }
            }
        }

        return parent::get($key, $replace, $locale, $fallback);
    }

    /**
     * @return array<string, string>
     */
    protected function jsonFor(string $locale): array
    {
        if (isset(static::$jsonMap[$locale])) {
            return static::$jsonMap[$locale];
        }

        $path = resource_path('lang/' . $locale . '.json');
        if (!is_file($path)) {
            return static::$jsonMap[$locale] = [];
        }

        $raw = (string)file_get_contents($path);
        if (strncmp($raw, "\xEF\xBB\xBF", 3) === 0) {
            $raw = substr($raw, 3);
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return static::$jsonMap[$locale] = [];
        }

        $out = [];
        foreach ($decoded as $k => $v) {
            if (is_string($k) && is_string($v)) {
                $out[$k] = $v;
            }
        }

        return static::$jsonMap[$locale] = $out;
    }

    public static function clearCache(): void
    {
        static::$jsonMap = [];
    }
}
