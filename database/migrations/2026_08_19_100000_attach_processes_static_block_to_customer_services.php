<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AttachProcessesStaticBlockToCustomerServices extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_page') || !Schema::hasTable('pages')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', 'processes')->value('id');
        if (!$blockId) {
            return;
        }

        $pageId = DB::table('pages')
            ->where(function ($q) {
                $q->where('url_key', 'customer-services')
                    ->orWhere('url_key', '/customer-services');
            })
            ->value('id');

        if (!$pageId) {
            return;
        }

        $exists = DB::table('static_block_page')
            ->where('static_block_id', $blockId)
            ->where('page_id', $pageId)
            ->exists();

        if ($exists) {
            return;
        }

        $now = now();
        DB::table('static_block_page')->insert([
            'static_block_id' => $blockId,
            'page_id' => $pageId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_page') || !Schema::hasTable('pages')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', 'processes')->value('id');
        if (!$blockId) {
            return;
        }

        $pageId = DB::table('pages')
            ->where(function ($q) {
                $q->where('url_key', 'customer-services')
                    ->orWhere('url_key', '/customer-services');
            })
            ->value('id');

        if (!$pageId) {
            return;
        }

        DB::table('static_block_page')
            ->where('static_block_id', $blockId)
            ->where('page_id', $pageId)
            ->delete();
    }
}
