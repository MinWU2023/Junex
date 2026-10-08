<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillCustomerReviewTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('customer_reviews') || !Schema::hasTable('customer_review_translations')) {
            return;
        }

        $locale = (string)config('app.locale');
        if ($locale === '') {
            $locale = 'en';
        }

        $rows = DB::table('customer_reviews')
            ->select(['id', 'subject', 'content'])
            ->orderBy('id')
            ->get();

        foreach ($rows as $row) {
            $exists = DB::table('customer_review_translations')
                ->where('customer_review_id', (int)$row->id)
                ->where('locale', $locale)
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('customer_review_translations')->insert([
                'customer_review_id' => (int)$row->id,
                'locale' => $locale,
                'subject' => $row->subject,
                'content' => $row->content,
            ]);
        }
    }

    public function down()
    {
        // no-op
    }
}
