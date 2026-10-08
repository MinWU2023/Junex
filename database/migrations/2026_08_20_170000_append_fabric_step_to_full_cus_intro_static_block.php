<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppendFabricStepToFullCusIntroStaticBlock extends Migration
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

        $processTranslations = DB::table('static_block_translations')
            ->where('static_block_id', $processesId)
            ->get(['locale', 'content'])
            ->keyBy('locale');

        $enStep = $this->extractFabricStep((string)optional($processTranslations->get('en'))->content);
        if ($enStep === null || $enStep === '') {
            // fallback: try any locale
            foreach ($processTranslations as $row) {
                $enStep = $this->extractFabricStep((string)$row->content);
                if ($enStep !== null && $enStep !== '') {
                    break;
                }
            }
        }

        if ($enStep === null || $enStep === '') {
            return;
        }

        $introRows = DB::table('static_block_translations')
            ->where('static_block_id', $introId)
            ->get(['id', 'locale', 'content']);

        foreach ($introRows as $row) {
            $content = (string)$row->content;
            if ($content === '' || stripos($content, self::MARKER) !== false) {
                continue;
            }
            // already has the section title without marker (manual paste) — skip duplicate title block
            if (stripos($content, 'Fabric Customization Selection') !== false
                && stripos($content, 'full-cus-fabric-step') !== false
            ) {
                continue;
            }

            $localeStep = $this->extractFabricStep((string)optional($processTranslations->get($row->locale))->content);
            if ($localeStep === null || $localeStep === '') {
                $localeStep = $enStep;
            }

            $append = $this->wrapFabricStep($localeStep);
            $newContent = rtrim($content) . "\n" . $append . "\n";

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
            $content = (string)$row->content;
            $updated = $this->removeAppendedSection($content);
            if ($updated !== $content) {
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
        $start = strripos($before, '<div class="pb-4">');
        if ($start === false) {
            $start = strripos($before, "<div class='pb-4'>");
        }
        if ($start === false) {
            return null;
        }

        $searchFrom = $start + strlen('<div class="pb-4">');
        $next = stripos($html, '<div class="pb-4">', $searchFrom);
        if ($next === false) {
            $next = stripos($html, "<div class='pb-4'>", $searchFrom);
        }

        if ($next === false) {
            // take until closing of steps container is unreliable; use remainder until last reasonable close
            $chunk = substr($html, $start);
            // trim after this step's closing: find matching by taking until we see another step title marker failure
            return trim($chunk);
        }

        return trim(substr($html, $start, $next - $start));
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

    private function removeAppendedSection(string $content): string
    {
        if (stripos($content, self::MARKER) === false) {
            return $content;
        }

        // Remove the appended section tagged with marker
        $pattern = '/\s*<section\b[^>]*' . preg_quote(self::MARKER, '/') . '[^>]*>.*?<\/section>\s*/is';
        $updated = preg_replace($pattern, "\n", $content);

        return is_string($updated) ? rtrim($updated) . "\n" : $content;
    }
}
