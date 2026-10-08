<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

/**
 * Re-sync inquiry static block forms: hidden source_url, attachment upload, multipart enctype.
 */
return new class extends Migration
{
    /** @var array<string, string> */
    private array $templateMap = [
        'ask_us' => 'static_block_templates.ask_us',
        'ask_us_home' => 'static_block_templates.ask_us_home',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $locales = $this->resolveLocales();
        $now = now();

        foreach ($this->templateMap as $sign => $view) {
            $blockId = DB::table('static_blocks')->where('sign', $sign)->value('id');
            if (!$blockId) {
                continue;
            }

            try {
                $html = $this->renderTemplate($view);
            } catch (\Throwable $e) {
                continue;
            }

            if (trim($html) === '') {
                continue;
            }

            foreach ($locales as $locale) {
                $exists = DB::table('static_block_translations')
                    ->where('static_block_id', $blockId)
                    ->where('locale', $locale)
                    ->exists();

                if ($exists) {
                    DB::table('static_block_translations')
                        ->where('static_block_id', $blockId)
                        ->where('locale', $locale)
                        ->update([
                            'content' => $html,
                        ]);
                } else {
                    DB::table('static_block_translations')->insert([
                        'static_block_id' => $blockId,
                        'locale' => $locale,
                        'title' => $this->defaultTitle($sign),
                        'content' => $html,
                    ]);
                }
            }

            DB::table('static_blocks')->where('id', $blockId)->update(['updated_at' => $now]);
        }
    }

    public function down(): void
    {
        // Content rollback is not safe once live submissions depend on new fields.
    }

    private function renderTemplate(string $view): string
    {
        return View::make($view, ['askUs' => []])->render();
    }

    /** @return string[] */
    private function resolveLocales(): array
    {
        $locales = [];
        if (Schema::hasTable('static_block_translations')) {
            $locales = DB::table('static_block_translations')
                ->distinct()
                ->pluck('locale')
                ->filter(static fn ($locale) => is_string($locale) && $locale !== '')
                ->values()
                ->all();
        }

        if ($locales === []) {
            $fallback = (string)(config('translatable.fallback_locale') ?: config('app.fallback_locale', 'en'));
            $locales = array_values(array_unique(array_filter([
                (string)config('app.locale', 'en'),
                $fallback,
            ])));
        }

        return $locales ?: ['en'];
    }

    private function defaultTitle(string $sign): string
    {
        return match ($sign) {
            'ask_us_home' => 'Tell Us What You Need',
            'ask_us' => 'To Power Your Brand With Us',
            default => ucfirst(str_replace('_', ' ', $sign)),
        };
    }
};
