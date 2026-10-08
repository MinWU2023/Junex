<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\SectionTitle;
use App\Services\SectionTitleService;
use Illuminate\Http\Request;

class SectionTitleController extends BaseController
{
    public function __construct(SectionTitle $sectionTitle)
    {
        $this->modelName = 'SectionTitle';
        $this->model = $sectionTitle;
        $this->viewPath = 'Setting.Views.sectionTitle';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $sectionTitleService = app(SectionTitleService::class);
        $sectionTitleService->seedDefaults();

        $items = SectionTitle::query()
            ->with(['translations'])
            ->whereIn('sign', array_keys(SectionTitleService::DEFINITIONS))
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        return view($this->viewPath . '.index', compact('items'));
    }

    public function edit($id)
    {
        $model = SectionTitle::query()
            ->with(['translations'])
            ->whereIn('sign', array_keys(SectionTitleService::DEFINITIONS))
            ->findOrFail($id);

        return view($this->viewPath . '.edit', compact('model'));
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.title' => ['nullable', 'string', 'max:255'],
            'translate.*.subtitle' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = SectionTitle::query()
            ->whereIn('sign', array_keys(SectionTitleService::DEFINITIONS))
            ->findOrFail($id);

        $payload = [
            'sort' => (int)$request->get('sort', $model->sort),
            'active' => (int)$request->get('active', $model->active),
        ];
        $translate = (array)$request->get('translate', []);

        $model->update(array_merge($payload, $translate));

        return redirect()->route('admin.sectionTitle.index')->with('success', 'Saved');
    }
}
