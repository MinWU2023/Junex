<?php

namespace App\Console\Commands;

use App\Modules\Setting\Models\BrandSolution;
use App\Services\Translate\TranslationPersistenceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

/**
 * 清理品牌方案被整段 JSON/串台污染的非英译文，清空后前台会英语兜底，工作台可重新翻译。
 */
class RepairBrandSolutionTranslations extends Command
{
    protected $signature = 'translate:repair-brand-solutions {--dry-run : 只检查不写入}';

    protected $description = 'Repair polluted BrandSolution locale translations (title/description/features/button)';

    public function handle(TranslationPersistenceService $persistence): int
    {
        $dry = (bool)$this->option('dry-run');
        $cleared = 0;

        foreach (BrandSolution::with('translations')->orderBy('id')->get() as $model) {
            $en = $model->translate('en', false);
            $enTitle = trim((string)($en->title ?? ''));
            $enDesc = trim((string)($en->description ?? ''));
            $enBtn = trim((string)($en->button_text ?? ''));
            $enFeatFp = md5(json_encode($persistence->normalizeFeatureList($en->features ?? null), JSON_UNESCAPED_UNICODE));

            foreach ($model->translations as $tr) {
                if (strtolower((string)$tr->locale) === 'en') {
                    continue;
                }

                $dirty = false;
                $title = trim((string)($tr->title ?? ''));
                $desc = trim((string)($tr->description ?? ''));
                $btn = trim((string)($tr->button_text ?? ''));
                $featList = $persistence->normalizeFeatureList($tr->features ?? null);
                $featFp = md5(json_encode($featList, JSON_UNESCAPED_UNICODE));
                $featBlob = mb_strtolower(json_encode($featList, JSON_UNESCAPED_UNICODE) ?: '');

                if ($this->isPollutedText($title) || ($title !== '' && $enTitle !== '' && strcasecmp($title, $enTitle) !== 0 && $this->isSharedWrongTitle($title))) {
                    $tr->title = null;
                    $dirty = true;
                }
                if ($this->isPollutedText($desc) || ($desc !== '' && $enDesc !== '' && $this->isPollutedText($desc))) {
                    $tr->description = null;
                    $dirty = true;
                }
                if ($btn !== '' && $enBtn !== '' && strcasecmp($btn, 'Learn More') === 0 && strcasecmp($btn, $enBtn) !== 0) {
                    $tr->button_text = null;
                    $dirty = true;
                }
                if (
                    $featList === []
                    || $featFp === $enFeatFp
                    || str_contains($featBlob, 'environmentally friendly')
                    || str_contains($featBlob, 'reduce fast fashion')
                ) {
                    // 空/仍是英文原文指纹/已知串台文案 → 清空，便于重翻与英语兜底
                    if ($featList !== [] || ($tr->features !== null && $tr->features !== '' && $tr->features !== [])) {
                        if (str_contains($featBlob, 'environmentally friendly')
                            || str_contains($featBlob, 'reduce fast fashion')
                            || $featFp === $enFeatFp
                        ) {
                            $tr->features = [];
                            $dirty = true;
                        }
                    }
                }

                if (!$dirty) {
                    continue;
                }

                $this->line(($dry ? '[dry] ' : '') . "clear bs={$model->id} locale={$tr->locale}");
                if (!$dry) {
                    $tr->save();
                }
                $cleared++;
            }
        }

        if (!$dry) {
            try {
                Cache::flush();
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $this->info(($dry ? 'Would repair ' : 'Repaired ') . $cleared . ' locale row(s).');

        return self::SUCCESS;
    }

    protected function isPollutedText(string $text): bool
    {
        $t = mb_strtolower(trim($text));
        if ($t === '') {
            return false;
        }

        return str_contains($t, 'ectionwear champions')
            || str_contains($t, 'environmentally friendly fabrics')
            || str_contains($t, 'reduce fast fashion')
            || $t === 'junex active wear brands solutions';
    }

    protected function isSharedWrongTitle(string $title): bool
    {
        return strcasecmp(trim($title), 'Junex Active Wear Brands Solutions') === 0;
    }
}
