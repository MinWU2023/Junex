<?php

namespace App\Services\Translate;

use Illuminate\Support\Facades\Http;

class FreeTranslateService
{
    public function translate(string $text, string $targetLocale, string $sourceLocale = 'en'): string
    {
        $text = trim($text);
        if ($text === '') {
            return '';
        }
        if ($targetLocale === $sourceLocale) {
            return $text;
        }

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
}
