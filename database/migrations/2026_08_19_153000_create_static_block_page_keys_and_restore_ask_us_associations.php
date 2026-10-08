<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStaticBlockPageKeysAndRestoreAskUsAssociations extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_block_page_keys')) {
            Schema::create('static_block_page_keys', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('static_block_id');
                $table->string('page_key', 100)->comment('虚拟页面标识，如 home/products');
                $table->timestamps();

                $table->unique(['static_block_id', 'page_key'], 'static_block_page_key_unique');
                $table->index('page_key');
                $table->foreign('static_block_id', 'static_block_page_key_block_fk')
                    ->references('id')
                    ->on('static_blocks')
                    ->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_page_keys')) {
            return;
        }

        $now = now();

        // Only restore ask_us / ask_us_home (compare local vs online).
        // Online real pages kept: about-us / customer-services / search / reviews.
        // Missing online pages restored as virtual keys: home + products family.
        $this->syncBlockPageKeys('ask_us_home', ['home'], $now);
        $this->syncBlockPageKeys('ask_us', [
            'products',
            'product-category',
            'product-tag',
            'product',
        ], $now);
        $this->ensureBlockRealPages('ask_us', [
            'about-us',
            'customer-services',
            'search',
            'reviews',
        ], $now);
    }

    public function down()
    {
        if (Schema::hasTable('static_block_page_keys')) {
            $blockIds = DB::table('static_blocks')
                ->whereIn('sign', ['ask_us', 'ask_us_home'])
                ->pluck('id')
                ->all();
            if ($blockIds !== []) {
                DB::table('static_block_page_keys')
                    ->whereIn('static_block_id', $blockIds)
                    ->whereIn('page_key', [
                        'home',
                        'products',
                        'product-category',
                        'product-tag',
                        'product',
                    ])
                    ->delete();
            }
        }

        Schema::dropIfExists('static_block_page_keys');
    }

    private function syncBlockPageKeys(string $sign, array $keys, $now): void
    {
        $blockId = DB::table('static_blocks')->where('sign', $sign)->value('id');
        if (!$blockId) {
            return;
        }

        foreach ($keys as $key) {
            $key = trim((string)$key, '/');
            if ($key === '') {
                continue;
            }
            $exists = DB::table('static_block_page_keys')
                ->where('static_block_id', $blockId)
                ->where('page_key', $key)
                ->exists();
            if ($exists) {
                continue;
            }
            DB::table('static_block_page_keys')->insert([
                'static_block_id' => $blockId,
                'page_key' => $key,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function ensureBlockRealPages(string $sign, array $urlKeys, $now): void
    {
        if (!Schema::hasTable('static_block_page') || !Schema::hasTable('pages')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', $sign)->value('id');
        if (!$blockId) {
            return;
        }

        foreach ($urlKeys as $urlKey) {
            $urlKey = trim((string)$urlKey, '/');
            $pageId = DB::table('pages')
                ->where(function ($q) use ($urlKey) {
                    $q->where('url_key', $urlKey)->orWhere('url_key', '/' . $urlKey);
                })
                ->value('id');
            if (!$pageId) {
                continue;
            }
            $exists = DB::table('static_block_page')
                ->where('static_block_id', $blockId)
                ->where('page_id', $pageId)
                ->exists();
            if ($exists) {
                continue;
            }
            DB::table('static_block_page')->insert([
                'static_block_id' => $blockId,
                'page_id' => $pageId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
