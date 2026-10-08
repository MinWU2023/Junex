<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\WhyChooseCard;
use App\Modules\Setting\Models\WhyChooseSetting;
use Illuminate\Http\Request;

class WhyChooseCardController extends BaseController
{
    public function __construct(WhyChooseCard $whyChooseCard)
    {
        $this->modelName = 'WhyChooseCard';
        $this->model = $whyChooseCard;
        $this->viewPath = 'Setting.Views.whyChooseCard';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $label = (string)$request->get('label', '');
        $active = $request->get('active');

        $query = WhyChooseCard::query()->with(['translations']);

        if ($label !== '') {
            $query->whereTranslationLike('label', '%' . $label . '%');
        }
        if ($active !== null && $active !== '') {
            $query->where('active', (int)$active);
        }

        $items = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        return view($this->viewPath . '.index', compact('items', 'label', 'active'));
    }

    /**
     * 中间板块（Logo / 标题 / 副标题 / 桌面描述）
     */
    public function editCenter()
    {
        $model = WhyChooseSetting::singleton();
        return view($this->viewPath . '.center', compact('model'));
    }

    public function updateCenter(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'logo' => ['nullable', 'string', 'max:255'],
            'translate' => ['array'],
            'translate.*.title' => ['nullable', 'string', 'max:255'],
            'translate.*.subtitle' => ['nullable', 'string', 'max:255'],
            'translate.*.description_desktop' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = WhyChooseSetting::singleton();
        $payload = [
            'logo' => front_image_store_path($request->get('logo', '')),
        ];
        $translate = (array)$request->get('translate', []);
        $model->update(array_merge($payload, $translate));

        return redirect()->route('admin.whyChooseCard.index')->with('success', '中间板块已保存');
    }

    public function create()
    {
        return view($this->viewPath . '.create');
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'image_mobile' => ['nullable', 'string', 'max:255'],
            'background_desktop' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.label' => ['nullable', 'string', 'max:255'],
            'translate.*.value' => ['nullable', 'string', 'max:255'],
            'translate.*.value_suffix' => ['nullable', 'string', 'max:255'],
            'translate.*.description' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = $request->only(['image_mobile', 'background_desktop', 'url', 'sort', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        $payload['url'] = (string)($payload['url'] ?? '');
        $payload['image_mobile'] = front_image_store_path($payload['image_mobile'] ?? '');
        $payload['background_desktop'] = front_image_store_path($payload['background_desktop'] ?? '');

        $translate = (array)$request->get('translate', []);

        WhyChooseCard::create(array_merge($payload, $translate));

        return redirect()->route('admin.whyChooseCard.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = WhyChooseCard::query()->with(['translations'])->findOrFail($id);
        return view($this->viewPath . '.edit', compact('model'));
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'image_mobile' => ['nullable', 'string', 'max:255'],
            'background_desktop' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.label' => ['nullable', 'string', 'max:255'],
            'translate.*.value' => ['nullable', 'string', 'max:255'],
            'translate.*.value_suffix' => ['nullable', 'string', 'max:255'],
            'translate.*.description' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = WhyChooseCard::query()->findOrFail($id);

        $payload = $request->only(['image_mobile', 'background_desktop', 'url', 'sort', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        $payload['url'] = (string)($payload['url'] ?? '');
        $payload['image_mobile'] = front_image_store_path($payload['image_mobile'] ?? '');
        $payload['background_desktop'] = front_image_store_path($payload['background_desktop'] ?? '');

        $translate = (array)$request->get('translate', []);

        $model->update(array_merge($payload, $translate));

        return redirect()->route('admin.whyChooseCard.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = WhyChooseCard::query()->findOrFail($id);
        $model->delete();
        return redirect()->route('admin.whyChooseCard.index')->with('success', 'Deleted');
    }
}
