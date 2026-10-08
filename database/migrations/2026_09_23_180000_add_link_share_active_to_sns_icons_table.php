<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLinkShareActiveToSnsIconsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sns_icons')) {
            return;
        }

        Schema::table('sns_icons', function (Blueprint $table) {
            if (!Schema::hasColumn('sns_icons', 'link_active')) {
                $table->boolean('link_active')->default(1)->after('active')->comment('静态链接展示');
            }
            if (!Schema::hasColumn('sns_icons', 'share_active')) {
                $table->boolean('share_active')->default(1)->after('link_active')->comment('分享功能展示');
            }
        });

        // 兼容旧数据：沿用原 active
        if (Schema::hasColumn('sns_icons', 'active')) {
            DB::table('sns_icons')->orderBy('id')->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    $on = (int)($row->active ?? 1) === 1 ? 1 : 0;
                    DB::table('sns_icons')->where('id', $row->id)->update([
                        'link_active' => $on,
                        'share_active' => $on,
                    ]);
                }
            });
        }
    }

    public function down()
    {
        if (!Schema::hasTable('sns_icons')) {
            return;
        }

        Schema::table('sns_icons', function (Blueprint $table) {
            if (Schema::hasColumn('sns_icons', 'share_active')) {
                $table->dropColumn('share_active');
            }
            if (Schema::hasColumn('sns_icons', 'link_active')) {
                $table->dropColumn('link_active');
            }
        });
    }
}
