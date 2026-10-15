<?php

namespace App\Services\Translate;

use Illuminate\Database\Eloquent\Model;

class TranslationPersistenceService
{
    public function getEnglishSource(Model $model, array $fields): array
    {
        $source = [];
        $english = $model->translate('en', false);
        if (!$english) {
            $english = $model->translate(config('app.locale', 'en'), false);
        }
        foreach ($fields as $field) {
            $value = '';
            if ($english && isset($english->{$field})) {
                $value = $english->{$field};
            } elseif (in_array($field, $model->translatedAttributes ?? [], true) === false && isset($model->{$field})) {
                $value = $model->{$field};
            }
            if (($value === null || $value === '') && $english) {
                $value = $english->{$field} ?? '';
            }
            $source[$field] = $this->encodeFieldValue($value);
        }

        return $source;
    }

    public function getLocaleTranslation(Model $model, string $locale, array $fields): array
    {
        $result = [];
        $translation = $model->translate($locale, false);
        foreach ($fields as $field) {
            $value = $translation ? ($translation->{$field} ?? '') : '';
            $result[$field] = $this->encodeFieldValue($value);
        }

        return $result;
    }

    /**
     * @param  array<string, mixed>  $fieldValues
     * @param  array<string, string>  $fieldTypes  field => type (list/text/...)
     */
    public function saveTranslation(Model $model, string $locale, array $fieldValues, array $fieldTypes = []): void
    {
        if ($locale === 'en') {
            throw new \InvalidArgumentException('Target locale cannot be English.');
        }
        $this->saveLocaleFields($model, $locale, $fieldValues, $fieldTypes);
    }

    /**
     * 写入任意语言翻译字段（含 en），供图片工作台等跨语言修复场景使用。
     *
     * @param  array<string, mixed>  $fieldValues
     * @param  array<string, string>  $fieldTypes
     */
    public function saveLocaleFields(Model $model, string $locale, array $fieldValues, array $fieldTypes = []): void
    {
        $locale = trim($locale);
        if ($locale === '') {
            throw new \InvalidArgumentException('Locale is required.');
        }
        foreach ($fieldValues as $field => $value) {
            if (!in_array($field, $model->translatedAttributes ?? [], true)) {
                continue;
            }
            $type = strtolower((string) ($fieldTypes[$field] ?? ''));
            $model->translateOrNew($locale)->{$field} = $this->decodeFieldValue($value, $type, $field);
        }
        $model->save();
    }

    /**
     * Normalize list/features payloads to [{text: "..."}].
     *
     * @param  mixed  $value
     * @return array<int, array{text: string}>
     */
    public function normalizeFeatureList($value): array
    {
        $value = $this->maybeJsonDecode($value);
        if (!is_array($value)) {
            $text = trim((string)$value);
            return $text !== '' ? [['text' => $text]] : [];
        }

        $out = [];
        foreach ($value as $item) {
            if (is_array($item)) {
                $text = trim((string)($item['text'] ?? $item['title'] ?? $item['label'] ?? ''));
                if ($text === '' && count($item) === 1) {
                    $text = trim((string)reset($item));
                }
            } else {
                $text = trim((string)$item);
            }
            if ($text === '') {
                continue;
            }
            $out[] = ['text' => $text];
        }

        return $out;
    }

    protected function encodeFieldValue($value): string
    {
        if (is_array($value)) {
            return (string)json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        if ($value === null) {
            return '';
        }

        return (string)$value;
    }

    /**
     * @param  mixed  $value
     * @return mixed
     */
    protected function decodeFieldValue($value, string $type, string $field)
    {
        $isList = $type === 'list'
            || $field === 'features'
            || (is_string($value) && $this->looksLikeJsonArray((string)$value));

        if ($isList) {
            return $this->normalizeFeatureList($value);
        }

        // 防御：array cast 字段若仍收到 JSON 字符串，先解成数组再写，避免双重编码
        if (is_string($value)) {
            $decoded = $this->maybeJsonDecode($value);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return is_scalar($value) || $value === null ? $value : json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param  mixed  $value
     * @return mixed
     */
    protected function maybeJsonDecode($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        $trim = trim($value);
        if ($trim === '' || ($trim[0] !== '[' && $trim[0] !== '{' && $trim[0] !== '"')) {
            return $value;
        }

        $decoded = json_decode($trim, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $value;
        }

        // 双重编码：json_encode(json_string) → "\"[...]\""
        if (is_string($decoded)) {
            $inner = json_decode($decoded, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $inner;
            }
        }

        return $decoded;
    }

    protected function looksLikeJsonArray(string $value): bool
    {
        $trim = ltrim($value);

        return $trim !== '' && ($trim[0] === '[' || $trim[0] === '{');
    }
}
