<?php

namespace App\Services\Translate;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FreeTranslateService
{
    protected static int $lastCallAt = 0;
    protected static int $minGapUs = 800000; // 有 DeepL 时约 0.8s；无 Key 时会抬高
    protected static int $cooldownUntil = 0;

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

    /** DeepL target codes that differ from short locale */
    protected array $deeplTargetMap = [
        'en' => 'EN-US',
        'pt' => 'PT-BR',
        'zh' => 'ZH',
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

        if (!$this->hasDeeplKey()) {
            // 纯公共免费通道更容易 429，拉大间隔
            self::$minGapUs = max(self::$minGapUs, 2200000);
        }

        $errors = [];
        // DeepL Free / 自建 Libre 优先；公共镜像仅作兜底（易 429/空响应）
        $providers = [];
        if ($this->hasDeeplKey()) {
            $providers['deepl'] = fn () => $this->viaDeepl($text, $source, $target);
        }
        if ($this->libreSelfHostUrl() !== '') {
            $providers['libre_self'] = fn () => $this->viaLibreHost($this->libreSelfHostUrl(), $text, $source, $target);
        }
        $providers['google'] = fn () => $this->viaGoogle($text, $source, $target);
        $providers['mymemory'] = fn () => $this->viaMyMemory($text, $source, $target);
        $providers['libre'] = fn () => $this->viaLibre($text, $source, $target);
        $providers['lingva'] = fn () => $this->viaLingva($text, $source, $target);

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
                    break;
                } catch (\Throwable $e) {
                    $msg = $e->getMessage();
                    $errors[] = $msg;
                    $retryable = $this->isRateLimited($msg) || $this->isServerError($msg);
                    if ($retryable && $attempt < 3) {
                        $wait = (int) pow(2, $attempt); // 2s, 4s
                        self::$cooldownUntil = time() + $wait;
                        usleep($wait * 1000000);
                        continue;
                    }
                    if ($this->isRateLimited($msg)) {
                        self::$cooldownUntil = time() + 5;
                        self::$minGapUs = min(4500000, self::$minGapUs + 600000);
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
            'has_deepl' => $this->hasDeeplKey(),
        ]);

        throw new \RuntimeException('翻译服务不可用或结果仍为原文：' . implode(' | ', array_slice($errors, 0, 4)));
    }

    public function hasDeeplKey(): bool
    {
        return trim((string) config('services.translate.deepl_key', '')) !== '';
    }

    protected function libreSelfHostUrl(): string
    {
        return rtrim(trim((string) config('services.translate.libre_url', '')), '/');
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

    protected function viaDeepl(string $text, string $source, string $target): string
    {
        $key = trim((string) config('services.translate.deepl_key', ''));
        if ($key === '') {
            throw new \RuntimeException('DeepL key missing');
        }

        $api = rtrim((string) config('services.translate.deepl_api', 'https://api-free.deepl.com'), '/');
        $sourceLang = strtoupper($source === 'zh' ? 'ZH' : $source);
        $targetLang = $this->deeplTargetMap[$target] ?? strtoupper($target);

        // DeepL 单次建议控制长度；过长按句切
        if (mb_strlen($text) > 4000) {
            return $this->chunkTranslate($text, function (string $chunk) use ($source, $target) {
                return $this->viaDeepl($chunk, $source, $target);
            }, 3800);
        }

        $response = Http::timeout(45)
            ->withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $key,
            ])
            ->asForm()
            ->post($api . '/v2/translate', [
                'text' => $text,
                'source_lang' => $sourceLang,
                'target_lang' => $targetLang,
            ]);

        if ($response->status() === 429) {
            throw new \RuntimeException('DeepL HTTP 429');
        }
        if ($response->status() === 403 || $response->status() === 401) {
            throw new \RuntimeException('DeepL auth failed HTTP ' . $response->status());
        }
        if (!$response->ok()) {
            throw new \RuntimeException('DeepL HTTP ' . $response->status());
        }

        $translated = trim((string) ($response->json('translations.0.text') ?? ''));
        if ($translated === '') {
            throw new \RuntimeException('DeepL empty');
        }

        return $translated;
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
        $email = (string) config('services.translate.mymemory_email', '');
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
                $translated = $this->viaLibreHost($host, $text, $source, $target);
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

    protected function viaLibreHost(string $host, string $text, string $source, string $target): string
    {
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
            throw new \RuntimeException('Libre HTTP 429');
        }
        if (!$response->ok()) {
            throw new \RuntimeException('Libre HTTP ' . $response->status());
        }
        $translated = trim((string) ($response->json('translatedText') ?? ''));
        if ($translated === '') {
            throw new \RuntimeException('Libre empty');
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
    protected function chunkTranslate(string $text, callable $translator, int $maxLen = 420): string
    {
        $chunks = preg_split('/(?<=[.!?。！？\n])\s+/u', $text) ?: [$text];
        $out = [];
        $buffer = '';
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            if (mb_strlen($buffer) + mb_strlen($chunk) > $maxLen) {
                if ($buffer !== '') {
                    $this->throttle();
                    $out[] = $translator($buffer);
                    $buffer = '';
                }
                if (mb_strlen($chunk) > $maxLen) {
                    foreach (mb_str_split($chunk, $maxLen) as $piece) {
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
