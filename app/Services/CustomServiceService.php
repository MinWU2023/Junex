<?php

namespace App\Services;

use App\Modules\Setting\Models\CustomService;

class CustomServiceService
{
    public const DEFAULT_SECTION_BG = 'front/imgs/index_jcs_bg.png';

    /**
     * 前台定制服务板块数据（一级列 + 二级卡片）
     */
    public function getForFront(): array
    {
        $columns = CustomService::query()
            ->active()
            ->with([
                'translations',
                'activeItems.translations',
            ])
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        $list = [];
        foreach ($columns as $column) {
            $items = [];
            foreach ($column->activeItems as $item) {
                $items[] = [
                    'title' => translated_attr($item, 'title'),
                    'url' => (string)($item->url ?: '#'),
                    'image_url' => front_image_url($item->path),
                ];
            }

            $list[] = [
                'code' => (string)$column->code,
                'layout' => (string)($column->layout ?: 'grid'),
                'bg_image_url' => front_image_url($column->bg_image),
                'title_prefix' => translated_attr($column, 'title_prefix'),
                'title_suffix' => translated_attr($column, 'title_suffix'),
                'subtitle' => translated_attr($column, 'subtitle'),
                'items' => $items,
            ];
        }

        return [
            'bg_image_url' => front_image_url(self::DEFAULT_SECTION_BG),
            'section' => section_title('custom_serrvices'),
            'columns' => $list,
        ];
    }
}
