<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Force re-sync: copy "Fabric Customization Selection" from processes
 * into full_cus_intro (below FULL CUSTOMIZATION SERVICE).
 * Safe to re-run via migrate; also callable logic for ops.
 */
class ForceResyncFabricStepToFullCusIntro extends Migration
{
    private const MARKER = 'data-copied-from="processes-fabric-step"';

    public function up()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $processesId = DB::table('static_blocks')->where('sign', 'processes')->value('id');
        $introId = DB::table('static_blocks')->where('sign', 'full_cus_intro')->value('id');
        if (!$processesId || !$introId) {
            return;
        }

        // Ensure intro is bound to customer-services
        if (Schema::hasTable('static_block_page') && Schema::hasTable('pages')) {
            $pageId = DB::table('pages')
                ->where(function ($q) {
                    $q->where('url_key', 'customer-services')
                        ->orWhere('url_key', '/customer-services');
                })
                ->value('id');
            if ($pageId) {
                $bound = DB::table('static_block_page')
                    ->where('static_block_id', $introId)
                    ->where('page_id', $pageId)
                    ->exists();
                if (!$bound) {
                    $now = now();
                    DB::table('static_block_page')->insert([
                        'static_block_id' => $introId,
                        'page_id' => $pageId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }

        $processTranslations = DB::table('static_block_translations')
            ->where('static_block_id', $processesId)
            ->get(['locale', 'content'])
            ->keyBy('locale');

        $fallbackStep = null;
        foreach (['en', config('app.locale'), config('app.fallback_locale')] as $prefer) {
            $prefer = (string)$prefer;
            if ($prefer === '' || !$processTranslations->has($prefer)) {
                continue;
            }
            $fallbackStep = $this->extractFabricStep((string)$processTranslations->get($prefer)->content);
            if ($fallbackStep) {
                break;
            }
        }
        if (!$fallbackStep) {
            foreach ($processTranslations as $row) {
                $fallbackStep = $this->extractFabricStep((string)$row->content);
                if ($fallbackStep) {
                    break;
                }
            }
        }
        if (!$fallbackStep) {
            return;
        }

        $introRows = DB::table('static_block_translations')
            ->where('static_block_id', $introId)
            ->get(['id', 'locale', 'content']);

        // If intro has no translation rows, create from processes locales
        if ($introRows->isEmpty()) {
            $nowLocales = $processTranslations->keys()->all();
            if (empty($nowLocales)) {
                $nowLocales = ['en'];
            }
            foreach ($nowLocales as $locale) {
                $step = $this->extractFabricStep((string)optional($processTranslations->get($locale))->content) ?: $fallbackStep;
                $base = $this->defaultIntroShell();
                DB::table('static_block_translations')->insert([
                    'static_block_id' => $introId,
                    'locale' => $locale,
                    'title' => 'Full Customization Service',
                    'content' => rtrim($base) . "\n" . $this->wrapFabricStep($step) . "\n",
                ]);
            }
            return;
        }

        foreach ($introRows as $row) {
            $content = $this->stripOldFabricAppend((string)$row->content);
            $step = $this->extractFabricStep((string)optional($processTranslations->get($row->locale))->content);
            if (!$step) {
                $step = $fallbackStep;
            }
            $newContent = rtrim($content) . "\n" . $this->wrapFabricStep($step) . "\n";
            DB::table('static_block_translations')
                ->where('id', $row->id)
                ->update(['content' => $newContent]);
        }
    }

    public function down()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $introId = DB::table('static_blocks')->where('sign', 'full_cus_intro')->value('id');
        if (!$introId) {
            return;
        }

        $rows = DB::table('static_block_translations')
            ->where('static_block_id', $introId)
            ->get(['id', 'content']);

        foreach ($rows as $row) {
            $updated = $this->stripOldFabricAppend((string)$row->content);
            if ($updated !== (string)$row->content) {
                DB::table('static_block_translations')
                    ->where('id', $row->id)
                    ->update(['content' => $updated]);
            }
        }
    }

    private function extractFabricStep(?string $html): ?string
    {
        $html = (string)$html;
        if ($html === '') {
            return null;
        }

        $needle = 'Fabric Customization Selection';
        $titlePos = stripos($html, $needle);
        if ($titlePos === false) {
            return null;
        }

        $before = substr($html, 0, $titlePos);
        if (!preg_match_all('/<div\b[^>]*class=(["\'])([^"\']*\bpb-4\b[^"\']*)\1[^>]*>/i', $before, $matches, PREG_OFFSET_CAPTURE)) {
            // looser fallback
            $start = strripos($before, 'pb-4');
            if ($start === false) {
                return null;
            }
            $divStart = strripos(substr($before, 0, $start + 1), '<div');
            if ($divStart === false) {
                return null;
            }
            $startPos = $divStart;
        } else {
            $last = end($matches[0]);
            $startPos = (int)$last[1];
        }

        $searchFrom = $startPos + 10;
        $nextPos = null;
        if (preg_match_all('/<div\b[^>]*class=(["\'])([^"\']*\bpb-4\b[^"\']*)\1[^>]*>/i', $html, $all, PREG_OFFSET_CAPTURE)) {
            foreach ($all[0] as $m) {
                $pos = (int)$m[1];
                if ($pos > $searchFrom) {
                    $nextPos = $pos;
                    break;
                }
            }
        }

        if ($nextPos === null) {
            return trim(substr($html, $startPos));
        }

        return trim(substr($html, $startPos, $nextPos - $startPos));
    }

    private function wrapFabricStep(string $stepHtml): string
    {
        $marker = self::MARKER;

        return <<<HTML
<section class="w-full bg-white full-cus-fabric-step" aria-label="Fabric Customization Selection" {$marker}>
    <div class="mx-auto w-full max-w-[1200px] px-4 pb-10 pt-2 sm2:px-5 md1:px-6 md1:pb-12 lg1:px-0 md4:pb-16">
        <div class="space-y-7 md4:space-y-8">
{$stepHtml}
        </div>
    </div>
</section>
HTML;
    }

    private function stripOldFabricAppend(string $content): string
    {
        // marker-based section
        if (stripos($content, self::MARKER) !== false) {
            $pattern = '/\s*<section\b[^>]*' . preg_quote(self::MARKER, '/') . '[^>]*>.*?<\/section>\s*/is';
            $updated = preg_replace($pattern, "\n", $content);
            if (is_string($updated)) {
                $content = $updated;
            }
        }

        // class-based leftover
        if (stripos($content, 'full-cus-fabric-step') !== false) {
            $pattern = '/\s*<section\b[^>]*full-cus-fabric-step[^>]*>.*?<\/section>\s*/is';
            $updated = preg_replace($pattern, "\n", $content);
            if (is_string($updated)) {
                $content = $updated;
            }
        }

        return rtrim($content) . "\n";
    }

    private function defaultIntroShell(): string
    {
        return <<<'HTML'
<section class="relative w-full overflow-hidden bg-themeBg-a full_cus bg-center bg-no-repeat bg-cover" style="background-image: url('/front/imgs/ccs-service-bg.png')">
    <div class="relative mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-12 md1:py-14 md4:py-16">
        <div class="flex flex-col items-center text-center">
        <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">FULL CUSTOMIZATION SERVICE</div>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>
    </div>
    </div>
</section>
HTML;
    }
}
