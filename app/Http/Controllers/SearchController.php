<?php

namespace App\Http\Controllers;

use App\Modules\Product\Models\Product;
use App\Services\WhyChooseService;
// use App\Modules\User\Models\SearchKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request, WhyChooseService $whyChooseService)
    {
        $keyword = trim((string)$request->get('q', ''));
        if ($keyword === '') {
            $keyword = trim((string)$request->get('keywords', ''));
        }
        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Product');

        if ($keyword === '') {
            $products = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->orderByDesc('updated_at')
                ->paginate($perPage)
                ->appends($request->query());
        } else {
            // $searchKeyword = SearchKeyword::query()->where('keywords', $keyword)->first();
            // if ($searchKeyword) {
            //     $searchKeyword->increment('search_times');
            // } else {
            //     SearchKeyword::query()->create([
            //         'keywords' => $keyword,
            //         'search_times' => 1,
            //     ]);
            // }

            $products = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->whereTranslationLike('name', '%' . $keyword . '%')
                ->orderByDesc('updated_at')
                ->paginate($perPage)
                ->appends($request->query());
        }

        $customer = $this->getCustomerByIp($request->ip());
        $favoritedProductIds = [];
        if ($customer) {
            $favoritedProductIds = DB::table('customer_prefers')
                ->where('customer_id', $customer->id)
                ->pluck('product_id')
                ->toArray();
        }

        $productsData = $products->getCollection()->map(function ($p) use ($favoritedProductIds) {
            $img = $p->productMainImage ? (string)($p->productMainImage->path ?? '') : '';
            $img = $img !== '' ? front_webp_url($img) : '';
            return [
                'id' => $p->id,
                'name' => (string)($p->name ?? ''),
                'image' => $img,
                'url' => $p->url ? ('/' . ltrim($p->url->url, '/')) : 'javascript:void(0);',
                'model' => (string)($p->url_key ?? ''),
                'item_no' => (string)($p->url_key ?? ''),
                'is_favorited' => in_array($p->id, $favoritedProductIds),
            ];
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'search');

        $data = [
            'q' => $keyword,
            'products' => $products,
            'productsData' => $productsData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Products', 'url' => '/products'],
                ['label' => 'Search By : ' . ($keyword !== '' ? $keyword : ''), 'url' => null],
            ]),
            'injectToView' => $injectToView,
            'tdk' => $tdk,
            'customerId' => $customer ? $customer->id : 0,
        ];

        $data['whyChoose'] = $whyChooseService->getWhyChoose();

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.search', $data);
    }
}
