<?php

namespace App\Services;

use App\Modules\Navigation\Models\Navigation;
use App\Modules\Product\Models\ProductCategory;
use Illuminate\Support\Str;

class FrontMenuService
{
    public function build(): array
    {
        $path = $this->normalizePath(request()->path());

        $roots = Navigation::query()
            ->with([
                'translations',
                'visibleChildren.translations',
                'visibleChildren.visibleChildren.translations',
                'categories.translations',
                'categories.url',
                'categories.children.translations',
                'categories.children.url',
                'categories.children.children.translations',
                'categories.children.children.url',
            ])
            ->area(Navigation::AREA_HEAD)
            ->visible()
            ->where('parent_id', 0)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        $items = [];
        foreach ($roots as $nav) {
            $item = $this->mapNavigationNode($nav, $path, 1, []);
            if ($item) {
                $items[] = $item;
            }
        }

        // Fallback to legacy hardcoded menu if head nav empty
        if (empty($items)) {
            $items = $this->legacyFallbackItems($path);
        }

        return [
            'items' => $items,
            'path' => $path,
        ];
    }

    private function mapNavigationNode(Navigation $nav, string $path, int $level, array $ancestors = []): ?array
    {
        if ((int)($nav->is_show ?? 1) !== 1) {
            return null;
        }

        $navId = (int) $nav->id;
        // Guard against parent/child cycles that would hang the whole page
        if ($navId > 0 && isset($ancestors[$navId])) {
            return null;
        }
        if ($level > 20) {
            return null;
        }
        $ancestors[$navId] = true;

        $url = $this->normalizeUrl((string)($nav->url ?? ''));
        $children = [];

        // 1) Normal navigation children first
        foreach ($nav->visibleChildren as $child) {
            if ((int) $child->id === $navId || (int) $child->parent_id === (int) $child->id) {
                continue;
            }
            $mapped = $this->mapNavigationNode($child, $path, $level + 1, $ancestors);
            if ($mapped) {
                $children[] = $mapped;
            }
        }

        // 2) Associated categories after normal children (only for category link type at any level that has associations)
        if ($nav->isCategoryLink()) {
            $categoryChildren = $this->buildCategoryChildren($nav, $path);
            foreach ($categoryChildren as $catChild) {
                $children[] = $catChild;
            }
        }

        $item = [
            'key' => 'nav-' . $nav->id,
            'label' => (string)($nav->name ?? ''),
            'url' => $url !== '' ? $url : '#',
            'match' => $url !== '' && $url !== '#' ? [$this->urlToPath($url)] : [],
            'children' => $children,
            'target' => (int)($nav->is_new ?? 0) === 1 ? '_blank' : null,
            'rel' => $this->buildRel((int)($nav->is_new ?? 0) === 1, (int)($nav->is_nofollow ?? 0) === 1),
            'link_type' => $nav->link_type ?: Navigation::LINK_NORMAL,
            'has_dropdown' => !empty($children),
        ];
        $item['active'] = $this->isItemActive($item, $path);

        return $item;
    }

    private function buildCategoryChildren(Navigation $nav, string $path): array
    {
        $selected = $nav->categories;
        if ($selected->isEmpty()) {
            return [];
        }

        $selectedIds = $selected->pluck('id')->map(fn ($id) => (int)$id)->all();
        $selectedSet = array_fill_keys($selectedIds, true);

        // Load full nodes with hierarchy among selected
        $byId = ProductCategory::query()
            ->with(['translations', 'url', 'children.translations', 'children.url', 'children.children.translations', 'children.children.url'])
            ->whereIn('id', $selectedIds)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get()
            ->keyBy('id');

        $roots = [];
        foreach ($byId as $cat) {
            $pid = (int)($cat->parent_id ?? 0);
            if ((int)$cat->id === $pid) {
                $roots[] = $cat;
                continue;
            }
            if ($pid <= 0 || !isset($selectedSet[$pid])) {
                $roots[] = $cat;
            }
        }

        // Same as admin: larger sort first
        usort($roots, function ($a, $b) {
            $sa = (int)($a->sort ?? 0);
            $sb = (int)($b->sort ?? 0);
            if ($sa === $sb) {
                return (int)$a->id <=> (int)$b->id;
            }
            return $sb <=> $sa;
        });

        $mapCat = function ($cat, array $ancestors = []) use (&$mapCat, $selectedSet, $byId, $path) {
            $catId = (int) $cat->id;
            if ($catId > 0 && isset($ancestors[$catId])) {
                return null;
            }
            if (count($ancestors) > 20) {
                return null;
            }
            $ancestors[$catId] = true;

            $url = $cat->getUrl() ?: url('/' . ltrim((string)$cat->url_key, '/'));
            $children = [];
            $childNodes = $byId->filter(function ($c) use ($cat, $selectedSet) {
                $cid = (int) $c->id;
                return $cid !== (int) $cat->id
                    && (int) $c->parent_id === (int) $cat->id
                    && (int) $c->parent_id !== $cid
                    && isset($selectedSet[$cid]);
            })->sort(function ($a, $b) {
                $sa = (int)($a->sort ?? 0);
                $sb = (int)($b->sort ?? 0);
                if ($sa === $sb) {
                    return (int)$a->id <=> (int)$b->id;
                }
                return $sb <=> $sa;
            });

            foreach ($childNodes as $child) {
                $mapped = $mapCat($child, $ancestors);
                if ($mapped) {
                    $children[] = $mapped;
                }
            }

            $item = [
                'key' => 'product-category-' . $cat->id,
                'label' => (string)$cat->name,
                'url' => $url,
                'match' => [$this->urlToPath($url)],
                'children' => $children,
                'target' => null,
                'rel' => null,
                'link_type' => 'category',
                'has_dropdown' => !empty($children),
            ];
            $item['active'] = $this->isItemActive($item, $path);
            return $item;
        };

        $result = [];
        foreach ($roots as $root) {
            $mapped = $mapCat($root);
            if ($mapped) {
                $result[] = $mapped;
            }
        }
        return $result;
    }

