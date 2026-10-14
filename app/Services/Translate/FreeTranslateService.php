<?php

namespace App\Services\Translate;

use Illuminate\Support\Facades\Http;

class FreeTranslateService
{
    protected static int $lastCallAt = 0;

    public function translate(string $text, string $targetLocale, string $sourceLocale = 'en'): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }
        if ($targetLocale === $sourceLocale) {
            return $text;
        }

        $this->throttle();

        try {
            $lingva = Http::timeout(20)->get(sprintf(
                'https://lingva.ml/api/v1/%s/%s/%s',
                rawurlencode($sourceLocale),
                rawurlencode($targetLocale),
                rawurlencode($text)
            ));
            if ($lingva->ok()) {
                $translation = (string) ($lingva->json('translation') ?? '');
                if ($translation !== '') {
                    return $translation;
                }
            }
        } catch (\Throwable $e) {
            // fallback below
        }

        $memory = Http::timeout(20)->get('https://api.mymemory.translated.net/get', [
            'q' => $text,
            'langpair' => $sourceLocale . '|' . $targetLocale,
        ]);
        if ($memory->ok()) {
            $translation = (string) ($memory->json('responseData.translatedText') ?? '');
            if ($translation !== '') {
                return $translation;
            }
        }

        throw new \RuntimeException('Translation service unavailable');
    }

    protected function throttle(): void
    {
        $gap = 400000; // 400ms between API calls
        $now = (int) (microtime(true) * 1000000);
        $elapsed = $now - self::$lastCallAt;
        if (self::$lastCallAt > 0 && $elapsed < $gap) {
            usleep($gap - $elapsed);
        }
        self::$lastCallAt = (int) (microtime(true) * 1000000);
    }
}
