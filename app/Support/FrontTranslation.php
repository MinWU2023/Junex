<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

/**
 * 前台多语言：当前 locale 优先，字段为空时回退英语。
 * 仅用于前台渲染/查询；后台编辑勿用（需看到空字段以便填写）。
 */
class FrontTranslation
{
    public static function locale(): string
    {
        $locale = strtolower(trim((string)(config('translatable.locale') ?: app()->getLocale() ?: 'en')));

        return $locale !== '' ? $locale : 'en';
    }

    public static function fallbackLocale(): string
    {
        $fallback = strtolower(trim((string)(
            config('translatable.fallback_locale')
            ?: config('app.fallback_locale', 'en')
        )));

        return $fallback !== '' ? $fallback : 'en';
    }

    /**
     * 读取可翻译字段：当前语言非空优先，否则英语，再不济用模型访问器。
     */
    public static function attr($model, string $attribute, ?string $locale = null): string
    {
        if (!is_object($model)) {
            return '';
        }

        try {
            $locale = strtolower(trim((string)($locale ?: self::locale())));
            $fallback = self::fallbackLocale();

            if (method_exists($model, 'translate') || method_exists($model, 'getTranslation')) {
                $value = self::rawAttr($model, $attribute, $locale);
                if ($value !== '') {
                    return $value;
                }

                if ($fallback !== '' && $fallback !== $locale) {
                    $value = self::rawAttr($model, $attribute, $fallback);
                    if ($value !== '') {
                        return $value;
                    }
                }

                // 最后走 Astrotomic 访问器（含全局 property fallback）
                if (method_exists($model, 'isTranslationAttribute')
                    && $model->isTranslationAttribute($attribute)
                ) {
                    return self::normalize($model->{$attribute} ?? null);
                }
            }

            return self::normalize($model->{$attribute} ?? null);
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * 批量读取多个翻译字段（当前语言→英语）。
     *
     * @param  array<int, string>  $attributes
     * @return array<string, string>
     */
    public static function attrs($model, array $attributes, ?string $locale = null): array
    {
        $out = [];
        foreach ($attributes as $attribute) {
            $attribute = (string)$attribute;
            if ($attribute === '') {
                continue;
            }
            $out[$attribute] = self::attr($model, $attribute, $locale);
        }

        return $out;
    }

    /**
     * 在查询上匹配「当前语言 或 英语」的翻译字段（LIKE）。
     *
     * @param  Builder  $query
     * @param  array<int, string>  $fields
     */
    public static function whereLikeAnyLocale(Builder $query, array $fields, string $like): Builder
    {
        $locale = self::locale();
        $fallback = self::fallbackLocale();
        $fields = array_values(array_filter(array_map('strval', $fields)));

        if ($fields === [] || $like === '') {
            return $query;
        }

        return $query->where(function (Builder $outer) use ($fields, $like, $locale, $fallback) {
            $outer->where(function (Builder $q) use ($fields, $like, $locale) {
                foreach ($fields as $i => $field) {
                    $method = $i === 0 ? 'whereTranslationLike' : 'orWhereTranslationLike';
                    $q->{$method}($field, $like, $locale);
                }
            });

            if ($fallback !== '' && $fallback !== $locale) {
                $outer->orWhere(function (Builder $q) use ($fields, $like, $fallback) {
                    foreach ($fields as $i => $field) {
                        $method = $i === 0 ? 'whereTranslationLike' : 'orWhereTranslationLike';
                        $q->{$method}($field, $like, $fallback);
                    }
                });
            }
        });
    }

    protected static function rawAttr($model, string $attribute, string $locale): string
    {
        $row = null;
        if (method_exists($model, 'getTranslation')) {
            $row = $model->getTranslation($locale, false);
        } elseif (method_exists($model, 'translate')) {
            $row = $model->translate($locale, false);
        }

        if (!$row) {
            return '';
        }

        return self::normalize($row->{$attribute} ?? null);
    }

    protected static function normalize($value): string
    {
        if ($value === null) {
            return '';
        }
        if (is_array($value) || is_object($value)) {
            return '';
        }

        return trim((string)$value);
    }
}