    private function buildRel(bool $isNew, bool $isNofollow): ?string
    {
        $parts = [];
        if ($isNew) {
            $parts[] = 'noopener';
            $parts[] = 'noreferrer';
        }
        if ($isNofollow) {
            $parts[] = 'nofollow';
        }
        return empty($parts) ? null : implode(' ', $parts);
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }
        if (Str::startsWith($url, ['http://', 'https://', '//', 'mailto:', 'tel:', '#'])) {
            return $url;
        }
        return '/' . ltrim($url, '/');
    }

    private function legacyFallbackItems(string $path): array
    {
        $productCategories = $this->getProductCategoriesLegacy($path);
        $items = [
            [
                'key' => 'home',
                'label' => 'Home',
                'url' => route('home'),
                'match' => ['/'],
                'children' => [],
                'target' => null,
                'rel' => null,
                'has_dropdown' => false,
            ],
            [
                'key' => 'about',
                'label' => 'About Us',
                'url' => url('/about-us'),
                'match' => ['/about-us'],
                'children' => [],
                'target' => null,
                'rel' => null,
                'has_dropdown' => false,
            ],
            [
                'key' => 'products',
                'label' => 'Product',
                'url' => route('products'),
                'match' => ['/products'],
                'children' => $productCategories,
                'target' => null,
                'rel' => null,
                'has_dropdown' => !empty($productCategories),
            ],
            [
                'key' => 'services',
                'label' => 'Custom Service',
                'url' => route('customer-services'),
                'match' => ['/customer-services'],
                'children' => [],
                'target' => null,
                'rel' => null,
                'has_dropdown' => false,
            ],
            [
                'key' => 'catalog',
                'label' => 'Catalog',
                'url' => '/newstyle',
                'match' => [],
                'children' => [],
                'target' => '_blank',
                'rel' => 'noopener noreferrer',
                'has_dropdown' => false,
            ],
            [
                'key' => 'blogs',
                'label' => 'Blogs',
                'url' => route('blogs'),
                'match' => ['/blogs'],
                'children' => [],
                'target' => null,
                'rel' => null,
                'has_dropdown' => false,
            ],
            [
                'key' => 'contact',
                'label' => 'Contact Us',
                'url' => url('/contact-us'),
                'match' => ['/contact-us'],
                'children' => [],
                'target' => null,
                'rel' => null,
                'has_dropdown' => false,
            ],
        ];

        foreach ($items as $index => $item) {
            $items[$index]['active'] = $this->isItemActive($item, $path);
        }

        return $items;
    }

    private function getProductCategoriesLegacy(string $path): array
    {
        $categories = ProductCategory::query()
            ->with(['translations', 'children.translations', 'url', 'children.url'])
            ->where('parent_id', 0)
            ->where('is_menu', 1)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        $result = [];
        foreach ($categories as $category) {
            $children = [];
            foreach ($category->children as $child) {
                if ((int)($child->is_menu ?? 1) !== 1) {
                    continue;
                }
                $childUrl = $child->getUrl() ?: url('/' . ltrim($child->url_key, '/'));
                $children[] = [
                    'key' => 'product-category-' . $child->id,
                    'label' => $child->name,
                    'url' => $childUrl,
                    'match' => [$this->urlToPath($childUrl)],
                    'children' => [],
                    'active' => $this->isPathActive($path, $this->urlToPath($childUrl)),
                    'has_dropdown' => false,
                ];
            }

            $categoryUrl = $category->getUrl() ?: url('/' . ltrim($category->url_key, '/'));
            $categoryPath = $this->urlToPath($categoryUrl);
            $active = $this->isPathActive($path, $categoryPath);
            if (!$active) {
                foreach ($children as $child) {
                    if ($child['active']) {
                        $active = true;
                        break;
                    }
                }
            }

            $result[] = [
                'key' => 'product-category-' . $category->id,
                'label' => $category->name,
                'url' => $categoryUrl,
                'match' => [$categoryPath],
                'children' => $children,
                'active' => $active,
                'has_dropdown' => !empty($children),
            ];
        }

        return $result;
    }

    private function isItemActive(array $item, string $path): bool
    {
        if ($this->isPathActive($path, $this->urlToPath($item['url'] ?? ''))) {
            return true;
        }

        foreach ($item['children'] ?? [] as $child) {
            if (!empty($child['active'])) {
                return true;
            }
        }

        foreach ($item['match'] ?? [] as $match) {
            if ($this->isPathActive($path, $match)) {
                return true;
            }
        }

        return false;
    }

    private function normalizePath(?string $path): string
    {
        $path = '/' . trim((string)$path, '/');
        return $path === '//' ? '/' : $path;
    }

    private function urlToPath(?string $url): string
    {
        if (!$url || $url === '#') {
            return '/';
        }
        $path = parse_url($url, PHP_URL_PATH);
        if ($path === null || $path === false || $path === '') {
            return '/';
        }
        return $this->normalizePath($path);
    }

    private function isPathActive(string $current, string $target): bool
    {
        if ($target === '/' || $target === '') {
            return $current === '/';
        }

        return Str::startsWith($current, $target);
    }
}
