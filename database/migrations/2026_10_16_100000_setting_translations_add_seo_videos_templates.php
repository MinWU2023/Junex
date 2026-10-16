<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingTranslationsAddSeoVideosTemplates extends Migration
{
    private array $columns = [
        'seo_videos_title' => '视频列表标题模板',
        'seo_videos_keywords' => '视频列表关键词模板',
        'seo_videos_description' => '视频列表描述模板',
    ];

    public function up()
    {
        Schema::table('setting_translations', function (Blueprint $table) {
            foreach ($this->columns as $column => $comment) {
                if (!Schema::hasColumn('setting_translations', $column)) {
                    $table->string($column)->nullable()->comment($comment);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('setting_translations', function (Blueprint $table) {
            foreach (array_keys($this->columns) as $column) {
                if (Schema::hasColumn('setting_translations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
