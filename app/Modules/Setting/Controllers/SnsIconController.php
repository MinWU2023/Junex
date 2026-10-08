<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\SnsIcon;
use App\Services\SnsIconService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SnsIconController extends BaseController
{
    public function __construct(SnsIcon $snsIcon)
    {
        $this->modelName = 'SnsIcon';
        $this->model = $snsIcon;
        $this->viewPath = 'Setting.Views.snsIcon';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $sign = (string)$request->get('sign', '');
        $linkActive = $request->get('link_active');
        $shareActive = $request->get('share_active');

        $query = SnsIcon::query()->with(['translations']);

        if ($sign !== '') {
            $query->where('sign', 'like', '%' . $sign . '%');
        }
        if ($linkActive !== null && $linkActive !== '') {
            $query->where('link_active', (int)$linkActive);
        }
        if ($shareActive !== null && $shareActive !== '') {
            $query->where('share_active', (int)$shareActive);
        }

        $items = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        return view($this->viewPath . '.index', compact('items', 'sign', 'linkActive', 'shareActive'));
    }

    public function create()
    {
        return view($this->viewPath . '.create');
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sign' => ['required', 'string', 'max:64', 'regex:/^[a-zA-Z0-9_\-]+$/', 'unique:sns_icons,sign'],
            'path' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:1000'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'link_active' => ['nullable', 'integer', 'in:0,1'],
            'share_active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.alt' => ['nullable', 'string', 'max:255'],
        ], [
            'sign.regex' => __('标识仅允许字母、数字、下划线和横线'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = $this->buildPayload($request);
        $translate = (array)$request->get('translate', []);

        SnsIcon::create(array_merge($payload, $translate));
        app(SnsIconService::class)->clearCache();

        return redirect()->route('admin.snsIcon.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = SnsIcon::query()->with(['translations'])->findOrFail($id);
        return view($this->viewPath . '.edit', compact('model'));
    }

    public function update($id, Request $request)
    {
        $model = SnsIcon::query()->findOrFail($id);

        $validator = $this->getValidationFactory()->make($request->all(), [
            'sign' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-zA-Z0-9_\-]+$/',
                Rule::unique('sns_icons', 'sign')->ignore($model->id),
            ],
            'path' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:1000'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'link_active' => ['nullable', 'integer', 'in:0,1'],
            'share_active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.alt' => ['nullable', 'string', 'max:255'],
        ], [
            'sign.regex' => __('标识仅允许字母、数字、下划线和横线'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = $this->buildPayload($request);
        $translate = (array)$request->get('translate', []);

        $model->update(array_merge($payload, $translate));
        app(SnsIconService::class)->clearCache();

        return redirect()->route('admin.snsIcon.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = SnsIcon::query()->findOrFail($id);
        $model->delete();
        app(SnsIconService::class)->clearCache();

        return redirect()->route('admin.snsIcon.index')->with('success', 'Deleted');
    }

    /**
     * Toggle link_active or share_active from list.
     */
    public function toggleStatus($id, Request $request)
    {
        $field = (string)$request->input('field', '');
        if (!in_array($field, ['link_active', 'share_active'], true)) {
            return response()->json(['code' => 1, 'msg' => 'Invalid field'], 422);
        }

        $model = SnsIcon::query()->findOrFail($id);
        $model->{$field} = (int)$model->{$field} === 1 ? 0 : 1;
        $model->active = ((int)$model->link_active === 1 || (int)$model->share_active === 1) ? 1 : 0;
        $model->save();
        app(SnsIconService::class)->clearCache();

        return response()->json([
            'code' => 0,
            'msg' => 'ok',
            'data' => [
                'field' => $field,
                'value' => (int)$model->{$field},
                'link_active' => (int)$model->link_active,
                'share_active' => (int)$model->share_active,
            ],
        ]);
    }

    protected function buildPayload(Request $request): array
    {
        $payload = $request->only(['sign', 'path', 'link', 'sort', 'link_active', 'share_active']);
        $payload['sign'] = strtolower(trim((string)($payload['sign'] ?? '')));
        $payload['path'] = front_image_store_path($payload['path'] ?? '');
        $payload['link'] = trim((string)($payload['link'] ?? ''));
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['link_active'] = (int)($payload['link_active'] ?? 1);
        $payload['share_active'] = (int)($payload['share_active'] ?? 1);
        $payload['active'] = ($payload['link_active'] === 1 || $payload['share_active'] === 1) ? 1 : 0;

        return $payload;
    }
}
