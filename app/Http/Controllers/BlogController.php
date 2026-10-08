<?php

namespace App\Http\Controllers;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Product\Models\ProductVideo;
use App\Services\SeoTemplateService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Blog 模型使用 Time trait，updated_at/created_at 访问器返回的是字符串，
     * 不能直接 ->format()，必须先 Carbon::parse。
     */
    private static function formatBlogDate($value): string
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

    private static function mapBlogListItem($blog, string $fallbackImage): array
    {
        $dateValue = !empty($blog->customer_at) ? $blog->customer_at : ($blog->updated_at ?? null);

        $rawContent = (string)($blog->content ?? '');
        $excerpt = trim(preg_replace('/\s+/', ' ', strip_tags($rawContent)));
        if (mb_strlen($excerpt) > 160) {
            $excerpt = mb_substr($excerpt, 0, 160) . '...';
        }

        $img = $blog->path
            ? front_webp_url($blog->path)
            : front_webp_url($fallbackImage);
        if ($img === '') {
            $img = front_webp_url($fallbackImage);
        }
        $url = $blog->url ? ('/' . $blog->url->url) : 'javascript:void(0);';

        return [
            'id' => $blog->id,
            'date' => self::formatBlogDate($dateValue),
            'title' => (string)($blog->name ?? ''),
            'excerpt' => $excerpt,
            'image' => $img,
            'url' => $url,
        ];
    }

    public function index(Request $request)
    {
        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Blog');

        $blogs = Blog::query()
            ->with(['translations', 'url'])
            ->active()
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

        // Product Videos：显示最新发布的 6 个启用视频
        $productVideos = ProductVideo::query()
            ->with(['translations'])
            ->active()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $blogsCollection = $blogs->getCollection();
        $featured = $blogsCollection->first();
        $fallbackFeaturedImage = 'https://placehold.co/227x249?text=No+Image';
        $fallbackBlogItemImage = 'https://placehold.co/227x249?text=No+Image';

        $featuredBlog = $featured ? self::mapBlogListItem($featured, $fallbackFeaturedImage) : null;
        $blogsListData = $blogsCollection->slice($featured ? 1 : 0)->values()->map(function ($b) use ($fallbackBlogItemImage) {
            return self::mapBlogListItem($b, $fallbackBlogItemImage);
        })->toArray();

        $productVideosData = $productVideos->map(function ($v) {
            $videoUrl = (string)($v->video_url ?? '');
            $img = front_video_cover_url($v->path ?? '', $videoUrl, '/front/imgs/video-item.png');
            return [
                'id' => $v->id,
                'title' => (string)($v->name ?? ''),
                'image' => $img,
                'video_url' => $videoUrl,
            ];
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'blogs', (new SeoTemplateService())->getBlogs());

        $data = [
            'blogs' => $blogs,
            'featuredBlog' => $featuredBlog,
            'blogsListData' => $blogsListData,
            'productVideos' => $productVideos,
            'productVideosData' => $productVideosData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Blogs', 'url' => null],
            ]),
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }
        return view('front.blogs', $data);
    }

    public function show(Request $request)
    {
        $blog = \App\Modules\Url\Models\Url::getUrlableOrFail();

        if (!($blog instanceof Blog)) {
            abort(404);
        }

        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Blog');

        $blog->load(['translations', 'blogTags.translations', 'blogTags.url', 'url']);

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Blogs', 'url' => '/blogs'],
            ['label' => $blog->name, 'url' => null],
        ]);

        $prevBlog = Blog::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('id', '<', $blog->id)
            ->orderByDesc('id')
            ->first();

        $nextBlog = Blog::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('id', '>', $blog->id)
            ->orderBy('id')
            ->first();

        $latestBlogs = Blog::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('updated_at')
            ->limit(8)
            ->get();

        $hotTags = BlogTag::query()
            ->with(['translations', 'url'])
            ->select('blog_tags.*')
            ->join('blog_blog_tag', 'blog_blog_tag.blog_tag_id', '=', 'blog_tags.id')
            ->groupBy('blog_tags.id')
            ->orderByDesc(DB::raw('count(blog_blog_tag.blog_id)'))
            ->limit(6)
            ->get();

        $blogTags = $blog->blogTags;

        $fallbackCover = 'https://placehold.co/1200x680?text=No+Image';
        $fallbackThumb = 'https://placehold.co/200x200?text=No+Image';

        $getBlogDate = static function (Blog $b): string {
            $date = !empty($b->customer_at) ? $b->customer_at : $b->updated_at;
            return self::formatBlogDate($date);
        };

        $formatBlogLink = static function (?Blog $b, string $fallbackImage) use ($getBlogDate): ?array {
            if (!$b) {
                return null;
            }
            $img = $b->path
                ? front_webp_url($b->path)
                : front_webp_url($fallbackImage);
            if ($img === '') {
                $img = front_webp_url($fallbackImage);
            }
            $url = $b->url ? ('/' . ltrim($b->url->url, '/')) : null;
            return [
                'id' => $b->id,
                'date' => $getBlogDate($b),
                'title' => (string)($b->name ?? ''),
                'image' => $img,
                'url' => $url,
            ];
        };

        $blogDate = $getBlogDate($blog);
        $blogTitle = (string)($blog->name ?? '');
        $blogContent = front_html_prefer_webp((string)($blog->content ?? ''));
        $blogCover = $blog->path
            ? front_webp_url($blog->path)
            : front_webp_url($fallbackCover);
        if ($blogCover === '') {
            $blogCover = front_webp_url($fallbackCover);
        }

        $latestBlogsData = $latestBlogs->map(function (Blog $b) use ($formatBlogLink, $fallbackThumb) {
            return $formatBlogLink($b, $fallbackThumb);
        })->filter()->values()->toArray();

        $prevBlogData = $formatBlogLink($prevBlog, $fallbackThumb);
        $nextBlogData = $formatBlogLink($nextBlog, $fallbackThumb);

        $blogTagsData = $blogTags->map(function (BlogTag $t) {
            $url = $t->url ? ('/' . ltrim($t->url->url, '/')) : null;
            return [
                'id' => $t->id,
                'name' => (string)($t->name ?? ''),
                'url' => $url,
            ];
        })->filter(function ($t) {
            return !empty($t['name']);
        })->values()->toArray();

        $hotTagsData = $hotTags->map(function (BlogTag $t) {
            $url = $t->url ? ('/' . ltrim($t->url->url, '/')) : null;
            return [
                'id' => $t->id,
                'name' => (string)($t->name ?? ''),
                'url' => $url,
            ];
        })->filter(function ($t) {
            return !empty($t['name']);
        })->values()->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getBlog($blog), $setting);

        $data = [
            'blog' => $blog,
            'blogDate' => $blogDate,
            'blogTitle' => $blogTitle,
            'blogContent' => $blogContent,
            'blogCover' => $blogCover,
            'prevBlogData' => $prevBlogData,
            'nextBlogData' => $nextBlogData,
            'latestBlogsData' => $latestBlogsData,
            'hotTagsData' => $hotTagsData,
            'blogTagsData' => $blogTagsData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.blog', $data);
    }

    public function category(Request $request)
    {
        $category = \App\Modules\Url\Models\Url::getUrlableOrFail();

        if (!($category instanceof BlogCategory)) {
            abort(404);
        }

        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Blog');

        $category->load(['translations']);

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Blogs', 'url' => '/blogs'],
            ['label' => $category->name, 'url' => null],
        ]);

        $blogs = Blog::query()
            ->with(['translations', 'url'])
            ->active()
            ->where('blog_category_id', $category->id)
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

        $productVideos = ProductVideo::query()
            ->with(['translations'])
            ->active()
            ->where('is_recommend', 1)
            ->orderByDesc('sort')
            ->limit(8)
            ->get();

        $blogsCollection = $blogs->getCollection();
        $featured = $blogsCollection->first();
        $fallbackFeaturedImage = 'https://placehold.co/227x249?text=No+Image';
        $fallbackBlogItemImage = 'https://placehold.co/227x249?text=No+Image';

        $featuredBlog = $featured ? self::mapBlogListItem($featured, $fallbackFeaturedImage) : null;
        $blogsListData = $blogsCollection->slice($featured ? 1 : 0)->values()->map(function ($b) use ($fallbackBlogItemImage) {
            return self::mapBlogListItem($b, $fallbackBlogItemImage);
        })->toArray();

        $productVideosData = $productVideos->map(function ($v) {
            $videoUrl = (string)($v->video_url ?? '');
            $img = front_video_cover_url($v->path ?? '', $videoUrl, '/front/imgs/video-item.png');
            return [
                'id' => $v->id,
                'title' => (string)($v->name ?? ''),
                'image' => $img,
                'video_url' => $videoUrl,
            ];
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getBlogCategory($category), $setting);

        $data = [
            'category' => $category,
            'blogs' => $blogs,
            'featuredBlog' => $featuredBlog,
            'blogsListData' => $blogsListData,
            'pageBanner' => $pageBanner,
            'productVideos' => $productVideos,
            'productVideosData' => $productVideosData,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.blog-category', $data);
    }

    public function tag(Request $request)
    {
        $tag = \App\Modules\Url\Models\Url::getUrlableOrFail();

        if (!($tag instanceof BlogTag)) {
            abort(404);
        }

        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Blog');

        $tag->load(['translations']);

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Blogs', 'url' => '/blogs'],
            ['label' => $tag->name, 'url' => null],
        ]);

        $blogs = $tag->blogs()
            ->with(['translations', 'url'])
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

        $productVideos = ProductVideo::query()
            ->with(['translations'])
            ->active()
            ->where('is_recommend', 1)
            ->orderByDesc('sort')
            ->limit(8)
            ->get();

        $blogsCollection = $blogs->getCollection();
        $featured = $blogsCollection->first();
        $fallbackFeaturedImage = 'https://placehold.co/227x249?text=No+Image';
        $fallbackBlogItemImage = 'https://placehold.co/227x249?text=No+Image';

        $featuredBlog = $featured ? self::mapBlogListItem($featured, $fallbackFeaturedImage) : null;
        $blogsListData = $blogsCollection->slice($featured ? 1 : 0)->values()->map(function ($b) use ($fallbackBlogItemImage) {
            return self::mapBlogListItem($b, $fallbackBlogItemImage);
        })->toArray();

        $productVideosData = $productVideos->map(function ($v) {
            $videoUrl = (string)($v->video_url ?? '');
            $img = front_video_cover_url($v->path ?? '', $videoUrl, '/front/imgs/video-item.png');
            return [
                'id' => $v->id,
                'title' => (string)($v->name ?? ''),
                'image' => $img,
                'video_url' => $videoUrl,
            ];
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getBlogTag($tag), $setting);

        $data = [
            'tag' => $tag,
            'blogs' => $blogs,
            'pageBanner' => $pageBanner,
            'featuredBlog' => $featuredBlog,
            'blogsListData' => $blogsListData,
            'productVideos' => $productVideos,
            'productVideosData' => $productVideosData,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.blog-tag', $data);
    }
}
