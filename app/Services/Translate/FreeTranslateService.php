<?php

namespace App\Services\Translate;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FreeTranslateService
{
    protected static int $lastCallAt = 0;
    protected static int $minGapUs = 1500000; // 1.5s between API calls
    protected static int $cooldownUntil = 0; // unix timestamp when global cooldown ends

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

        $cacheKey = 'tw_tr:' . md5($source . '|' . $target . '|' . $text);
        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $errors = [];
        // Libre 放前：Google/MyMemory 免费通道易 429；Lingva 易 5xx/Cloudflare
        $providers = [
            'libre' => fn () => $this->viaLibre($text, $source, $target),
            'mymemory' => fn () => $this->viaMyMemory($text, $source, $target),
            'google' => fn () => $this->viaGoogle($text, $source, $target),
            'lingva' => fn () => $this->viaLingva($text, $source, $target),
        ];

        foreach ($providers as $name => $provider) {
            for ($attempt = 1; $attempt <= 3; $attempt++) {
                try {
                    $this->throttle();
                    $translated = $provider();
                    if ($this->isValidTranslation($text, $translated, $source, $target)) {
                        Cache::put($cacheKey, $translated, now()->addDays(7));
                        return $translated;
                    }
                    if ($translated !== '') {
                        $errors[] = $name . ' same/invalid text';
                    }
                    break; // no point retrying invalid content
                } catch (\Throwable $e) {
                    $msg = $e->getMessage();
                    $errors[] = $msg;
                    $retryable = $this->isRateLimited($msg) || $this->isServerError($msg);
                    if ($retryable && $attempt < 3) {
                        // 429 / 5xx：指数退避后重试同一通道
                        $wait = (int) pow(2, $attempt); // 2s, 4s
                        self::$cooldownUntil = time() + $wait;
                        usleep($wait * 1000000);
                        continue;
                    }
                    if ($this->isRateLimited($msg)) {
                        // 本通道放弃，冷却后再试下一通道
                        self::$cooldownUntil = time() + 4;
                        self::$minGapUs = min(3500000, self::$minGapUs + 500000);
                    }
                    break;
                }
            }
        }

        Log::warning('FreeTranslateService failed', [
            'source' => $source,
            'target' => $target,
            'errors' => $errors,
            'sample' => mb_substr($text, 0, 80),
        ]);

        throw new \RuntimeException('翻译服务不可用或结果仍为原文：' . implode(' | ', array_slice($errors, 0, 4)));
    }

    protected function isRateLimited(string $message): bool
    {
        return (bool) preg_match('/\b(429|rate limit|too many|quota)\b/i', $message);
    }

    protected function isServerError(string $message): bool
    {
        return (bool) preg_match('/\b(500|502|503|504)\b/', $message);
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
        if (preg_match('/<\s*(!doctype|html|script)/i', $translated)) {
            return false;
        }
        if (mb_strtolower($translated) === mb_strtolower(trim($source))) {
            return mb_strlen(trim($source)) <= 12;
        }

        return true;
    }

    protected function viaGoogle(string $text, string $source, string $target): string
    {
        $response = Http::timeout(30)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
            ->get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => $source,
                'tl' => $target,
                'dt' => 't',
                'q' => $text,
            ]);

        if ($response->status() === 429) {
            throw new \RuntimeException('Google HTTP 429');
        }
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
        if (mb_strlen($text) > 450) {
            return $this->chunkTranslate($text, function (string $chunk) use ($source, $target) {
                return $this->viaMyMemoryChunk($chunk, $source, $target);
            });
        }

        return $this->viaMyMemoryChunk($text, $source, $target);
    }

    protected function viaMyMemoryChunk(string $text, string $source, string $target): string
    {
        $params = [
            'q' => $text,
            'langpair' => $source . '|' . $target,
        ];
        // 带邮箱可大幅提高 MyMemory 日限额（无需注册）
        $email = (string) config('services.translate.mymemory_email', env('TRANSLATE_MYMEMORY_EMAIL', ''));
        if ($email !== '') {
            $params['de'] = $email;
        }

        $response = Http::timeout(30)->get('https://api.mymemory.translated.net/get', $params);
        if ($response->status() === 429) {
            throw new \RuntimeException('MyMemory HTTP 429');
        }
        if (!$response->ok()) {
            throw new \RuntimeException('MyMemory HTTP ' . $response->status());
        }
        $status = (int) ($response->json('responseStatus') ?? 0);
        $translated = (string) ($response->json('responseData.translatedText') ?? '');
        if ($status === 429 || stripos((string) ($response->json('responseDetails') ?? ''), 'LIMIT') !== false) {
            throw new \RuntimeException('MyMemory HTTP 429');
        }
        if ($status !== 200 || $translated === '') {
            throw new \RuntimeException('MyMemory empty: ' . ($response->json('responseDetails') ?? ''));
        }
        if (stripos($translated, 'MYMEMORY WARNING') === 0) {
            throw new \RuntimeException('MyMemory quota warning');
        }

        return $translated;
    }

    protected function viaLibre(string $text, string $source, string $target): string
    {
        $hosts = [
            'https://libretranslate.com',
            'https://translate.argosopentech.com',
            'https://libretranslate.de',
        ];
        $last = 'LibreTranslate unavailable';
        foreach ($hosts as $host) {
            try {
                $this->throttle();
                $response = Http::timeout(30)
                    ->asJson()
                    ->post(rtrim($host, '/') . '/translate', [
                        'q' => $text,
                        'source' => $source,
                        'target' => $target,
                        'format' => 'text',
                    ]);
                if ($response->status() === 429) {
                    $last = 'Libre HTTP 429';
                    continue;
                }
                if (!$response->ok()) {
                    $last = 'Libre HTTP ' . $response->status();
                    continue;
                }
                $translated = trim((string) ($response->json('translatedText') ?? ''));
                if ($translated !== '') {
                    return $translated;
                }
                $last = 'Libre empty';
            } catch (\Throwable $e) {
                $last = $e->getMessage();
            }
        }

        throw new \RuntimeException($last);
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
    protected function chunkTranslate(string $text, callable $translator): string
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
        $now = time();
        if (self::$cooldownUntil > $now) {
            usleep((self::$cooldownUntil - $now) * 1000000);
        }

        $gap = self::$minGapUs;
        $nowUs = (int) (microtime(true) * 1000000);
        $elapsed = $nowUs - self::$lastCallAt;
        if (self::$lastCallAt > 0 && $elapsed < $gap) {
            usleep($gap - $elapsed);
        }
        self::$lastCallAt = (int) (microtime(true) * 1000000);
    }
}
