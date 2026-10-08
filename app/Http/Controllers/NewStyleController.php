<?php

namespace App\Http\Controllers;

use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;

class NewStyleController extends Controller
{
    public function index(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);

        $perPage = (int)$request->get('per_page', 36);
        if ($perPage <= 0) {
            $perPage = 36;
        }
        if ($perPage > 60) {
            $perPage = 60;
        }

        $query = Product::query()
            ->with(['translations', 'productMainImage', 'url', 'scheduledPublish'])
            ->active();

        $query->leftJoin('product_scheduled_publishes as psp', 'psp.product_id', '=', 'products.id')
            ->select('products.*')
            ->orderByRaw('COALESCE(psp.publish_at, products.updated_at) DESC')
            ->orderByDesc('products.id');

        $products = $query->paginate($perPage)->appends($request->query());

        $noImage = 'https://placehold.co/640x640?text=No+Image';
        $productsData = $products->getCollection()->map(function ($p) use ($noImage) {
            $img = $p->productMainImage ? (string)($p->productMainImage->path ?? '') : '';
            $img = $img !== '' ? front_webp_url($img) : $noImage;
            if ($img === '') {
                $img = $noImage;
            }
            $imageAlt = $p->productMainImage ? (string)($p->productMainImage->alt ?? '') : '';

            $publishAt = null;
            if (isset($p->scheduledPublish) && $p->scheduledPublish && $p->scheduledPublish->publish_at) {
                $publishAt = $p->scheduledPublish->publish_at->format('Y-m-d H:i:s');
            } elseif (!empty($p->updated_at)) {
                try {
                    $publishAt = $p->updated_at->format('Y-m-d H:i:s');
                } catch (\Throwable $e) {
                    $publishAt = (string)$p->updated_at;
                }
            }

            return [
                'id' => $p->id,
                'name' => (string)($p->name ?? ''),
                'image' => $img,
                'alt' => resolve_product_image_alt($imageAlt, (string)($p->img_alt ?? ''), (string)($p->name ?? '')),
                'url' => $p->url ? ('/' . $p->url->url) : 'javascript:void(0);',
                'publish_at' => $publishAt,
            ];
        })->toArray();

        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Product');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'newstyle');

        $data = [
            'injectToView' => $injectToView,
            'products' => $products,
            'productsData' => $productsData,
            'pageBanner' => $pageBanner,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.newstyle', $data);
    }
}
