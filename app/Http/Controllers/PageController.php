<?php

namespace App\Http\Controllers;

use App\Modules\Page\Models\Page;
use App\Modules\Url\Models\Url;
use App\Services\SeoTemplateService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request)
    {
        $page = Url::getUrlableOrFail();

        if (!($page instanceof Page)) {
            abort(404);
        }

        // Same path as routes/web.php → prefer dedicated front controller/view
        $dedicated = front_dispatch_dedicated_route($page->url_key ?? '');
        if ($dedicated !== null) {
            return $dedicated;
        }

        $injectToView = (bool)$request->get('inject', true);

        $page->load(['translations', 'pageFiles']);

        $pageBanner = $this->getBannersByArea('Common');

        $pageName = (string)($page->name ?? '');
        $createdLabel = '';
        if ($page->created_at) {
            $createdLabel = date('F Y', strtotime($page->created_at));
        }

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => $pageName, 'url' => null],
        ]);

        $pageContent = front_html_prefer_webp((string)($page->content ?? ''));

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getPage($page), $setting);

        $data = [
            'page' => $page,
            'pageName' => $pageName,
            'createdLabel' => $createdLabel,
            'pageContent' => $pageContent,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.page', $data);
    }
}
