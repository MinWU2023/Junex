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
            $source[$field] = is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $source;
    }

    public function getLocaleTranslation(Model $model, string $locale, array $fields): array
    {
        $result = [];
        $translation = $model->translate($locale, false);
        foreach ($fields as $field) {
            $value = $translation ? ($translation->{$field} ?? '') : '';
            $result[$field] = is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $result;
    }

    /**
     * @param array<string, string> $fieldValues
     */
    public function saveTranslation(Model $model, string $locale, array $fieldValues): void
    {
        if ($locale === 'en') {
            throw new \InvalidArgumentException('Target locale cannot be English.');
        }
        foreach ($fieldValues as $field => $value) {
            if (!in_array($field, $model->translatedAttributes ?? [], true)) {
                continue;
            }
            $model->translateOrNew($locale)->{$field} = $value;
        }
        $model->save();
    }
}
