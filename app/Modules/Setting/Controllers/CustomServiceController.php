<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\CustomService;
use App\Modules\Setting\Models\CustomServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomServiceController extends BaseController
{
    public function __construct(CustomService $customService)
    {
        $this->modelName = 'CustomService';
        $this->model = $customService;
        $this->viewPath = 'Setting.Views.customService';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $keyword = (string)$request->get('keyword', '');
        $active = $request->get('active');

        $query = CustomService::query()->with(['translations', 'items']);

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', '%' . $keyword . '%')
                    ->orWhereTranslationLike('title_prefix', '%' . $keyword . '%')
                    ->orWhereTranslationLike('title_suffix', '%' . $keyword . '%');
            });
        }
        if ($active !== null && $active !== '') {
            $query->where('active', (int)$active);
        }

        $items = $query
            ->orderByDesc('sort')
            ->orderBy('id')
            ->paginate(15)
            ->appends($request->query());

        return view($this->viewPath . '.index', compact('items', 'keyword', 'active'));
    }

    public function create()
    {
        $locales = config('translatable.locales', ['en']);
        return view($this->viewPath . '.create', compact('locales'));
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules());
        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $payload = $this->columnPayload($request);
            $translate = (array)$request->get('translate', []);
            $service = CustomService::create(array_merge($payload, $translate));
            $this->syncItems($service, (array)$request->get('items', []));
        });

        return redirect()->route('admin.customService.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = CustomService::query()
            ->with(['translations', 'items.translations'])
            ->findOrFail($id);
        $locales = config('translatable.locales', ['en']);
        return view($this->viewPath . '.edit', compact('model', 'locales'));
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->rules($id));
        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = CustomService::query()->findOrFail($id);

        DB::transaction(function () use ($request, $model) {
            $payload = $this->columnPayload($request);
            $translate = (array)$request->get('translate', []);
            $model->update(array_merge($payload, $translate));
            $this->syncItems($model, (array)$request->get('items', []));
        });

        return redirect()->route('admin.customService.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = CustomService::query()->findOrFail($id);
        $model->delete();
        return redirect()->route('admin.customService.index')->with('success', 'Deleted');
    }

    protected function rules($id = null): array
    {
        $unique = 'unique:custom_services,code';
        if ($id) {
            $unique .= ',' . $id;
        }

        return [
            'code' => ['required', 'string', 'max:50', $unique],
            'bg_image' => ['nullable', 'string', 'max:255'],
            'layout' => ['required', 'string', 'in:grid,list'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.title_prefix' => ['nullable', 'string', 'max:255'],
            'translate.*.title_suffix' => ['nullable', 'string', 'max:255'],
            'translate.*.subtitle' => ['nullable', 'string', 'max:255'],
            'items' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.path' => ['nullable', 'string', 'max:255'],
            'items.*.url' => ['nullable', 'string', 'max:255'],
            'items.*.sort' => ['nullable', 'integer', 'min:0'],
            'items.*.active' => ['nullable', 'integer', 'in:0,1'],
            'items.*.translate' => ['nullable', 'array'],
            'items.*.translate.*.title' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function columnPayload(Request $request): array
    {
        return [
            'code' => trim((string)$request->get('code')),
            'bg_image' => front_image_store_path($request->get('bg_image')),
            'layout' => (string)$request->get('layout', 'grid'),
            'sort' => (int)$request->get('sort', 0),
            'active' => (int)$request->get('active', 1),
        ];
    }

    protected function syncItems(CustomService $service, array $items): void
    {
        $keepIds = [];
        $locales = config('translatable.locales', ['en']);

        foreach (array_values($items) as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $path = front_image_store_path($row['path'] ?? '');
            $url = trim((string)($row['url'] ?? ''));
            $sort = (int)($row['sort'] ?? (100 - $index));
            $active = (int)($row['active'] ?? 1);
            $translate = (array)($row['translate'] ?? []);

            $hasTitle = false;
            foreach ($locales as $locale) {
                if (trim((string)($translate[$locale]['title'] ?? '')) !== '') {
                    $hasTitle = true;
                    break;
                }
            }
            if ($path === '' && !$hasTitle && $url === '') {
                continue;
            }

            $itemId = (int)($row['id'] ?? 0);
            $payload = [
                'custom_service_id' => $service->id,
                'path' => $path,
                'url' => $url,
                'sort' => $sort,
                'active' => $active,
            ];

            if ($itemId > 0) {
                $item = CustomServiceItem::query()
                    ->where('custom_service_id', $service->id)
                    ->where('id', $itemId)
                    ->first();
                if ($item) {
                    $item->update(array_merge($payload, $translate));
                    $keepIds[] = $item->id;
                    continue;
                }
            }

            $item = CustomServiceItem::create(array_merge($payload, $translate));
            $keepIds[] = $item->id;
        }

        $deleteQuery = CustomServiceItem::query()->where('custom_service_id', $service->id);
        if (!empty($keepIds)) {
            $deleteQuery->whereNotIn('id', $keepIds);
        }
        $deleteQuery->delete();
    }
}
