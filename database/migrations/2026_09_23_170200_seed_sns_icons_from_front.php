<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedSnsIconsFromFront extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sns_icons') || !Schema::hasTable('sns_icon_translations')) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $locales = ['en'];
        if (Schema::hasTable('locales')) {
            $codes = DB::table('locales')->pluck('language_code')->filter()->unique()->values()->all();
            if (!empty($codes)) {
                $locales = $codes;
            }
        }

        $rows = [
            [
                'sign' => 'twitter',
                'path' => '/front/icons/twitter.svg',
                'link' => '#',
                'sort' => 50,
                'alt' => 'Twitter',
            ],
            [
                'sign' => 'linkedin',
                'path' => '/front/icons/linkedin.svg',
                'link' => '#',
                'sort' => 40,
                'alt' => 'LinkedIn',
            ],
            [
                'sign' => 'youtube',
                'path' => '/front/icons/youtube.svg',
                'link' => '#',
                'sort' => 30,
                'alt' => 'YouTube',
            ],
            [
                'sign' => 'instagram',
                'path' => '/front/icons/instagram.svg',
                'link' => '#',
                'sort' => 20,
                'alt' => 'Instagram',
            ],
            [
                'sign' => 'pinterest',
                'path' => '/front/icons/pinterest.svg',
                'link' => '#',
                'sort' => 10,
                'alt' => 'Pinterest',
            ],
        ];

        foreach ($rows as $row) {
            $exists = DB::table('sns_icons')->where('sign', $row['sign'])->exists();
            if ($exists) {
                continue;
            }

            $id = DB::table('sns_icons')->insertGetId([
                'sign' => $row['sign'],
                'path' => $row['path'],
                'link' => $row['link'],
                'sort' => $row['sort'],
                'active' => 1,
                'link_active' => 1,
                'share_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($locales as $locale) {
                DB::table('sns_icon_translations')->insert([
                    'sns_icon_id' => $id,
                    'locale' => (string)$locale,
                    'alt' => $row['alt'],
                ]);
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('sns_icons')) {
            return;
        }

        $signs = ['twitter', 'linkedin', 'youtube', 'instagram', 'pinterest'];
        DB::table('sns_icons')->whereIn('sign', $signs)->delete();
    }
}
