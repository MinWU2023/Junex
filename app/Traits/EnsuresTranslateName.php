<?php

namespace App\Traits;

/**
 * 云端 Translate 插件 GetDataCollection 强制读取模型 name。
 * 自定义模块若未填 name，保存时从其它已填翻译字段回填，避免拉数名为空。
 */
trait EnsuresTranslateName
{
    protected static function bootEnsuresTranslateName()
    {
        static::saving(function ($model) {
            if (!property_exists($model, 'translatedAttributes')) {
                return;
            }
            $attrs = (array)$model->translatedAttributes;
            if (!in_array('name', $attrs, true)) {
                return;
            }

            $current = $model->name;
            if (is_string($current) && trim($current) !== '') {
                return;
            }

            foreach (['title', 'label', 'alt', 'title_prefix', 'subtitle'] as $field) {
                if (!in_array($field, $attrs, true)) {
                    continue;
                }
                $value = $model->{$field};
                if (!is_string($value) || trim($value) === '') {
                    continue;
                }
                $model->name = mb_substr(trim(strip_tags($value)), 0, 255);
                return;
            }

            // SNS 等仅有 alt 且为空时，回退主表标识字段
            foreach (['sign', 'code', 'tab_key'] as $mainField) {
                if (!array_key_exists($mainField, $model->getAttributes())) {
                    continue;
                }
                $value = (string)($model->getAttributes()[$mainField] ?? '');
                if (trim($value) === '') {
                    continue;
                }
                $model->name = mb_substr(trim($value), 0, 255);
                return;
            }
        });
    }
}
