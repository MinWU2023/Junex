<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RefineProductVideosNullableAndFk extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('product_videos')) {
            return;
        }

        try {
            if (Schema::hasColumn('product_videos', 'path')) {
                DB::statement("ALTER TABLE `product_videos` MODIFY `path` VARCHAR(255) NULL COMMENT '封面图'");
            }
            if (Schema::hasColumn('product_videos', 'video_url')) {
                DB::statement("ALTER TABLE `product_videos` MODIFY `video_url` VARCHAR(255) NULL COMMENT '视频地址'");
            }
        } catch (\Throwable $e) {
            // ignore if already nullable / driver differences
        }
    }

    public function down()
    {
        // keep nullable
    }
}
