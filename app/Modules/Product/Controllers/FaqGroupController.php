<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\User\Models\FaqGroup;
use Illuminate\Http\Request;

class FaqGroupController extends BaseController
{
    public function __construct(FaqGroup $faqGroup)
    {
        $this->modelName = 'FaqGroup';
        $this->model = $faqGroup;
        $this->viewPath = 'Product.Views.faqGroup';
        $this->orderBy = 'id';
    }

    public function index()
    {
        $request = request();

        $name = trim((string)$request->get('name', ''));

        $query = FaqGroup::query()->with(['translations']);
        if ($name !== '') {
            $query->whereTranslationLike('name', '%' . $name . '%');
        }

        $groups = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        return view($this->viewPath . '.index', compact('groups', 'name'));
    }

    public function create()
    {
        return view($this->viewPath . '.create');
    }

    public function store(Request $request)
    {
        $locale = config('app.locale');

        $validator = $this->getValidationFactory()->make($request->all(), [
            'translate.' . $locale . '.name' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['nullable', 'string'],
            'translate' => ['array'],
            'translate.*.name' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $translate = (array)$request->get('translate', []);
        FaqGroup::create($translate);

        return redirect()->route('admin.faqGroup.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = FaqGroup::query()->with(['translations'])->findOrFail($id);
        return view($this->viewPath . '.edit', compact('model'));
    }

    public function update($id, Request $request)
    {
        $locale = config('app.locale');

        $validator = $this->getValidationFactory()->make($request->all(), [
            'translate.' . $locale . '.name' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['nullable', 'string'],
            'translate' => ['array'],
            'translate.*.name' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = FaqGroup::query()->findOrFail($id);
        $translate = (array)$request->get('translate', []);
        $model->update($translate);

        return redirect()->route('admin.faqGroup.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = FaqGroup::query()->findOrFail($id);
        $model->delete();

        return redirect()->route('admin.faqGroup.index')->with('success', 'Deleted');
    }
}
