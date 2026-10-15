<?php

namespace App\Services\Translate;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TranslateRegistryService
{
    public function modules(): array
    {
        $modules = [];
        foreach ((array) config('multilingual', []) as $key => $item) {
            if (!is_array($item) || empty($item['model'])) {
                continue;
            }
            $modelClass = $item['model'];
            if (!class_exists($modelClass)) {
                continue;
            }
            try {
                $model = new $modelClass();
            } catch (\Throwable $e) {
                continue;
            }
            if (!method_exists($model, 'translations')) {
                continue;
            }
            $table = $model->getTable();
            if (!Schema::hasTable($table)) {
                continue;
            }
            $translationModel = $model->translations()->getRelated();
            $translationTable = $translationModel->getTable();
            if (!Schema::hasTable($translationTable)) {
                continue;
            }
            $modules[] = [
                'key' => $key,
                'label' => $item['label'] ?? $key,
                'model' => $modelClass,
                'main_table' => $table,
                'translation_table' => $translationTable,
                'foreign_key' => Str::snake(class_basename($model)) . '_id',
            ];
        }

        return $modules;
    }

    public function findModule(string $key): ?array
    {
        foreach ($this->modules() as $module) {
            if ($module['key'] === $key) {
                return $module;
            }
        }

        return null;
    }

    public function fields(string $moduleKey): array
    {
        $config = config('multilingual.' . $moduleKey);
        if (!is_array($config)) {
            return [];
        }
        $value = $config['value'] ?? [];
        $existingColumns = $this->translationColumns($moduleKey);
        $fields = [];
        foreach (['translateField', 'seoTranslateField'] as $group) {
            foreach ((array) ($value[$group] ?? []) as $field) {
                if (empty($field['name'])) {
                    continue;
                }
                $name = (string) $field['name'];
                // 配置里声明但翻译表无此列的字段直接跳过，避免工作台写入报错
                if ($existingColumns !== null && !in_array($name, $existingColumns, true)) {
                    continue;
                }
                $fields[$name] = [
                    'name' => $name,
                    'label' => $field['label'] ?? $name,
                    'type' => $field['type'] ?? 'text',
                    'group' => $group === 'seoTranslateField' ? 'seo' : 'content',
                ];
            }
        }

        return array_values($fields);
    }

    /**
     * @return array<int, string>|null  null = 无法检测时不拦截
     */
    public function translationColumns(string $moduleKey): ?array
    {
        $modelClass = $this->modelClass($moduleKey);
        if (!$modelClass) {
            return null;
        }
        try {
            $model = new $modelClass();
            if (!method_exists($model, 'translations')) {
                return null;
            }
            $table = $model->translations()->getRelated()->getTable();
            if (!Schema::hasTable($table)) {
                return null;
            }

            return Schema::getColumnListing($table);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function modelClass(string $moduleKey): ?string
    {
        return $this->findModule($moduleKey)['model'] ?? null;
    }

    public function displayNameForRecord(object $model): string
    {
        if (method_exists($model, 'translate')) {
            $en = $model->translate('en', false);
            if ($en && !empty($en->title)) {
                return (string) $en->title;
            }
            if ($en && !empty($en->name)) {
                return (string) $en->name;
            }
            $default = $model->translate(config('app.locale', 'en'), false);
            if ($default && !empty($default->title)) {
                return (string) $default->title;
            }
            if ($default && !empty($default->name)) {
                return (string) $default->name;
            }
        }
        foreach (['sign', 'name', 'title'] as $column) {
            if (!empty($model->{$column})) {
                return (string) $model->{$column};
            }
        }

        return '#' . $model->getKey();
    }
}
