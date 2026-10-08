<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyCategoryFieldsInArticlesAndBlogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 修改 articles 表
        Schema::table('articles', function (Blueprint $table) {
            // 删除外键约束
            $table->dropForeign(['article_category_id']);
        });
        
        // 使用原生 SQL 修改字段为可空
        DB::statement('ALTER TABLE `articles` MODIFY `article_category_id` BIGINT UNSIGNED NULL');

        // 修改 blogs 表
        Schema::table('blogs', function (Blueprint $table) {
            // 删除外键约束
            $table->dropForeign(['blog_category_id']);
        });
        
        // 使用原生 SQL 修改字段为可空
        DB::statement('ALTER TABLE `blogs` MODIFY `blog_category_id` BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 恢复 articles 表字段为不可空
        DB::statement('ALTER TABLE `articles` MODIFY `article_category_id` BIGINT UNSIGNED NOT NULL');
        
        // 恢复 articles 表外键约束
        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('article_category_id')
                  ->references('id')
                  ->on('article_categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        // 恢复 blogs 表字段为不可空
        DB::statement('ALTER TABLE `blogs` MODIFY `blog_category_id` BIGINT UNSIGNED NOT NULL');
        
        // 恢复 blogs 表外键约束
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreign('blog_category_id')
                  ->references('id')
                  ->on('blog_categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }
}
