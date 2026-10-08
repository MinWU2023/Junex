<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlogIdToExcitingUpdatesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('exciting_updates')) {
            return;
        }

        Schema::table('exciting_updates', function (Blueprint $table) {
            if (!Schema::hasColumn('exciting_updates', 'blog_id')) {
                $table->unsignedBigInteger('blog_id')->nullable()->after('id')->comment('关联博客ID');
                $table->unique('blog_id', 'exciting_updates_blog_id_unique');
                $table->index('blog_id');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('exciting_updates')) {
            return;
        }

        Schema::table('exciting_updates', function (Blueprint $table) {
            if (Schema::hasColumn('exciting_updates', 'blog_id')) {
                $table->dropUnique('exciting_updates_blog_id_unique');
                $table->dropIndex(['blog_id']);
                $table->dropColumn('blog_id');
            }
        });
    }
}
