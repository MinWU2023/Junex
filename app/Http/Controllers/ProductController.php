<?php

namespace App\Http\Controllers;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Product\Models\ProductFaq;
use App\Modules\Url\Models\Url;
use App\Services\ProductListSidebarService;
use App\Services\WhyChooseService;
use App\Services\SeoTemplateService;
use App\Services\ProductService;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request, WhyChooseService $whyChooseService, ProductListSidebarService $sidebarService)
    {
        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Product');

        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $products = Product::query()
            ->with(['translations', 'productMainImage', 'url'])
            ->active()
            ->orderByDesc('sort')
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

        $favoritedProductIds = $sidebarService->getFavoritedProductIds($request);
        $productsData = $sidebarService->mapProducts($products->getCollection(), $favoritedProductIds);

        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'products', (new SeoTemplateService())->getProducts());

        $data = [
            'products' => $products,
            'productsData' => $productsData,
            'sidebarCategories' => $sidebarService->buildSidebarCategories(null),
            'sidebarRecommendProducts' => $sidebarService->buildRecommendProducts($favoritedProductIds),
            'activeCategoryId' => null,
            'pageBanner' => $pageBanner,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
            'customerId' => 0,
        ];

        $customer = $this->getCustomerByIp($request->ip());
        if ($customer) {
            $data['customerId'] = $customer->id;
        }

        $data['whyChoose'] = $whyChooseService->getWhyChoose();

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.products', $data);
    }

    public function category(Request $request, WhyChooseService $whyChooseService, ProductListSidebarService $sidebarService)
    {
        $category = Url::getUrlableOrFail();
        if (!($category instanceof ProductCategory)) {
            abort(404);
        }

        $injectToView = (bool)$request->get('inject', true);
        $pageBanner = $this->getBannersByArea('Product');

        $category->load(['translations', 'parent.translations', 'children.translations']);

        $pageBlockHtml = $category->resolvePageBlockHtml();

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Products', 'url' => '/products'],
            $category->parent ? ['label' => $category->parent->name, 'url' => $category->parent->url ? ('/' . $category->parent->url->url) : null] : null,
            ['label' => $category->name, 'url' => null],
        ]);

        $displayMode = $category->display_mode ?: ProductCategory::DISPLAY_PRODUCT_LIST;
        $favoritedProductIds = $sidebarService->getFavoritedProductIds($request);
        $customer = $this->getCustomerByIp($request->ip());

        $products = null;
        $productsData = [];
        $categoryProductSections = [];

        if ($displayMode === ProductCategory::DISPLAY_CATEGORY_PRODUCT) {
            $categoryProductSections = $sidebarService->buildCategoryProductSections($category, $favoritedProductIds);
        } else {
            $categoryIds = [$category->id];
            $sidebarService->collectChildCategoryIds($category->id, $categoryIds);

            $perPage = (int)$request->get('per_page', 12);
            if ($perPage <= 0) {
                $perPage = 12;
            }

            $products = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->whereHas('productCategories', function ($query) use ($categoryIds) {
                    $query->whereIn('product_category_id', $categoryIds);
                })
                ->orderByDesc('sort')
                ->orderByDesc('updated_at')
                ->paginate($perPage)
                ->appends($request->query());

            $productsData = $sidebarService->mapProducts($products->getCollection(), $favoritedProductIds);
        }

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getCategory($category), $setting);

        $data = [
            'category' => $category,
            'displayMode' => $displayMode,
            'products' => $products,
            'productsData' => $productsData,
            'categoryProductSections' => $categoryProductSections,
            'sidebarCategories' => $sidebarService->buildSidebarCategories($category),
            'sidebarRecommendProducts' => $sidebarService->buildRecommendProducts($favoritedProductIds),
            'activeCategoryId' => (int)$category->id,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
            'customerId' => $customer ? $customer->id : 0,
            'pageBlockHtml' => $pageBlockHtml,
        ];

        $data['whyChoose'] = $whyChooseService->getWhyChoose();

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.product-category', $data);
    }

    public function tag(Request $request, WhyChooseService $whyChooseService)
    {
        $tag = Url::getUrlableOrFail();

        if (!($tag instanceof ProductTag)) {
            abort(404);
        }

        $perPage = (int)$request->get('per_page', 12);
        if ($perPage <= 0) {
            $perPage = 12;
        }

        $injectToView = (bool)$request->get('inject', true);

        $tag->load(['translations']);

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Products', 'url' => '/products'],
            ['label' => $tag->name, 'url' => null],
        ]);

        $products = Product::query()
            ->with(['translations', 'productMainImage', 'url'])
            ->active()
            ->whereHas('productTags', function ($query) use ($tag) {
                $query->where('product_tag_id', $tag->id);
            })
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->appends($request->query());

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
            $imageAlt = $p->productMainImage ? (string)($p->productMainImage->alt ?? '') : '';
            return [
                'id' => $p->id,
                'name' => (string)($p->name ?? ''),
                'image' => $img,
                'alt' => resolve_product_image_alt($imageAlt, (string)($p->img_alt ?? ''), (string)($p->name ?? '')),
                'url' => $p->url ? ('/' . ltrim($p->url->url, '/')) : 'javascript:void(0);',
                'model' => (string)($p->url_key ?? ''),
                'item_no' => (string)($p->url_key ?? ''),
                'is_favorited' => in_array($p->id, $favoritedProductIds),
            ];
        })->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getTag($tag), $setting);

        $pageBanner = $this->getBannersByArea('Product');

        $data = [
            'tag' => $tag,
            'products' => $products,
            'productsData' => $productsData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
            'customerId' => $customer ? $customer->id : 0,
        ];

        $data['whyChoose'] = $whyChooseService->getWhyChoose();

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.product-tag', $data);
    }

    public function show(Request $request, ProductListSidebarService $sidebarService)
    {
        $product = Url::getUrlableOrFail();
        if (!($product instanceof Product)) {
            abort(404);
        }

        $injectToView = (bool)$request->get('inject', true);
        $product->load([
            'translations',
            'url',
            'productImages',
            'productCategory.translations',
            'productCategory.url',
            'productCategory.parent.translations',
            'productCategory.parent.url',
            'productBrand.translations',
            'productTags.translations',
            'productTags.url',
        ]);

        $category = $product->productCategory->first();
        $parentCategory = $category ? $category->parent : null;
        
        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Products', 'url' => '/products'],
            $category ? ['label' => $category->name, 'url' => $category->url ? ('/' . $category->url->url) : null] : null,
            ['label' => $product->name, 'url' => null],
        ]);

        $noImage = "https://placehold.co/640x640?text=No+Image";

        $seoImgAlt = (string)($product->img_alt ?? '');

        // 主图(is_main)优先展示，其余按 sort 降序（与后台主图设置一致）
        $productImagesData = $product->productImages
            ->sortByDesc(function ($img) {
                return sprintf('%d-%010d', (int)($img->is_main ?? 0), (int)($img->sort ?? 0));
            })
            ->values()
            ->map(function ($img) use ($noImage, $seoImgAlt, $product) {
                $path = (string)($img->path ?? '');
                $url = $path !== '' ? front_webp_url($path) : $noImage;
                if ($url === '') {
                    $url = $noImage;
                }
                return [
                    'url' => $url,
                    'alt' => resolve_product_image_alt(
                        (string)($img->alt ?? ''),
                        $seoImgAlt,
                        (string)($product->name ?? 'Product')
                    ),
                ];
            })
            ->toArray();

        if (empty($productImagesData)) {
            $productImagesData = [[
                'url' => $noImage,
                'alt' => resolve_product_image_alt('', $seoImgAlt, (string)($product->name ?? 'Product')),
            ]];
        }

        $productService = new ProductService();
        $attributesMap = $productService->getAttributes($product);

        $categoryLabel = '';
        $categoryUrl = null;
        if ($category) {
            $categoryLabel = $parentCategory ? ($parentCategory->name . ' / ' . $category->name) : (string)$category->name;
            $categoryUrl = $category->url ? ('/' . $category->url->url) : null;
        }

        // 详情页属性：Categories + 后台产品属性（多值已在 getAttributes 中用 ", " 连接）；隐藏 Item No.
        $hiddenAttrLabels = ['item no', 'item no.', 'item_no'];
        $productAttributesData = [];
        if ($categoryLabel !== '') {
            $productAttributesData[] = [
                'label' => 'Categories',
                'value' => $categoryLabel,
                'url' => $categoryUrl,
            ];
        }
        foreach ($attributesMap as $label => $value) {
            $value = trim((string)$value);
            if ($value === '') {
                continue;
            }
            $labelNorm = strtolower(trim((string)$label));
            if (in_array($labelNorm, $hiddenAttrLabels, true)) {
                continue;
            }
            $productAttributesData[] = [
                'label' => $label,
                'value' => $value,
                'url' => null,
            ];
        }

        $customer = $this->getCustomerByIp($request->ip());
        $isFavorited = false;
        if ($customer) {
            $isFavorited = DB::table('customer_prefers')
                ->where('customer_id', $customer->id)
                ->where('product_id', $product->id)
                ->exists();
        }

        $favoritedProductIds = [];
        if ($customer) {
            $favoritedProductIds = DB::table('customer_prefers')
                ->where('customer_id', $customer->id)
                ->pluck('product_id')
                ->toArray();
        }

        // Related Products：同分类 → 同父级同级 → 祖先子树 → 随机补足一页
        $relatedLimit = (int)(app('settings')['setting']->related_product_num ?? 12);
        if ($relatedLimit <= 0) {
            $relatedLimit = 12;
        }

        $recommendProductsData = $sidebarService->buildRelatedProducts(
            $product,
            $favoritedProductIds,
            $relatedLimit
        );

        $productIntroHtml = (string)($product->content ?? '');
        if (trim($productIntroHtml) === '') {
            $productIntroHtml = (string)($product->brief_content ?? '');
        }
        $productDetailsHtml = (string)($product->product_details ?? '');
        // 富文本图片无 alt 时，默认使用 SEO「产品图片标签」
        if ($seoImgAlt !== '') {
            $productIntroHtml = fill_empty_img_alts_in_html($productIntroHtml, $seoImgAlt);
            $productDetailsHtml = fill_empty_img_alts_in_html($productDetailsHtml, $seoImgAlt);
        }
        $productIntroHtml = front_html_prefer_webp($productIntroHtml);
        $productDetailsHtml = front_html_prefer_webp($productDetailsHtml);

        $productTagsData = $product->productTags
            ->filter(static fn ($tag) => trim((string)($tag->name ?? '')) !== '')
            ->map(static function ($tag) {
                $name = trim((string)($tag->name ?? ''));
                $name = \Illuminate\Support\Str::title(mb_strtolower($name, 'UTF-8'));
                return [
                    'id' => $tag->id,
                    'name' => $name,
                    'url' => $tag->url ? ('/' . ltrim((string)$tag->url->url, '/')) : 'javascript:void(0);',
                ];
            })
            ->values()
            ->toArray();

        // 产品详情 FAQ：产品自身关联 + 产品所属分类（含祖先分类）关联，按 id 去重
        $categoryIdsForFaq = $product->productCategory->pluck('id')->map(static fn ($id) => (int)$id)->all();
        $parentIds = $product->productCategory
            ->pluck('parent_id')
            ->map(static fn ($id) => (int)$id)
            ->filter(static fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();
        // 向上追溯祖先分类（通常 1～2 级；批量查询避免 N+1）
        $guard = 0;
        while (!empty($parentIds) && $guard < 10) {
            $guard++;
            $categoryIdsForFaq = array_merge($categoryIdsForFaq, $parentIds);
            $parentIds = ProductCategory::query()
                ->whereIn('id', $parentIds)
                ->pluck('parent_id')
                ->map(static fn ($id) => (int)$id)
                ->filter(static fn ($id) => $id > 0)
                ->unique()
                ->values()
                ->all();
        }
        $categoryIdsForFaq = array_values(array_unique(array_filter($categoryIdsForFaq)));

        $faqByProduct = ProductFaq::query()
            ->active()
            ->with(['translations'])
            ->whereHas('products', function ($pq) use ($product) {
                $pq->where('products.id', $product->id);
            })
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->get();

        $faqByCategory = collect();
        if (!empty($categoryIdsForFaq)) {
            $faqByCategory = ProductFaq::query()
                ->active()
                ->with(['translations'])
                ->whereHas('categories', function ($cq) use ($categoryIdsForFaq) {
                    $cq->whereIn('product_categories.id', $categoryIdsForFaq);
                })
                ->orderByDesc('sort')
                ->orderByDesc('id')
                ->get();
        }

        $productFaqsData = $faqByProduct
            ->concat($faqByCategory)
            ->unique('id')
            ->filter(static fn ($faq) => trim((string)($faq->subject ?? '')) !== '')
            ->sortByDesc(static fn ($faq) => sprintf('%010d-%010d', (int)$faq->sort, (int)$faq->id))
            ->values()
            ->map(static function ($faq) {
                return [
                    'id' => $faq->id,
                    'subject' => (string)$faq->subject,
                    'content' => (string)($faq->content ?? ''),
                ];
            })
            ->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->fillDefaultTdk((new SeoTemplateService())->getProduct($product), $setting);

        $data = [
            'product' => $product,
            'productImagesData' => $productImagesData,
            'productCategoryLabel' => $categoryLabel,
            'productCategoryUrl' => $categoryUrl,
            'productAttributesData' => $productAttributesData,
            'recommendProductsData' => $recommendProductsData,
            'sidebarCategories' => $sidebarService->buildSidebarCategories($category),
            'sidebarRecommendProducts' => $sidebarService->buildRecommendProducts($favoritedProductIds),
            'activeCategoryId' => $category ? (int)$category->id : null,
            'productTagsData' => $productTagsData,
            'productFaqsData' => $productFaqsData,
            'productIntroHtml' => $productIntroHtml,
            'productDetailsHtml' => $productDetailsHtml,
            'breadcrumbs' => $breadcrumbs,
            'injectToView' => $injectToView,
            'tdk' => $tdk,
            'isFavorited' => $isFavorited,
            'customerId' => $customer ? $customer->id : 0,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.product', $data);
    }

    private function collectChildCategoryIds(int $categoryId, array &$categoryIds): void
    {
        $childrenIds = ProductCategory::query()
            ->where('parent_id', $categoryId)
            ->pluck('id')
            ->all();

        foreach ($childrenIds as $childId) {
            if (!in_array($childId, $categoryIds)) {
                $categoryIds[] = $childId;
                $this->collectChildCategoryIds((int)$childId, $categoryIds);
            }
        }
    }
}
