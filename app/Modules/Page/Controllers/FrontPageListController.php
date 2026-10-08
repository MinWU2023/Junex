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

        if (!in_array($field, ['sitemap_on', 'access_on'], true) || !$request->exists('path')) {
            return back()->with('error', '参数错误');
        }

        $catalog->setFlags([$path], $field, $value);

        return back()->with('success', '已更新');
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
