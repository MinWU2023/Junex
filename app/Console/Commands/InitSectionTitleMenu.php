<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use App\Modules\Setting\Models\WhyChooseSetting;
use App\Services\SectionTitleService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class InitSectionTitleMenu extends Command
{
    protected $signature = 'init:section-title';

    protected $description = 'Initialize Section Titles menu, permissions and default rows';

    public function handle(SectionTitleService $sectionTitleService)
    {
        $this->info('Initializing Section Title Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        // Prefer the nested「数据管理」under「内容相关」(same group as brand solutions)
        $parentMenu = Menu::query()
            ->where('name', '数据管理')
            ->where('parent_id', '>', 0)
            ->orderByDesc('id')
            ->first();

        if (!$parentMenu) {
            $brandMenu = Menu::query()->where('route', 'admin.brandSolution.index')->first();
            if ($brandMenu && $brandMenu->parent_id) {
                $parentMenu = Menu::query()->find($brandMenu->parent_id);
            }
        }

        if (!$parentMenu) {
            $parentMenu = Menu::query()->where('name', '数据管理')->where('parent_id', 0)->first();
        }

        if (!$parentMenu) {
            $this->error("Parent menu '数据管理' not found.");
            return 1;
        }

        $route = 'admin.sectionTitle.index';
        $menuName = '板块标题';

        $menu = Menu::query()->where('route', $route)->first();
        if (!$menu) {
            Menu::query()->create([
                'parent_id' => $parentMenu->id,
                'name' => $menuName,
                'route' => $route,
                'sort' => 70,
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            $this->info("Menu '{$menuName}' created under '{$parentMenu->name}'(#{$parentMenu->id}).");
        } else {
            $menu->parent_id = $parentMenu->id;
            if ((int)$menu->sort === 0) {
                $menu->sort = 70;
            }
            $menu->save();
            $this->info("Menu '{$menuName}' moved under '{$parentMenu->name}'(#{$parentMenu->id}).");
        }

        $groupName = '板块标题';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.sectionTitle.index' => '板块标题列表',
            'admin.sectionTitle.edit' => '板块标题编辑页面',
            'admin.sectionTitle.update' => '板块标题编辑',
        ];

        foreach ($permissions as $name => $displayName) {
            $permission = Permission::query()->where('name', $name)->first();
            if (!$permission) {
                Permission::query()->create([
                    'name' => $name,
                    'display_name' => $displayName,
                    'guard_name' => 'web',
                    'pg_id' => $group->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                $this->info("Permission '{$name}' created.");
            } else {
                $this->warn("Permission '{$name}' already exists.");
            }
        }

        $role = Role::where('name', '超级管理员')->first();
        if ($role) {
            $role->givePermissionTo(array_keys($permissions));
            $this->info("Permissions assigned to '超级管理员' role.");
        }

        $sectionTitleService->seedDefaults();
        $this->migrateWhyChooseSectionTexts($sectionTitleService);
        $this->info('Default section title rows ready.');

        $this->info('Initialization complete!');
        return 0;
    }

    protected function migrateWhyChooseSectionTexts(SectionTitleService $sectionTitleService): void
    {
        try {
            if (!Schema::hasTable('why_choose_setting_translations')
                || !Schema::hasColumn('why_choose_setting_translations', 'section_title')) {
                return;
            }

            $setting = WhyChooseSetting::query()->with(['translations'])->orderBy('id')->first();
            if (!$setting) {
                return;
            }

            $section = \App\Modules\Setting\Models\SectionTitle::query()
                ->where('sign', 'why_choose')
                ->first();
            if (!$section) {
                return;
            }

            foreach ($setting->translations as $tr) {
                $locale = (string)$tr->locale;
                $title = trim((string)($tr->section_title ?? ''));
                $subtitle = trim((string)($tr->section_description ?? ''));
                if ($title === '' && $subtitle === '') {
                    continue;
                }

                $payload = [];
                if ($title !== '') {
                    $payload['title'] = $title;
                }
                if ($subtitle !== '') {
                    $payload['subtitle'] = $subtitle;
                }
                if (!empty($payload)) {
                    $section->fill([$locale => $payload]);
                }
            }
            $section->save();
            $this->info('Migrated Why Choose section title/description into 板块标题.');
        } catch (\Throwable $e) {
            $this->warn('Skip Why Choose title migration: ' . $e->getMessage());
        }
    }
}
