<?php

namespace App\Services;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\User\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductListSidebarService
{
    public function getFavoritedProductIds(Request $request): array
    {
        $ip = (string)$request->ip();
        if ($ip === '') {
            return [];
        }

        $customer = Customer::query()
            ->where('ip', $ip)
            ->orderByDesc('id')
            ->first();

        if (!$customer) {
            return [];
        }

        return DB::table('customer_prefers')
            ->where('customer_id', $customer->id)
            ->pluck('product_id')
            ->map(static fn ($id) => (int)$id)
            ->all();
    }

    /**
     * @param Collection<int, Product>|array<int, Product> $products
     * @param array<int> $favoritedIds
     * @return array<int, array<string, mixed>>
     */
    public function mapProducts($products, array $favoritedIds = []): array
    {
        return collect($products)->map(function (Product $p) use ($favoritedIds) {
            return $this->mapProductItem($p, $favoritedIds);
        })->values()->all();
    }

    /**
     * @param array<int> $favoritedIds
     * @return array<string, mixed>
     */
    public function mapProductItem(Product $p, array $favoritedIds = []): array
    {
        $img = $p->productMainImage ? (string)($p->productMainImage->path ?? '') : '';
        if ($img !== '') {
            $img = front_webp_url($img);
        }

        $imageAlt = $p->productMainImage ? (string)($p->productMainImage->alt ?? '') : '';
        $seoImgAlt = (string)($p->img_alt ?? '');

        return [
            'id' => $p->id,
            'name' => (string)($p->name ?? ''),
            'image' => $img,
            'alt' => resolve_product_image_alt($imageAlt, $seoImgAlt, (string)($p->name ?? '')),
            'url' => $p->url ? ('/' . ltrim($p->url->url, '/')) : 'javascript:void(0);',
            'model' => (string)($p->url_key ?? ''),
            'item_no' => (string)($p->url_key ?? ''),
            'is_favorited' => in_array((int)$p->id, $favoritedIds, true),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function buildSidebarCategories(?ProductCategory $activeCategory = null): array
    {
        $activeIds = $this->collectCategoryPathIds($activeCategory);

        $roots = ProductCategory::query()
            ->with([
                'translations',
                'url',
                'children' => function ($query) {
                    $query->with([
                        'translations',
                        'url',
                        'children' => function ($q) {
                            $q->with(['translations', 'url'])
                                ->where('is_show', 1)
                                ->orderByDesc('sort')
                                ->orderBy('id');
                        },
                    ])
                        ->where('is_show', 1)
                        ->orderByDesc('sort')
                        ->orderBy('id');
                },
            ])
            ->where('parent_id', 0)
            ->where('is_show', 1)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        return $roots->map(function (ProductCategory $cat) use ($activeIds) {
            return $this->mapSidebarCategoryNode($cat, $activeIds);
        })->values()->all();
    }

    /**
     * @param array<int> $favoritedIds
     * @return array<int, array<string, mixed>>
     */
    public function buildRecommendProducts(array $favoritedIds = []): array
    {
        $limit = (int)(app('settings')['setting']->sidebar_new_product_num ?? 8);
        if ($limit <= 0) {
            $limit = 8;
        }

        $products = Product::query()
            ->with(['translations', 'productMainImage', 'url'])
            ->active()
            ->where('is_recommend', 1)
            ->orderByDesc('sort')
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get();

        if ($products->isEmpty()) {
            $products = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->where('is_new', 1)
                ->orderByDesc('sort')
                ->orderByDesc('updated_at')
                ->limit($limit)
                ->get();
        }

        return $this->mapProducts($products, $favoritedIds);
    }

    /**
     * @param array<int> $favoritedIds
     * @return array<int, array<string, mixed>>
     */
    public function buildCategoryProductSections(ProductCategory $category, array $favoritedIds = []): array
    {
        $children = ProductCategory::query()
            ->with(['translations', 'url'])
            ->where('parent_id', $category->id)
            ->where('is_show', 1)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        $targets = $children->isNotEmpty() ? $children : collect([$category]);
        $sections = [];

        foreach ($targets as $cat) {
            $categoryIds = [(int)$cat->id];
            $this->collectChildCategoryIds((int)$cat->id, $categoryIds);

            $products = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->whereHas('productCategories', function ($query) use ($categoryIds) {
                    $query->whereIn('product_category_id', $categoryIds);
                })
                ->orderByDesc('sort')
                ->orderByDesc('updated_at')
                ->get();

            $sections[] = [
                'id' => (int)$cat->id,
                'name' => (string)($cat->name ?? ''),
                'url' => $cat->url ? ('/' . ltrim($cat->url->url, '/')) : 'javascript:void(0);',
                'products' => $this->mapProducts($products, $favoritedIds),
            ];
        }

        return $sections;
    }

    /**
     * @param array<int> $activeIds
     * @return array<string, mixed>
     */
    protected function mapSidebarCategoryNode(ProductCategory $cat, array $activeIds): array
    {
        $url = $cat->url ? ('/' . ltrim($cat->url->url, '/')) : 'javascript:void(0);';
        $isActive = in_array((int)$cat->id, $activeIds, true);
        $children = [];

        foreach ($cat->children ?? [] as $child) {
            if ((int)($child->is_show ?? 0) !== 1) {
                continue;
            }
            $children[] = $this->mapSidebarCategoryNode($child, $activeIds);
        }

        $hasActiveChild = $this->nodeHasActiveDescendant($children);

        return [
            'id' => (int)$cat->id,
            'name' => (string)($cat->name ?? ''),
            'url' => $url,
            'active' => $isActive,
            'open' => $isActive || $hasActiveChild,
            'children' => $children,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $nodes
     */
    protected function nodeHasActiveDescendant(array $nodes): bool
    {
        foreach ($nodes as $node) {
            if (!empty($node['active'])) {
                return true;
            }
            if (!empty($node['children']) && $this->nodeHasActiveDescendant($node['children'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int>
     */
    protected function collectCategoryPathIds(?ProductCategory $category): array
    {
        if (!$category) {
            return [];
        }

        $ids = [(int)$category->id];
        $parentId = (int)($category->parent_id ?? 0);
        $guard = 0;

        while ($parentId > 0 && $guard < 20) {
            $guard++;
            $ids[] = $parentId;
            $parentId = (int)ProductCategory::query()->where('id', $parentId)->value('parent_id');
        }

        return array_values(array_unique($ids));
    }

    /**
     * @param array<int> $favoritedIds
     * @return array<int, array<string, mixed>>
     */
    public function buildRelatedProducts(Product $product, array $favoritedIds = [], ?int $limit = null): array
    {
        $limit = $limit ?? (int)(app('settings')['setting']->related_product_num ?? 12);
        if ($limit <= 0) {
            $limit = 12;
        }

        $excludeIds = [(int)$product->id];
        $collected = collect();

        foreach ($this->buildRelatedCategoryTiers($product) as $categoryIds) {
            if ($collected->count() >= $limit) {
                break;
            }

            $categoryIds = array_values(array_unique(array_filter(array_map('intval', $categoryIds))));
            if ($categoryIds === []) {
                continue;
            }

            $needed = $limit - $collected->count();
            $batch = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->whereNotIn('id', $excludeIds)
                ->whereHas('productCategories', function ($query) use ($categoryIds) {
                    $query->whereIn('product_category_id', $categoryIds);
                })
                ->orderByDesc('sort')
                ->orderByDesc('updated_at')
                ->limit($needed)
                ->get();

            foreach ($batch as $item) {
                $collected->push($item);
                $excludeIds[] = (int)$item->id;
            }
        }

        if ($collected->count() < $limit) {
            $needed = $limit - $collected->count();
            $fallback = Product::query()
                ->with(['translations', 'productMainImage', 'url'])
                ->active()
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit($needed)
                ->get();

            foreach ($fallback as $item) {
                $collected->push($item);
                $excludeIds[] = (int)$item->id;
            }
        }

        return $this->mapProducts($collected, $favoritedIds);
    }

    /**
     * Related product category scopes: direct category → siblings → ancestor subtrees.
     *
     * @return array<int, array<int>>
     */
    protected function buildRelatedCategoryTiers(Product $product): array
    {
        $category = $product->productCategory->first();
        if (!$category) {
            return [];
        }

        $tiers = [];
        $tiers[] = [(int)$category->id];

        $parentId = (int)($category->parent_id ?? 0);
        if ($parentId > 0) {
            $siblingIds = ProductCategory::query()
                ->where('parent_id', $parentId)
                ->where('is_show', 1)
                ->pluck('id')
                ->map(static fn ($id) => (int)$id)
                ->all();
            if ($siblingIds !== []) {
                $tiers[] = array_values(array_unique($siblingIds));
            }
        }

        $ancestorId = $parentId;
        $seenKeys = [];
        $guard = 0;
        while ($ancestorId > 0 && $guard < 15) {
            $guard++;
            $grandparentId = (int)ProductCategory::query()
                ->where('id', $ancestorId)
                ->value('parent_id');
            if ($grandparentId <= 0) {
                break;
            }

            $scopeIds = [(int)$grandparentId];
            $this->collectChildCategoryIds($grandparentId, $scopeIds);
            $scopeIds = array_values(array_unique($scopeIds));
            $key = implode(',', $scopeIds);
            if (!isset($seenKeys[$key])) {
                $seenKeys[$key] = true;
                $tiers[] = $scopeIds;
            }

            $ancestorId = $grandparentId;
        }

        return $tiers;
    }

    /**
     * @param array<int> $categoryIds
     */
    public function collectChildCategoryIds(int $categoryId, array &$categoryIds): void
    {
        $childrenIds = ProductCategory::query()
            ->where('parent_id', $categoryId)
            ->pluck('id')
            ->all();

        foreach ($childrenIds as $childId) {
            $childId = (int)$childId;
            if (!in_array($childId, $categoryIds, true)) {
                $categoryIds[] = $childId;
                $this->collectChildCategoryIds($childId, $categoryIds);
            }
        }
    }
}
