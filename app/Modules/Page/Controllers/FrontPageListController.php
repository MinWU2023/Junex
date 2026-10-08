<?php

namespace App\Modules\Page\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Services\FrontPageCatalogService;
use Illuminate\Http\Request;

class FrontPageListController extends BaseController
{
    public function index()
    {
        $request = request();
        /** @var FrontPageCatalogService $catalog */
        $catalog = app(FrontPageCatalogService::class);

        $tabs = $catalog->tabs();
        $tab = (string)$request->get('tab', 'all');
        if (!isset($tabs[$tab])) {
            $tab = 'all';
        }
        $keyword = trim((string)$request->get('keyword', ''));
        $page = max(1, (int)$request->get('page', 1));
        $items = $catalog->paginate($tab, $keyword, $page, 15);
        $items->appends(['tab' => $tab, 'keyword' => $keyword]);

        return view('Page.Views.frontPageList.index', compact('tabs', 'tab', 'keyword', 'items'));
    }

    public function batch(Request $request, FrontPageCatalogService $catalog)
    {
        $action = (string)$request->get('batch_action', '');
        $paths = $request->get('paths', []);
        if (!is_array($paths)) {
            $paths = [];
        }

        $map = [
            'sitemap_on' => ['sitemap_on', true],
            'sitemap_off' => ['sitemap_on', false],
            'access_on' => ['access_on', true],
            'access_off' => ['access_on', false],
        ];

        if (!isset($map[$action])) {
            return back()->with('error', '请选择批量操作');
        }
        if ($paths === []) {
            return back()->with('error', '请先勾选页面');
        }

        [$field, $value] = $map[$action];
        $count = $catalog->setFlags($paths, $field, $value);

        return back()->with('success', '已更新 ' . $count . ' 条');
    }

    public function toggle(Request $request, FrontPageCatalogService $catalog)
    {
        $field = (string)$request->get('field', '');
        $path = (string)$request->get('path', '');
        $value = (int)$request->get('value', 0) === 1;

        // 兼容：不依赖前端 JS，直接解析 toggle_payload=field|value|path
        $payload = (string)$request->get('toggle_payload', '');
        if ($payload !== '' && str_contains($payload, '|')) {
            $parts = explode('|', $payload, 3);
            $field = (string)($parts[0] ?? $field);
            $value = (int)($parts[1] ?? 0) === 1;
            $path = (string)($parts[2] ?? $path);
        }

        if (!in_array($field, ['sitemap_on', 'access_on'], true)) {
            return back()->with('error', '参数错误');
        }
        // path 允许空串（首页），但不能缺省参数
        if (!$request->exists('path') && !$request->exists('toggle_payload')) {
            return back()->with('error', '参数错误');
        }

        $count = $catalog->setFlags([$path === '' ? '/' : $path], $field, $value);
        if ($count < 1) {
            return back()->with('error', '更新失败，未找到对应页面记录');
        }

        $label = $field === 'access_on'
            ? ($value ? '已开启访问' : '已关闭访问')
            : ($value ? '已开启 sitemap' : '已关闭 sitemap');

        return back()->with('success', $label);
    }

    public function sitemap(FrontPageCatalogService $catalog)
    {
        try {
            $count = $catalog->generateSitemap();
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'sitemap 已生成，共 ' . $count . ' 条开启的链接');
    }
}
