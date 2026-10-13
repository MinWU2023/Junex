<?php

namespace App\Console\Commands;

use Addons\Translate\Collections\GetDataCollection;
use App\Modules\Page\Models\StaticBlock;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * 线上排查：静态块是否满足 Translate getData 拉取条件。
 * php artisan translate:diagnose-static-block
 */
class DiagnoseStaticBlockTranslate extends Command
{
    protected $signature = 'translate:diagnose-static-block';

    protected $description = 'Diagnose static_block Translate plugin pull readiness';

    public function handle(): int
    {
        $this->info('=== static_block Translate diagnose ===');

        $config = config('multilingual.static_block');
        if (!$config) {
            $this->error('config multilingual.static_block missing');
            return 1;
        }
        $this->line('config model: ' . ($config['model'] ?? '-'));
        $fields = collect($config['value']['translateField'] ?? [])->pluck('name')->all();
        $this->line('translateField: ' . implode(', ', $fields));
        $this->line('has name field: ' . (in_array('name', $fields, true) ? 'yes' : 'NO'));

        $checks = [
            'static_blocks' => Schema::hasTable('static_blocks'),
            'static_blocks.name' => Schema::hasColumn('static_blocks', 'name'),
            'static_blocks.is_translate' => Schema::hasColumn('static_blocks', 'is_translate'),
            'static_block_translations' => Schema::hasTable('static_block_translations'),
            'static_block_translations.name' => Schema::hasColumn('static_block_translations', 'name'),
        ];
        foreach ($checks as $label => $ok) {
            $this->{$ok ? 'info' : 'error'}(($ok ? '[OK] ' : '[MISS] ') . $label);
        }

        $total = StaticBlock::query()->count();
        $active = StaticBlock::query()->active()->count();
        $this->line("rows total={$total}, active={$active} (getData uses scopeActive)");

        $emptyMainName = Schema::hasColumn('static_blocks', 'name')
            ? StaticBlock::query()->where(function ($q) {
                $q->whereNull('name')->orWhere('name', '');
            })->count()
            : -1;
        $this->line("main name empty count: {$emptyMainName}");

        if (!class_exists(GetDataCollection::class)) {
            $this->error('Translate addon GetDataCollection not found');
            return 1;
        }

        try {
            $page = StaticBlock::query()->active()->paginate(3);
            $payload = (new GetDataCollection($page))->toArray(Request::create('/'));
            $items = $payload['data'] ?? [];
            $this->info('getData simulate ok, sample count=' . count($items));
            foreach ($items as $item) {
                $this->line(sprintf(
                    '  id=%s name=%s translations=%d',
                    $item['id'] ?? '-',
                    $item['name'] ?? '(null)',
                    is_countable($item['translations'] ?? null) ? count($item['translations']) : 0
                ));
            }
        } catch (\Throwable $e) {
            $this->error('getData simulate FAILED: ' . $e->getMessage());
            $this->line($e->getFile() . ':' . $e->getLine());
            return 1;
        }

        $this->info('=== done ===');
        return 0;
    }
}
