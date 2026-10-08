<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Fix tree rows where id === parent_id (breaks layui treeTable).
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'product_categories',
            'navigations',
            'menus',
            'article_categories',
            'blog_categories',
            'download_categories',
        ] as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'parent_id')) {
                continue;
            }
            DB::table($table)->whereColumn('id', 'parent_id')->update(['parent_id' => 0]);
        }
    }

    public function down(): void
    {
        //
    }
};
