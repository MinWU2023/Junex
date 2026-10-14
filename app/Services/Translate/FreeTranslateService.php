<?php

namespace App\Services\Translate;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FreeTranslateService
{
    protected static int $lastCallAt = 0;

    /** @var array<string, string> */
    protected array $localeMap = [
        'spanish' => 'es',
        'german' => 'de',
        'japanese' => 'ja',
        'japan' => 'ja',
        'portuguese' => 'pt',
        'russian' => 'ru',
        'italian' => 'it',
        'french' => 'fr',
        'chinese' => 'zh',
        'zh-cn' => 'zh',
        'zh_cn' => 'zh',
        'en-us' => 'en',
        'en_us' => 'en',
        'es-es' => 'es',
        'pt-br' => 'pt',
        'pt_br' => 'pt',
    ];

    public function translate(string $text, string $targetLocale, string $sourceLocale = 'en'): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }

        $source = $this->normalizeLocale($sourceLocale);
        $target = $this->normalizeLocale($targetLocale);
        if ($target === '' || $target === $source) {
            return $text;
        }

        $errors = [];
        foreach ([
            fn () => $this->viaMyMemory($text, $source, $target),
            fn () => $this->viaGoogle($text, $source, $target),
            fn () => $this->viaLingva($text, $source, $target),
        ] as $provider) {
            try {
                $this->throttle();
                $translated = $provider();
                if ($this->isValidTranslation($text, $translated, $source, $target)) {
                    return $translated;
                }
                if ($translated !== '') {
                    $errors[] = 'provider returned same/invalid text';
                }
            } catch (\Throwable $e) {
                $errors[] = $e->getMessage();
            }
        }

        Log::warning('FreeTranslateService failed', [
            'source' => $source,
            'target' => $target,
            'errors' => $errors,
            'sample' => mb_substr($text, 0, 80),
        ]);

        throw new \RuntimeException('翻译服务不可用或结果仍为原文：' . implode(' | ', array_slice($errors, 0, 3)));
    }

    protected function normalizeLocale(string $locale): string
    {
        $locale = strtolower(trim(str_replace('_', '-', $locale)));
        if ($locale === '') {
            return '';
        }
        if (isset($this->localeMap[$locale])) {
            return $this->localeMap[$locale];
        }
        // es-ES -> es
        if (str_contains($locale, '-')) {
            $locale = explode('-', $locale)[0];
        }

        return $locale;
    }

    protected function isValidTranslation(string $source, string $translated, string $sourceLocale, string $targetLocale): bool
    {
        $translated = trim($translated);
        if ($translated === '') {
            return false;
        }
        // Cloudflare / HTML error pages
        if (preg_match('/<\s*(!doctype|html|script)/i', $translated)) {
            return false;
        }
        // Brand-only / short identical text may stay same; for longer text same language is failure
        if (mb_strtolower($translated) === mb_strtolower(trim($source))) {
            // Allow short proper nouns (e.g. brand names) only when very short
            return mb_strlen(trim($source)) <= 12;
        }

        return true;
    }

    protected function viaGoogle(string $text, string $source, string $target): string
    {
        $response = Http::timeout(25)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
            ->get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => $source,
                'tl' => $target,
                'dt' => 't',
                'q' => $text,
            ]);

        if (!$response->ok()) {
            throw new \RuntimeException('Google HTTP ' . $response->status());
        }

        $json = $response->json();
        if (!is_array($json) || empty($json[0]) || !is_array($json[0])) {
            throw new \RuntimeException('Google empty response');
        }

        $parts = [];
        foreach ($json[0] as $chunk) {
            if (is_array($chunk) && isset($chunk[0]) && is_string($chunk[0])) {
                $parts[] = $chunk[0];
            }
        }
        $translated = trim(implode('', $parts));
        if ($translated === '') {
            throw new \RuntimeException('Google empty translation');
        }

        return $translated;
    }

    protected function viaMyMemory(string $text, string $source, string $target): string
    {
        // MyMemory has 500 char soft limit per request
        if (mb_strlen($text) > 450) {
            return $this->chunkTranslate($text, $source, $target, function (string $chunk) use ($source, $target) {
                return $this->viaMyMemoryChunk($chunk, $source, $target);
            });
        }

        return $this->viaMyMemoryChunk($text, $source, $target);
    }

    protected function viaMyMemoryChunk(string $text, string $source, string $target): string
    {
        $response = Http::timeout(25)->get('https://api.mymemory.translated.net/get', [
            'q' => $text,
            'langpair' => $source . '|' . $target,
        ]);
        if (!$response->ok()) {
            throw new \RuntimeException('MyMemory HTTP ' . $response->status());
        }
        $status = (int) ($response->json('responseStatus') ?? 0);
        $translated = (string) ($response->json('responseData.translatedText') ?? '');
        if ($status !== 200 || $translated === '') {
            throw new \RuntimeException('MyMemory empty: ' . ($response->json('responseDetails') ?? ''));
        }
        // MyMemory sometimes returns "MYMEMORY WARNING:..." prefix
        if (stripos($translated, 'MYMEMORY WARNING') === 0) {
            throw new \RuntimeException('MyMemory quota warning');
        }

        return $translated;
    }

    protected function viaLingva(string $text, string $source, string $target): string
    {
        $hosts = [
            'https://lingva.garudalinux.org',
            'https://translate.plausibility.cloud',
        ];
        $lastError = 'Lingva unavailable';
        foreach ($hosts as $host) {
            try {
                $url = sprintf(
                    '%s/api/v1/%s/%s/%s',
                    rtrim($host, '/'),
                    rawurlencode($source),
                    rawurlencode($target),
                    rawurlencode($text)
                );
                $response = Http::timeout(20)
                    ->withHeaders(['Accept' => 'application/json'])
                    ->get($url);
                if (!$response->ok()) {
                    $lastError = 'Lingva HTTP ' . $response->status();
                    continue;
                }
                $body = $response->body();
                if (stripos($body, '<html') !== false || stripos($body, 'Just a moment') !== false) {
                    $lastError = 'Lingva blocked by Cloudflare';
                    continue;
                }
                $translated = (string) ($response->json('translation') ?? '');
                if ($translated !== '') {
                    return $translated;
                }
                $lastError = 'Lingva empty';
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
            }
        }

        throw new \RuntimeException($lastError);
    }

    /**
     * @param callable(string):string $translator
     */
    protected function chunkTranslate(string $text, string $source, string $target, callable $translator): string
    {
        $chunks = preg_split('/(?<=[.!?。！？\n])\s+/u', $text) ?: [$text];
        $out = [];
        $buffer = '';
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            if (mb_strlen($buffer) + mb_strlen($chunk) > 420) {
                if ($buffer !== '') {
                    $this->throttle();
                    $out[] = $translator($buffer);
                    $buffer = '';
                }
                if (mb_strlen($chunk) > 420) {
                    foreach (mb_str_split($chunk, 420) as $piece) {
                        $this->throttle();
                        $out[] = $translator($piece);
                    }
                    continue;
                }
            }
            $buffer = $buffer === '' ? $chunk : ($buffer . ' ' . $chunk);
        }
        if ($buffer !== '') {
            $this->throttle();
            $out[] = $translator($buffer);
        }

        return trim(implode(' ', $out));
    }

    protected function throttle(): void
    {
        $gap = 350000; // 350ms
        $now = (int) (microtime(true) * 1000000);
        $elapsed = $now - self::$lastCallAt;
        if (self::$lastCallAt > 0 && $elapsed < $gap) {
            usleep($gap - $elapsed);
        }
        self::$lastCallAt = (int) (microtime(true) * 1000000);
    }
}
