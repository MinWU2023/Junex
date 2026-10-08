<?php

namespace App\Console\Commands;

use App\Modules\Page\Models\StaticBlock;
use Illuminate\Console\Command;

/**
 * Inject sec-bg-* / sec-pad markers into existing DB static block HTML
 * without replacing content (safe for CMS-edited blocks).
 */
class InjectStaticBlockSectionMarkers extends Command
{
    protected $signature = 'static-block:inject-section-markers {--dry-run : Show changes only}';

    protected $description = 'Inject sec-bg-white/sec-bg-color/sec-pad into static block HTML in DB';

    /** @var array<string,string> sign => sec-bg-white|sec-bg-color */
    private array $bgBySign = [
        'solutions' => 'sec-bg-white',
        'full_cus' => 'sec-bg-white',
        'full_cus_intro' => 'sec-bg-white',
        'bussness' => 'sec-bg-white',
        'processes' => 'sec-bg-white',
        'odm_oem_cus' => 'sec-bg-white',
        'custom_serrvices' => 'sec-bg-white',
        'defined_services' => 'sec-bg-white',
        'defined_services_faqs' => 'sec-bg-white',
        'certificates' => 'sec-bg-white',
        'custom_process' => 'sec-bg-white',
        'ask_us_home' => 'sec-bg-white',
        'contact_us' => 'sec-bg-white',
        'ask_us' => 'sec-bg-color',
        'sample_stages' => 'sec-bg-color',
        'index_partners' => 'sec-bg-color',
    ];

    public function handle(): int
    {
        $dry = (bool)$this->option('dry-run');
        $blocks = StaticBlock::query()->with('translations')->get();
        $changed = 0;

        foreach ($blocks as $block) {
            $sign = (string)$block->sign;
            $bg = $this->bgBySign[$sign] ?? null;
            if ($bg === null) {
                // Heuristic for unknown signs
                $sample = (string)($block->content ?? '');
                if ($sample === '') {
                    continue;
                }
                $bg = $this->guessBg($sample);
            }

            $contents = [];
            $contents['__main__'] = (string)($block->content ?? '');
            foreach ($block->translations as $tr) {
                $contents[$tr->locale] = (string)($tr->content ?? '');
            }

            $blockDirty = false;
            foreach ($contents as $key => $html) {
                if (trim($html) === '') {
                    continue;
                }
                $next = $this->injectMarkers($html, $bg);
                if ($next === $html) {
                    continue;
                }
                $blockDirty = true;
                if ($dry) {
                    $this->line("[dry] {$sign} {$key} would update (" . strlen($html) . ' -> ' . strlen($next) . ')');
                    continue;
                }
                if ($key === '__main__') {
                    $block->content = $next;
                } else {
                    $tr = $block->translations->firstWhere('locale', $key);
                    if ($tr) {
                        $tr->content = $next;
                        $tr->save();
                    }
                }
            }

            if ($blockDirty && !$dry) {
                $block->save();
                $changed++;
                $this->info("Updated {$sign}");
            } elseif ($blockDirty && $dry) {
                $changed++;
            }
        }

        $this->info(($dry ? 'Would update' : 'Updated') . " {$changed} static block(s).");
        return 0;
    }

    private function guessBg(string $html): string
    {
        if (preg_match('/bg-\[#(?:[fF]{2}|[fF]7[fF]7[fF]7|[eE]{2})]|bg-themeBg-[fgh]|bg-brand-red|cs-stages/i', $html)) {
            // gray/red-ish utility — colored
            if (preg_match('/bg-themeBg-f|bg-\[#F7F7F7\]|bg-\[#F8F8F8\]|cs-stages|bg-brand-red/i', $html)) {
                return 'sec-bg-color';
            }
        }
        return 'sec-bg-white';
    }

    private function injectMarkers(string $html, string $bgClass): string
    {
        // Only touch outermost section opening tags that look like page sections
        if (!preg_match('/<section\b/i', $html)) {
            return $html;
        }

        $html = preg_replace_callback(
            '/<section\b([^>]*)>/i',
            function (array $m) use ($bgClass) {
                $attrs = $m[1];
                if (preg_match('/\bclass=("|\')(.*?)\1/i', $attrs, $cm)) {
                    $quote = $cm[1];
                    $class = $cm[2];
                    // remove opposite / duplicate markers
                    $class = preg_replace('/\bsec-bg-(white|color)\b/', '', $class) ?? $class;
                    $class = trim(preg_replace('/\s+/', ' ', $class) ?? $class);
                    $class = trim($class . ' ' . $bgClass);
                    $attrs = preg_replace('/\bclass=("|\')(.*?)\1/i', 'class=' . $quote . $class . $quote, $attrs, 1);
                } else {
                    $attrs .= ' class="' . $bgClass . '"';
                }
                return '<section' . $attrs . '>';
            },
            $html,
            1
        ) ?? $html;

        // Never leave sec-pad on absolute/decorative layers
        $html = preg_replace('/\bsec-pad\s+(?=absolute\b)/', '', $html) ?? $html;
        $html = preg_replace('/(?<=\s)sec-pad\b(?=[^"]*\babsolute\b)/', '', $html) ?? $html;

        if (!preg_match('/\bsec-pad\b/', $html)) {
            $replaced = preg_replace(
                '/(<div\b[^>]*\bclass=")([^"]*\b(?:py-16|md4:py-16|md1:py-14|py-14|py-12|py-10|py-6|pt-16|md4:pt-16|pt-10)[^"]*)(")/i',
                '$1sec-pad $2$3',
                $html,
                1,
                $count
            );
            if ($count > 0) {
                $html = $replaced;
            } else {
                // first non-absolute div after first section
                $html = preg_replace(
                    '/(<section\b[^>]*>\s*(?:<!--.*?-->\s*)*(?:<div\b[^>]*\babsolute\b[^>]*>.*?<\/div>\s*)*<div\b[^>]*\bclass=")(?![^"]*\babsolute\b)([^"]*)(")/is',
                    '$1sec-pad $2$3',
                    $html,
                    1
                ) ?? $html;
            }
        }

        // contact_us may have multiple sections
        if (substr_count(strtolower($html), '<section') > 1) {
            $html = preg_replace_callback(
                '/<section\b([^>]*)>/i',
                function (array $m) use ($bgClass) {
                    $attrs = $m[1];
                    if (preg_match('/\bsec-bg-(white|color)\b/', $attrs)) {
                        return $m[0];
                    }
                    if (preg_match('/\bclass=("|\')(.*?)\1/i', $attrs, $cm)) {
                        $quote = $cm[1];
                        $class = trim($cm[2] . ' ' . $bgClass);
                        $attrs = preg_replace('/\bclass=("|\')(.*?)\1/i', 'class=' . $quote . $class . $quote, $attrs, 1);
                    } else {
                        $attrs .= ' class="' . $bgClass . '"';
                    }
                    return '<section' . $attrs . '>';
                },
                $html
            ) ?? $html;
        }

        return $html;
    }
}
