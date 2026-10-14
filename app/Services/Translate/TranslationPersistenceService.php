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
            $value = $english ? ($english->{$field} ?? '') : '';
            $source[$field] = is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $source;
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
