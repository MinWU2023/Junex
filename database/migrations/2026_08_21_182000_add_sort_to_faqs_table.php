<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortToFaqsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('faqs')) {
            return;
        }

        Schema::table('faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('faqs', 'sort')) {
                $table->unsignedInteger('sort')->default(0)->comment('排序，越大越靠前');
                $table->index('sort');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('faqs') || !Schema::hasColumn('faqs', 'sort')) {
            return;
        }

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['sort']);
            $table->dropColumn('sort');
        });
    }
}
