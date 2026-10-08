<?php

namespace App\Modules\Navigation\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Navigation\Models\Navigation;
use App\Modules\Product\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class NavigationController extends BaseController
{
    public function __construct(Navigation $navigation)
    {
        $this->model = $navigation;
        $this->modelSource = $navigation;
        $this->modelName = 'Navigation';
        $this->viewPath = 'Navigation.Views';
        $this->validatorData = [
            'translate.' . config('translatable.fallback_locale') . '.name' => 'required',
            'area' => 'nullable|in:头部,底部',
            'link_type' => 'nullable|in:normal,category',
            'parent_id' => 'nullable|integer',
            'sort' => 'nullable|integer',
            'url' => 'nullable|string|max:500',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer',
        ];
    }

    public function index()
    {
        $request = request();
        $name = trim((string)$request->get('name', ''));
        $area = (string)$request->get('area', Navigation::AREA_HEAD);
        if (!in_array($area, [Navigation::AREA_HEAD, Navigation::AREA_FOOT], true)) {
            $area = Navigation::AREA_HEAD;
        }

        if ($request->ajax() || $request->wantsJson()) {
            $page = max(1, (int)$request->get('page', 1));
            $limit = (int)$request->get('limit', 10);
            if ($limit <= 0) {
                $limit = 10;
            }
            if ($limit > 100) {
                $limit = 100;
            }

            $rootQuery = Navigation::query()
                ->with('translations')
                ->area($area)
                ->where('parent_id', 0);

            if ($name !== '') {
                // Search: include trees that match name (any level) within this area
                $matchIds = Navigation::query()
                    ->area($area)
                    ->whereTranslationLike('name', '%' . $name . '%')
                    ->pluck('id')
                    ->all();

                $rootIds = $this->resolveRootIdsForMatches($matchIds, $area);
                $total = count($rootIds);
                $pageRootIds = array_slice($rootIds, ($page - 1) * $limit, $limit);
                $items = $this->collectTreeRows($pageRootIds, $area);
            } else {
                $total = (clone $rootQuery)->count();
                $roots = (clone $rootQuery)
                    ->orderByDesc('sort')
                    ->orderBy('id')
                    ->forPage($page, $limit)
                    ->get();
                $pageRootIds = $roots->pluck('id')->all();
                $items = $this->collectTreeRows($pageRootIds, $area);
            }

            return response()->json([
                'code' => 0,
                'msg' => '',
                'count' => $total,
                'data' => $items,
            ]);
        }

        return view($this->viewPath . '.index', [
            'name' => $name,
            'area' => $area,
        ]);
    }

    public function create()
    {
        $request = request();
        $area = (string)$request->get('area', Navigation::AREA_HEAD);
        if (!in_array($area, [Navigation::AREA_HEAD, Navigation::AREA_FOOT], true)) {
            $area = Navigation::AREA_HEAD;
        }

        $categoryTree = $this->buildCategoryCheckboxTree();
        $selectedCategoryIds = old('category_ids', []);

        return view($this->viewPath . '.create', compact('area', 'categoryTree', 'selectedCategoryIds'));
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $payload = $this->normalizePayload($request);
        if ($err = $this->validateParentChoice(null, (int)$payload['parent_id'])) {
            return response()->json([
                'code' => 422,
                'errors' => ['parent_id' => [$err]],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = (array)$request->get('translate', []);
        $add = array_merge($payload, $translate);
        unset($add['url_key']);

        try {
            $model = $this->model->create($add);
            $this->syncCategories($model, $request->get('category_ids', []), (string)$payload['link_type']);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }

        return $this->success();
    }

    public function edit($id)
    {
        $data = $this->checkTranslate($id);
        /** @var Navigation $model */
        $model = $data['model'];
        $data['area'] = $model->area ?: Navigation::AREA_HEAD;
        $data['categoryTree'] = $this->buildCategoryCheckboxTree();
        $data['selectedCategoryIds'] = old(
            'category_ids',
            $model->categories()->pluck('product_categories.id')->all()
        );

        return view($this->viewPath . '.edit', $data);
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $model = $this->model->findOrFail($id);
        $payload = $this->normalizePayload($request, $model);
        if ($err = $this->validateParentChoice((int)$id, (int)$payload['parent_id'])) {
            return response()->json([
                'code' => 422,
                'errors' => ['parent_id' => [$err]],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = (array)$request->get('translate', []);
        $update = array_merge($payload, $translate);
        unset($update['url_key']);

        try {
            $model->update($update);
            $this->syncCategories($model, $request->get('category_ids', []), (string)$payload['link_type']);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }

        return $this->success();
    }

    public function changeProperty($id, Request $request)
    {
        $model = $this->model->find($id);
        switch ($request->type) {
            case 'event_new':
                $model->is_new = !$model->is_new;
                break;
            case 'event_show':
                $model->is_show = !$model->is_show;
                break;
            case 'event_nofollow':
                $model->is_nofollow = !$model->is_nofollow;
                break;
        }
        $model->save();
        return $this->success();
    }

    protected function normalizePayload(Request $request, ?Navigation $existing = null): array
    {
        $area = (string)$request->get('area', $existing->area ?? Navigation::AREA_HEAD);
        if (!in_array($area, [Navigation::AREA_HEAD, Navigation::AREA_FOOT], true)) {
            $area = Navigation::AREA_HEAD;
        }

        $linkType = (string)$request->get('link_type', $existing->link_type ?? Navigation::LINK_NORMAL);
        if (!in_array($linkType, [Navigation::LINK_NORMAL, Navigation::LINK_CATEGORY], true)) {
            $linkType = Navigation::LINK_NORMAL;
        }

        // Child items inherit parent area; only top-level can be category type meaningfully
        $parentId = (int)$request->get('parent_id', $existing->parent_id ?? 0);
        if ($parentId > 0) {
            $parent = Navigation::query()->find($parentId);
            if ($parent) {
                $area = $parent->area ?: $area;
            }
            // Sub-nav is always normal link type
            $linkType = Navigation::LINK_NORMAL;
        }

        return [
            'parent_id' => $parentId,
            'url' => trim((string)$request->get('url', '')),
            'sort' => (int)$request->get('sort', 0),
            'area' => $area,
            'link_type' => $linkType,
            'is_show' => $request->has('is_show') ? 1 : 0,
            'is_new' => $request->has('is_new') ? 1 : 0,
            'is_nofollow' => $request->has('is_nofollow') ? 1 : 0,
            'is_translate' => $request->has('is_translate') ? 1 : (int)($existing->is_translate ?? 0),
        ];
    }

    protected function syncCategories(Navigation $model, $categoryIds, string $linkType): void
    {
        if ($linkType !== Navigation::LINK_CATEGORY || (int)$model->parent_id > 0) {
            $model->categories()->detach();
            return;
        }

        if (!is_array($categoryIds)) {
            $categoryIds = [];
        }
        $categoryIds = array_values(array_unique(array_filter(array_map('intval', $categoryIds), fn ($id) => $id > 0)));

        $sync = [];
        $sort = count($categoryIds) * 10;
        foreach ($categoryIds as $cid) {
            $sync[$cid] = ['sort' => $sort];
            $sort -= 10;
        }
        $model->categories()->sync($sync);
    }

    protected function resolveRootIdsForMatches(array $matchIds, string $area): array
    {
        if (empty($matchIds)) {
            return [];
        }

        $all = Navigation::query()
            ->area($area)
            ->get(['id', 'parent_id'])
            ->keyBy('id');

        $roots = [];
        foreach ($matchIds as $id) {
            $cur = $all->get($id);
            if (!$cur) {
                continue;
            }
            $seen = [];
            $guard = 0;
            while ((int)$cur->parent_id > 0 && $all->has((int)$cur->parent_id)) {
                if (isset($seen[$cur->id]) || (int)$cur->id === (int)$cur->parent_id) {
                    break;
                }
                $seen[$cur->id] = true;
                $cur = $all->get((int)$cur->parent_id);
                if (++$guard > 50) {
                    break;
                }
            }
            $roots[(int)$cur->id] = true;
        }

        // Keep root order by sort
        return Navigation::query()
            ->area($area)
            ->whereIn('id', array_keys($roots))
            ->orderByDesc('sort')
            ->orderBy('id')
            ->pluck('id')
            ->all();
    }

    protected function collectTreeRows(array $rootIds, string $area): array
    {
        if (empty($rootIds)) {
            return [];
        }

        $all = Navigation::query()
            ->with(['translations', 'categories:id'])
            ->area($area)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get()
            ->keyBy('id');

        $include = [];
        $walk = function ($id) use (&$walk, &$include, $all) {
            if (isset($include[$id]) || !$all->has($id)) {
                return;
            }
            $include[$id] = true;
            foreach ($all as $node) {
                if ((int)$node->parent_id === (int)$id) {
                    $walk($node->id);
                }
            }
        };
        foreach ($rootIds as $rid) {
            $walk($rid);
        }

        $rows = [];
        foreach ($all as $nav) {
            if (!isset($include[$nav->id])) {
                continue;
            }
            $rows[] = [
                'id' => (int)$nav->id,
                'parent_id' => ((int)$nav->id === (int)($nav->parent_id ?? 0)) ? 0 : (int)($nav->parent_id ?? 0),
                'name' => $nav->name,
                'is_show' => (int)($nav->is_show ?? 0),
                'is_new' => (int)($nav->is_new ?? 0),
                'is_nofollow' => (int)($nav->is_nofollow ?? 0),
                'sort' => (int)($nav->sort ?? 0),
                'url' => $nav->url,
                'area' => $nav->area,
                'link_type' => $nav->link_type ?: 'normal',
                'link_type_label' => $nav->isCategoryLink() ? '关联分类' : '普通导航',
                'category_count' => $nav->categories->count(),
            ];
        }

        return $rows;
    }

    protected function buildCategoryCheckboxTree(): array
    {
        $categories = ProductCategory::query()
            ->with(['translations', 'children.translations', 'children.children.translations'])
            ->where('parent_id', 0)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        $map = function ($nodes, $depth = 0, array $ancestors = []) use (&$map) {
            $out = [];
            if ($depth > 20) {
                return $out;
            }
            foreach ($nodes as $node) {
                $id = (int)$node->id;
                if ($id > 0 && isset($ancestors[$id])) {
                    continue;
                }
                $nextAncestors = $ancestors;
                $nextAncestors[$id] = true;
                $kids = collect($node->children ?? [])->filter(function ($child) use ($id) {
                    return (int)$child->id !== $id && (int)$child->parent_id !== (int)$child->id;
                })->values();
                $out[] = [
                    'id' => $id,
                    'name' => (string)$node->name,
                    'depth' => $depth,
                    'children' => $map($kids, $depth + 1, $nextAncestors),
                ];
            }
            return $out;
        };

        return $map($categories);
    }

    /**
     * @return string|null error message
     */
    protected function validateParentChoice(?int $id, int $parentId): ?string
    {
        if ($parentId <= 0) {
            return null;
        }
        if ($id !== null && $parentId === $id) {
            return __('上级导航不能选择自己');
        }

        $all = Navigation::query()->get(['id', 'parent_id'])->keyBy('id');
        if (!$all->has($parentId)) {
            return __('上级导航不存在');
        }

        $cur = $all->get($parentId);
        $seen = [];
        $guard = 0;
        while ($cur && (int)$cur->parent_id > 0) {
            if (isset($seen[$cur->id]) || (int)$cur->id === (int)$cur->parent_id) {
                return __('上级导航存在循环引用，请重新选择');
            }
            if ($id !== null && (int)$cur->id === $id) {
                return __('不能选择自己的下级作为上级');
            }
            $seen[$cur->id] = true;
            $cur = $all->get((int)$cur->parent_id);
            if (++$guard > 50) {
                return __('上级导航层级异常，请重新选择');
            }
        }

        if ($id !== null && $cur && (int)$cur->id === $id) {
            return __('不能选择自己的下级作为上级');
        }

        return null;
    }
}
