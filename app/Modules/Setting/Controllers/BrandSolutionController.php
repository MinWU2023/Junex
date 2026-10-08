<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\BrandSolution;
use Illuminate\Http\Request;

class BrandSolutionController extends BaseController
{
    public function __construct(BrandSolution $brandSolution)
    {
        $this->modelName = 'BrandSolution';
        $this->model = $brandSolution;
        $this->viewPath = 'Setting.Views.brandSolution';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $title = (string)$request->get('title', '');
        $active = $request->get('active');

        $query = BrandSolution::query()->with(['translations']);

        if ($title !== '') {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }
        if ($active !== null && $active !== '') {
            $query->where('active', (int)$active);
        }

        $items = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        return view($this->viewPath . '.index', compact('items', 'title', 'active'));
    }

    public function create()
    {
        return view($this->viewPath . '.create');
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'path' => ['required', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.title' => ['nullable', 'string', 'max:255'],
            'translate.*.description' => ['nullable', 'string'],
            'translate.*.button_text' => ['nullable', 'string', 'max:255'],
            'translate.*.features' => ['nullable', 'array'],
            'translate.*.features.*' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = $request->only(['path', 'button_url', 'sort', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        $payload['button_url'] = (string)($payload['button_url'] ?? '');
        $payload['path'] = front_image_store_path($payload['path'] ?? '');

        $translate = $this->normalizeTranslate((array)$request->get('translate', []));

        BrandSolution::create(array_merge($payload, $translate));

        return redirect()->route('admin.brandSolution.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = BrandSolution::query()->with(['translations'])->findOrFail($id);
        return view($this->viewPath . '.edit', compact('model'));
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'path' => ['required', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.title' => ['nullable', 'string', 'max:255'],
            'translate.*.description' => ['nullable', 'string'],
            'translate.*.button_text' => ['nullable', 'string', 'max:255'],
            'translate.*.features' => ['nullable', 'array'],
            'translate.*.features.*' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = BrandSolution::query()->findOrFail($id);

        $payload = $request->only(['path', 'button_url', 'sort', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        $payload['button_url'] = (string)($payload['button_url'] ?? '');
        $payload['path'] = front_image_store_path($payload['path'] ?? '');

        $translate = $this->normalizeTranslate((array)$request->get('translate', []));

        $model->update(array_merge($payload, $translate));

        return redirect()->route('admin.brandSolution.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = BrandSolution::query()->findOrFail($id);
        $model->delete();
        return redirect()->route('admin.brandSolution.index')->with('success', 'Deleted');
    }

    /**
     * Normalize locale payload: features[] strings -> [{text: "..."}]
     */
    protected function normalizeTranslate(array $translate): array
    {
        foreach ($translate as $locale => $fields) {
            if (!is_array($fields)) {
                continue;
            }
            $features = $fields['features'] ?? [];
            if (!is_array($features)) {
                $features = [];
            }
            $normalized = [];
            foreach ($features as $item) {
                $text = trim((string)$item);
                if ($text === '') {
                    continue;
                }
                $normalized[] = ['text' => $text];
            }
            $translate[$locale]['features'] = $normalized;
        }

        return $translate;
    }
}
