<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 路由改名：/myinquirys -> /my-inquiries，/inquirysuccess -> /inquiry-success。
 * 同步已存在的静态块页面关联、页面开关、CMS 单页面 url_key 里的旧值。
 */
return new class extends Migration
{
    private array $map = [
        'myinquirys' => 'my-inquiries',
        'inquirysuccess' => 'inquiry-success',
    ];

    public function up(): void
    {
        $this->rename($this->map);
    }

    public function down(): void
    {
        $this->rename(array_flip($this->map));
    }

    private function rename(array $map): void
    {
        foreach ($map as $old => $new) {
            // 静态块关联的页面 key（新 key 已存在同一静态块关联时，直接删掉旧记录避免重复）
            if (Schema::hasTable('static_block_page_keys')) {
                $rows = DB::table('static_block_page_keys')->whereIn('page_key', [$old, '/' . $old])->get();
                foreach ($rows as $row) {
                    $dup = DB::table('static_block_page_keys')
                        ->where('static_block_id', $row->static_block_id)
                        ->where('page_key', $new)
                        ->exists();
                    if ($dup) {
                        DB::table('static_block_page_keys')->where('id', $row->id)->delete();
                    } else {
                        DB::table('static_block_page_keys')->where('id', $row->id)->update(['page_key' => $new]);
                    }
                }
            }

            // 前台页面 sitemap/访问开关
            if (Schema::hasTable('front_page_controls')
                && DB::table('front_page_controls')->where('path', $old)->exists()
                && !DB::table('front_page_controls')->where('path', $new)->exists()) {
                DB::table('front_page_controls')->where('path', $old)->update(['path' => $new]);
            }

            // CMS 单页面（pages.url_key）
            if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'url_key')) {
                foreach ([$old => $new, '/' . $old => '/' . $new] as $from => $to) {
                    if (DB::table('pages')->where('url_key', $from)->exists()
                        && !DB::table('pages')->where('url_key', $to)->exists()) {
                        DB::table('pages')->where('url_key', $from)->update(['url_key' => $to]);
                    }
                }
            }
        }
    }
};
