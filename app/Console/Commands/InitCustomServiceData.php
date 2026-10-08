<?php

namespace App\Console\Commands;

use App\Modules\Setting\Models\CustomService;
use App\Modules\Setting\Models\CustomServiceItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitCustomServiceData extends Command
{
    protected $signature = 'init:custom-service-data {--force : 清空后重建}';

    protected $description = 'Seed homepage Junex Custom Service ODM/OEM columns and items';

    public function handle()
    {
        $locale = config('app.locale', 'en');
        $force = (bool)$this->option('force');

        if (!$force && CustomService::query()->exists()) {
            $this->warn('Custom services already exist. Use --force to rebuild.');
            return 0;
        }

        DB::transaction(function () use ($locale, $force) {
            if ($force) {
                CustomServiceItem::query()->delete();
                CustomService::query()->delete();
            }

            $odm = CustomService::create([
                'code' => 'odm',
                'bg_image' => 'front/imgs/index_jcs_l_bg.png',
                'layout' => 'grid',
                'sort' => 20,
                'active' => 1,
                $locale => [
                    'title_prefix' => 'ODM',
                    'title_suffix' => '- Print Your Own Brand',
                    'subtitle' => 'In-Stock Products',
                ],
            ]);

            $odmItems = [
                ['path' => 'front/imgs/jcss01.png', 'title' => 'Custom Logo', 'sort' => 60],
                ['path' => 'front/imgs/jcss02.png', 'title' => 'Heat Transfer Wash Label', 'sort' => 50],
                ['path' => 'front/imgs/jcss03.png', 'title' => 'Stickers', 'sort' => 40],
                ['path' => 'front/imgs/jcss04.png', 'title' => 'Hang Tags', 'sort' => 30],
                ['path' => 'front/imgs/jcss05.png', 'title' => 'Sewn Wash Label', 'sort' => 20],
                ['path' => 'front/imgs/jcss06.png', 'title' => 'Packaging Bags', 'sort' => 10],
            ];
            foreach ($odmItems as $row) {
                CustomServiceItem::create([
                    'custom_service_id' => $odm->id,
                    'path' => $row['path'],
                    'url' => '#',
                    'sort' => $row['sort'],
                    'active' => 1,
                    $locale => ['title' => $row['title']],
                ]);
            }

            $oem = CustomService::create([
                'code' => 'oem',
                'bg_image' => 'front/imgs/index_jcs_r_bg.png',
                'layout' => 'list',
                'sort' => 10,
                'active' => 1,
                $locale => [
                    'title_prefix' => 'OEM',
                    'title_suffix' => '- Fully Designed By You',
                    'subtitle' => 'Custom Make Products',
                ],
            ]);

            $oemItems = [
                ['path' => 'front/imgs/jcsl01.png', 'title' => 'Custom By Design/Sample', 'sort' => 30],
                ['path' => 'front/imgs/jcsl02.png', 'title' => 'Customized Craftsmanship', 'sort' => 20],
                ['path' => 'front/imgs/jcsl03.png', 'title' => 'Fabric Customization', 'sort' => 10],
            ];
            foreach ($oemItems as $row) {
                CustomServiceItem::create([
                    'custom_service_id' => $oem->id,
                    'path' => $row['path'],
                    'url' => '#',
                    'sort' => $row['sort'],
                    'active' => 1,
                    $locale => ['title' => $row['title']],
                ]);
            }
        });

        $this->info('Custom Service data seeded: ODM(6) + OEM(3).');
        return 0;
    }
}
