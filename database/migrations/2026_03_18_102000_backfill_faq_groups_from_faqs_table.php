<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillFaqGroupsFromFaqsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('faqs') || !Schema::hasTable('faq_groups') || !Schema::hasTable('faq_group_translations')) {
            return;
        }

        if (!Schema::hasColumn('faqs', 'group') || !Schema::hasColumn('faqs', 'faq_group_id')) {
            return;
        }

        $locale = (string)config('app.locale');
        if ($locale === '') {
            $locale = 'en';
        }

        $now = date('Y-m-d H:i:s');

        $groupNames = DB::table('faqs')
            ->whereNull('faq_group_id')
            ->whereNotNull('group')
            ->where('group', '<>', '')
            ->distinct()
            ->orderBy('group')
            ->pluck('group')
            ->toArray();

        foreach ($groupNames as $name) {
            $name = trim((string)$name);
            if ($name === '') {
                continue;
            }

            $existingId = DB::table('faq_groups')->where('name', $name)->value('id');
            if (!$existingId) {
                $existingId = DB::table('faq_groups')->insertGetId([
                    'name' => $name,
                    'content' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('faq_group_translations')->insert([
                    'faq_group_id' => $existingId,
                    'locale' => $locale,
                    'name' => $name,
                    'content' => null,
                ]);
            }

            DB::table('faqs')
                ->whereNull('faq_group_id')
                ->where('group', $name)
                ->update([
                    'faq_group_id' => $existingId,
                ]);
        }
    }

    public function down()
    {
        // no-op
    }
}
