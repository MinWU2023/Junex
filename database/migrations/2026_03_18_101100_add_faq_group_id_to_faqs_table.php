<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFaqGroupIdToFaqsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('faqs') && !Schema::hasColumn('faqs', 'faq_group_id')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->unsignedBigInteger('faq_group_id')->nullable()->after('id')->index();
                $table->foreign('faq_group_id')
                    ->references('id')
                    ->on('faq_groups')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('faqs') && Schema::hasColumn('faqs', 'faq_group_id')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->dropForeign(['faq_group_id']);
                $table->dropColumn('faq_group_id');
            });
        }
    }
}
