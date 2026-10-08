<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Inquiry success left panel: full-width static block with {{ email }} placeholder.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $sign = 'inquiry_success';
        $html = $this->html();
        $now = now();

        $blockId = DB::table('static_blocks')->where('sign', $sign)->value('id');
        if (!$blockId) {
            $blockId = DB::table('static_blocks')->insertGetId([
                'sign' => $sign,
                'sort' => 60,
                'active' => 1,
                'remark' => '询盘成功页：左侧全宽成功提示，{{ email }} 替换为本次询盘邮箱',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            DB::table('static_blocks')->where('id', $blockId)->update([
                'sort' => 60,
                'active' => 1,
                'remark' => '询盘成功页：左侧全宽成功提示，{{ email }} 替换为本次询盘邮箱',
                'updated_at' => $now,
            ]);
        }

        foreach ($this->resolveLocales() as $locale) {
            $exists = DB::table('static_block_translations')
                ->where('static_block_id', $blockId)
                ->where('locale', $locale)
                ->exists();

            if ($exists) {
                DB::table('static_block_translations')
                    ->where('static_block_id', $blockId)
                    ->where('locale', $locale)
                    ->update([
                        'title' => 'Inquiry Success',
                        'content' => $html,
                    ]);
            } else {
                DB::table('static_block_translations')->insert([
                    'static_block_id' => $blockId,
                    'locale' => $locale,
                    'title' => 'Inquiry Success',
                    'content' => $html,
                ]);
            }
        }

        if (Schema::hasTable('static_block_page_keys')) {
            $bound = DB::table('static_block_page_keys')
                ->where('static_block_id', $blockId)
                ->where('page_key', 'inquirysuccess')
                ->exists();
            if (!$bound) {
                DB::table('static_block_page_keys')->insert([
                    'static_block_id' => $blockId,
                    'page_key' => 'inquirysuccess',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('static_blocks')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', 'inquiry_success')->value('id');
        if (!$blockId) {
            return;
        }

        if (Schema::hasTable('static_block_page_keys')) {
            DB::table('static_block_page_keys')->where('static_block_id', $blockId)->delete();
        }
        if (Schema::hasTable('static_block_translations')) {
            DB::table('static_block_translations')->where('static_block_id', $blockId)->delete();
        }
        DB::table('static_blocks')->where('id', $blockId)->delete();
    }

    private function html(): string
    {
        return <<<'HTML'
<div class="w-full rounded bg-themeBg-f px-5 py-8 shadow-sm ring-1 ring-themeBg-c md1:px-7 md1:py-10 md4:px-9 md4:py-12">
    <div class="inline-flex items-center rounded-full bg-themeBg-c px-3 py-1 text-f18 font-poppins-medium uppercase tracking-wide text-themeText-h">
        Thank You For Your Inquiry
    </div>
    <div class="mt-5 flex flex-col gap-2 md1:mt-6">
        <div class="text-f32 font-poppins-semibold text-themeText-a md1:text-f36">
            Your message has been sent successfully.
        </div>
        <p class="text-f14 font-poppins-regular leading-relaxed text-themeText-b md1:text-f16">
            Our professional sales team will review your request and contact you at
            <span class="font-poppins-semibold text-themeText-h">{{ email }}</span>
            within 24 hours with detailed quotation, product suggestions and shipping solutions tailored to your business.
        </p>
    </div>
    <p class="mt-4 text-f14 font-poppins-regular text-themeText-b md1:text-f16">
        You will be redirected to the home page in
        <span id="inquiry-success-countdown" class="font-poppins-semibold text-themeText-h">5</span>
        seconds. If you do not want to wait, you can also use the buttons below to continue browsing.
    </p>
    <div class="mt-6 flex flex-wrap items-center gap-3 md1:gap-4">
        <a href="/" class="inline-flex h-11 items-center justify-center rounded bg-themeBg-d px-5 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-[#c22522] md1:h-12 md1:px-6">
            Back To Home
        </a>
        <a href="/products" class="inline-flex h-11 items-center justify-center rounded border border-themeBg-d bg-white px-4 text-f14 font-poppins-medium uppercase tracking-wide text-themeText-h transition hover:bg-themeBg-d hover:text-white md1:h-12 md1:px-5">
            View More Products
        </a>
    </div>
</div>
HTML;
    }

    /** @return string[] */
    private function resolveLocales(): array
    {
        $locales = config('translatable.locales', []);
        $out = [];
        if (is_array($locales)) {
            foreach ($locales as $key => $value) {
                if (is_string($key) && !is_numeric($key)) {
                    $out[] = $key;
                } elseif (is_string($value)) {
                    $out[] = $value;
                }
            }
        }

        $out = array_values(array_unique(array_filter($out)));
        if ($out === []) {
            $fallback = (string)(config('translatable.fallback_locale') ?: config('app.fallback_locale', 'en'));
            $out = [$fallback !== '' ? $fallback : 'en'];
        }

        return $out;
    }
};
