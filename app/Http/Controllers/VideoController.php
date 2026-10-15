<?php

namespace App\Http\Controllers;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductVideo;
use App\Modules\Product\Models\ProductVideoCategory;
use App\Modules\Url\Models\Url;
use App\Services\SeoTemplateService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private static function formatVideoDate($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        try {
            return \Illuminate\Support\Carbon::parse($value)->format('F d, Y');
        } catch (\Throwable $e) {
            return is_string($value) ? $value : '';
        }
    }

    private static function mapVideoListItem(ProductVideo $video, string $fallbackImage): array
    {
        $rawContent = translated_attr($video, 'content');
        $excerpt = trim(preg_replace('/\s+/', ' ', strip_tags($rawContent)));
        if (mb_strlen($excerpt) > 160) {
            $excerpt = mb_substr($excerpt, 0, 160) . '...';
        }

        $videoUrl = (string)($video->video_url ?? '');
        $img = front_video_cover_url($video->path ?? '', $videoUrl, $fallbackImage);

        $url = $video->url
            ? ('/' . ltrim($video->url->url, '/'))
            : null;
        if (!$url) {
            $key = ltrim((string)($video->url_key ?: $video->id), '/');
            $prefix = trim((string)config('url.product_video', 'video/'), '/');
            if ($prefix !== '' && str_starts_with($key, $prefix . '/')) {
                $key = substr($key, strlen($prefix) + 1);
            }
            $url = '/video/' . ltrim($key, '/');
        }

        return [
            'id' => $video->id,
            'date' => self::formatVideoDate($video->updated_at ?? null),
            'title' => translated_attr($video, 'name'),
            'excerpt' => $excerpt,
            'image' => $img,
            'url' => $url,
            'video_url' => $videoUrl,
        ];
    }

    public function index(Request $request)
    {
        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);
        $pageBanner = $this->getBannersByArea('Video');

        $videos = ProductVideo::query()
            ->with(['translations', 'url', 'category.translations'])
            ->active()
            ->orderByDesc('sort')
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

        $fallbackItemImage = '/front/imgs/video-item.png';

        $videosListData = $videos->getCollection()->map(function ($v) use ($fallbackItemImage) {
            return self::mapVideoListItem($v, $fallbackItemImage);
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'videos', (new SeoTemplateService())->getVideos());

        $data = [
            'videos' => $videos,
            'videosListData' => $videosListData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => __('Home'), 'url' => '/'],
                ['label' => __('Videos'), 'url' => null],
            ]),
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.videos', $data);
    }

    public function show(Request $request, $slug = null)
    {
        $video = null;

        if ($slug !== null && $slug !== '') {
            $slug = trim((string)$slug, '/');
            $prefix = trim((string)config('url.product_video', 'video/'), '/');
            $candidates = array_values(array_unique(array_filter([
                $slug,
                $prefix !== '' ? ($prefix . '/' . $slug) : null,
                preg_replace('#^' . preg_quote($prefix, '#') . '/#i', '', $slug),
            ])));

            $video = ProductVideo::query()
            ->with(['translations', 'url', 'category.translations', 'products.translations', 'products.url', 'products.productMainImage'])
            ->active()
            ->where(function ($q) use ($candidates, $slug) {
                $q->whereIn('url_key', $candidates);
                if (is_numeric($slug)) {
                    $q->orWhere('id', (int)$slug);
                }
            })
            ->first();
        }

        if (!$video) {
            $video = Url::getUrlableOrFail();
            if (!($video instanceof ProductVideo)) {
                abort(404);
            }
        }

        $injectToView = (bool)$request->get('inject', true);
        $pageBanner = $this->getBannersByArea('Video');

        $video->load(['translations', 'url', 'category.translations', 'products.translations', 'products.url', 'products.productMainImage']);

        $detailUrl = $video->url
            ? ('/' . ltrim($video->url->url, '/'))
            : ('/video/' . ltrim((string)($video->url_key ?: $video->id), '/'));

        $videoTitle = translated_attr($video, 'name');
        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => __('Home'), 'url' => '/'],
            ['label' => __('Videos'), 'url' => '/videos'],
            ['label' => $videoTitle, 'url' => null],
        ]);

        $prevVideo = ProductVideo::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('id', '<', $video->id)
            ->orderByDesc('id')
            ->first();

        $nextVideo = ProductVideo::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('id', '>', $video->id)
            ->orderBy('id')
            ->first();

        $latestVideos = ProductVideo::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('id', '!=', $video->id)
            ->orderByDesc('sort')
            ->orderByDesc('updated_at')
            ->limit(8)
            ->get();

        $formatVideoLink = static function (?ProductVideo $v, string $fallbackImage): ?array {
            if (!$v) {
                return null;
            }
            return self::mapVideoListItem($v, $fallbackImage);
        };

        $fallbackThumb = '/front/imgs/video-item.png';
        $videoUrl = (string)($video->video_url ?? '');
        $videoCover = front_video_cover_url($video->path ?? '', $videoUrl, $fallbackThumb);

        $relatedProductsData = $video->products->map(static function (Product $p) {
            $img = $p->productMainImage ? (string)($p->productMainImage->path ?? '') : '';
            if ($img !== '' && !str_starts_with($img, 'http') && !str_starts_with($img, '/')) {
                $img = '/' . ltrim($img, '/');
            }
            return [
                'id' => $p->id,
                'name' => translated_attr($p, 'name'),
                'image' => $img,
                'url' => $p->url ? ('/' . ltrim($p->url->url, '/')) : 'javascript:void(0);',
            ];
        })->values()->toArray();

        $latestVideosData = $latestVideos->map(function ($v) use ($formatVideoLink, $fallbackThumb) {
            return $formatVideoLink($v, $fallbackThumb);
        })->filter()->values()->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getVideo($video), $setting);

        $data = [
            'video' => $video,
            'videoTitle' => $videoTitle,
            'videoDate' => self::formatVideoDate($video->updated_at ?? null),
            'videoCover' => $videoCover,
            'videoUrl' => $videoUrl,
            'videoIntroHtml' => front_html_prefer_webp(translated_attr($video, 'content')),
            'videoDetailHtml' => front_html_prefer_webp(translated_attr($video, 'content2')),
            'videoDetailUrl' => $detailUrl,
            'prevVideoData' => $formatVideoLink($prevVideo, $fallbackThumb),
            'nextVideoData' => $formatVideoLink($nextVideo, $fallbackThumb),
            'latestVideosData' => $latestVideosData,
            'relatedProductsData' => $relatedProductsData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.video', $data);
    }

    public function category(Request $request)
    {
        $category = Url::getUrlableOrFail();

        if (!($category instanceof ProductVideoCategory)) {
            abort(404);
        }

        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);
        $pageBanner = $this->getBannersByArea('Video');

        $category->load(['translations']);

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => __('Home'), 'url' => '/'],
            ['label' => __('Videos'), 'url' => '/videos'],
            ['label' => translated_attr($category, 'name'), 'url' => null],
        ]);

        $videos = ProductVideo::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('product_video_category_id', $category->id)
            ->orderByDesc('sort')
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

        $fallbackFeaturedImage = '/front/imgs/video-item.png';
        $fallbackItemImage = '/front/imgs/video-item.png';

        $collection = $videos->getCollection();
        $featured = $collection->first();
        $featuredVideo = $featured ? self::mapVideoListItem($featured, $fallbackFeaturedImage) : null;
        $videosListData = $collection->slice($featured ? 1 : 0)->values()->map(function ($v) use ($fallbackItemImage) {
            return self::mapVideoListItem($v, $fallbackItemImage);
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getVideoCategory($category), $setting);

        $data = [
            'category' => $category,
            'videos' => $videos,
            'featuredVideo' => $featuredVideo,
            'videosListData' => $videosListData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.video-category', $data);
    }
}
