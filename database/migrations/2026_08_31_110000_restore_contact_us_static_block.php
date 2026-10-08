<?php

use App\Services\ContactUsBlockService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Restore contact_us static block copy wiped by empty template re-render.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', 'contact_us')->value('id');
        if (!$blockId) {
            return;
        }

        try {
            $html = ContactUsBlockService::renderFullHtml();
        } catch (\Throwable $e) {
            return;
        }

        if (trim($html) === '') {
            return;
        }

        $locales = $this->resolveLocales();
        $now = now();

        foreach ($locales as $locale) {
            $exists = DB::table('static_block_translations')
                ->where('static_block_id', $blockId)
                ->where('locale', $locale)
                ->exists();

            if ($exists) {
                DB::table('static_block_translations')
                    ->where('static_block_id', $blockId)
                    ->where('locale', $locale)
                    ->update(['content' => $html]);
            } else {
                DB::table('static_block_translations')->insert([
                    'static_block_id' => $blockId,
                    'locale' => $locale,
                    'title' => 'Contact Us',
                    'content' => $html,
                ]);
            }
        }

        DB::table('static_blocks')->where('id', $blockId)->update(['updated_at' => $now]);
    }

    public function down(): void
    {
        // Content rollback is not safe once restored.
    }

    /** @return string[] */
    private function resolveLocales(): array
    {
        $locales = DB::table('static_block_translations')
            ->where('static_block_id', DB::table('static_blocks')->where('sign', 'contact_us')->value('id'))
            ->distinct()
            ->pluck('locale')
            ->filter(static fn ($locale) => is_string($locale) && $locale !== '')
            ->values()
            ->all();

        if ($locales === []) {
            $fallback = (string)(config('translatable.fallback_locale') ?: config('app.fallback_locale', 'en'));
            $locales = array_values(array_unique(array_filter([
                (string)config('app.locale', 'en'),
                $fallback,
            ])));
        }

        return $locales ?: ['en'];
    }
};
