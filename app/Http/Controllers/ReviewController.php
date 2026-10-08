<?php

namespace App\Http\Controllers;

use App\Modules\User\Models\CustomerReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Reviews');

        $reviews = CustomerReview::query()
            ->with(['translations'])
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->query());

        $reviewsItems = $reviews->getCollection()->map(function (CustomerReview $r) {
            $username = (string)($r->username ?? '');
            $initial = $username !== '' ? mb_strtoupper(mb_substr($username, 0, 1)) : '';
            $imgs = is_array($r->imgs) ? $r->imgs : [];
            $imgs = array_values(array_filter(array_map(function ($v) {
                if (!is_string($v)) {
                    return '';
                }
                $v = trim($v);
                return $v !== '' ? front_webp_url($v) : '';
            }, $imgs)));

            return [
                'id' => (int)$r->id,
                'username' => $username,
                'initial' => $initial,
                'score' => (int)($r->score ?? 0),
                'subject' => (string)($r->subject ?? ''),
                'content' => (string)($r->content ?? ''),
                'imgs' => $imgs,
            ];
        })->values()->toArray();

        $reviewsColumns = [[], []];
        foreach ($reviewsItems as $i => $item) {
            $reviewsColumns[$i % 2][] = $item;
        }

        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'reviews');

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Reviews', 'url' => null],
        ]);

        $data = [
            'reviews' => $reviews,
            'reviewsItems' => $reviewsItems,
            'reviewsColumns' => $reviewsColumns,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
            'tdk' => $tdk,
            'injectToView' => $injectToView,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.reviews', $data);
    }
}
