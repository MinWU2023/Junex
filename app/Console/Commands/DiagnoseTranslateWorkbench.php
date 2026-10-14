<?php

namespace App\Console\Commands;

use App\Services\Translate\TranslateRegistryService;
use Illuminate\Console\Command;

class DiagnoseTranslateWorkbench extends Command
{
    protected $signature = 'translate:diagnose-workbench {module?} {--config-only : Read multilingual config without database}';

    protected $description = 'List translatable modules/tables available in translate workbench';

    public function handle(TranslateRegistryService $registry): int
    {
        $moduleKey = $this->argument('module');

        if ($moduleKey) {
            return $this->showModule($registry, $moduleKey);
        }

        if ($this->option('config-only')) {
            return $this->listConfigModules();
        }

        try {
            $modules = $registry->modules();
        } catch (\Throwable $e) {
            $this->warn('Database unavailable: ' . $e->getMessage());
            $this->line('Falling back to config-only mode...');
            return $this->listConfigModules();
        }

        $this->info('Available translate workbench modules: ' . count($modules));
        foreach ($modules as $module) {
            $fieldCount = count($registry->fields($module['key']));
            $this->line(sprintf(
                '  %-24s %-20s -> %-28s (%d fields)',
                $module['key'],
                $module['main_table'],
                $module['translation_table'],
                $fieldCount
            ));
        }

        return 0;
    }

    protected function showModule(TranslateRegistryService $registry, string $moduleKey): int
    {
        $config = config('multilingual.' . $moduleKey);
        if (!is_array($config)) {
            $this->error('Module not found in config: ' . $moduleKey);
            return 1;
        }

        $this->info('Module: ' . ($config['label'] ?? $moduleKey) . ' (' . $moduleKey . ')');
        $this->line('Model: ' . ($config['model'] ?? '-'));
        $this->line('Fields:');
        foreach ($registry->fields($moduleKey) as $field) {
            $this->line('  - ' . $field['name'] . ' [' . $field['type'] . '] ' . $field['label']);
        }

        if ($this->option('config-only')) {
            return 0;
        }

        try {
            $module = $registry->findModule($moduleKey);
            if ($module) {
                $this->line('Main table: ' . $module['main_table']);
                $this->line('Translation table: ' . $module['translation_table']);
                $this->line('Foreign key: ' . $module['foreign_key']);
            }
        } catch (\Throwable $e) {
            $this->warn('Database check skipped: ' . $e->getMessage());
        }

        return 0;
    }

    protected function listConfigModules(): int
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
            $translationModel = $model->translations()->getRelated();
            $modules[] = [
                'key' => $key,
                'label' => $item['label'] ?? $key,
                'main_table' => $model->getTable(),
                'translation_table' => $translationModel->getTable(),
                'field_count' => count((new TranslateRegistryService())->fields($key)),
            ];
        }

        $this->info('Config modules (no DB check): ' . count($modules));
        foreach ($modules as $module) {
            $this->line(sprintf(
                '  %-24s %-20s -> %-28s (%d fields)',
                $module['key'],
                $module['main_table'],
                $module['translation_table'],
                $module['field_count']
            ));
        }

        return 0;
    }
}
