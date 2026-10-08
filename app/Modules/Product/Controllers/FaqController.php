<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\User\Models\Faq;
use App\Modules\User\Models\FaqGroup;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    public function __construct(Faq $faq)
    {
        $this->modelName = 'Faq';
        $this->model = $faq;
        $this->viewPath = 'Product.Views.faq';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();

        $faqGroupId = (int)$request->get('faq_group_id', 0);
        $subject = trim((string)$request->get('subject', ''));

        $query = Faq::query()->with(['translations', 'faqGroup.translations']);

        if ($faqGroupId > 0) {
            $query->where('faq_group_id', $faqGroupId);
        }
        if ($subject !== '') {
            $query->whereTranslationLike('subject', '%' . $subject . '%');
        }

        $faqs = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $groups = FaqGroup::query()
            ->with(['translations'])
            ->orderByDesc('id')
            ->get();

        return view($this->viewPath . '.index', compact('faqs', 'groups', 'faqGroupId', 'subject'));
    }

    public function create()
    {
        $groups = FaqGroup::query()->with(['translations'])->orderByDesc('id')->get();

        return view($this->viewPath . '.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $locale = (string)config('app.locale');
        if ($locale === '') {
            $locale = 'en';
        }

        $validator = $this->getValidationFactory()->make($request->all(), [
            'faq_group_id' => ['required', 'integer', 'min:1', 'exists:faq_groups,id'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'translate.' . $locale . '.subject' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['required', 'string'],
            'translate' => ['array'],
            'translate.*.subject' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $translate = (array)$request->get('translate', []);
        $payload = [
            'faq_group_id' => (int)$request->get('faq_group_id'),
            'sort' => (int)$request->get('sort', 0),
        ];

        Faq::create(array_merge($payload, $translate));

        return redirect()->route('admin.faq.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = Faq::query()->with(['translations', 'faqGroup.translations'])->findOrFail($id);
        $groups = FaqGroup::query()->with(['translations'])->orderByDesc('id')->get();

        return view($this->viewPath . '.edit', compact('model', 'groups'));
    }

    public function update($id, Request $request)
    {
        $locale = (string)config('app.locale');
        if ($locale === '') {
            $locale = 'en';
        }

        $validator = $this->getValidationFactory()->make($request->all(), [
            'faq_group_id' => ['required', 'integer', 'min:1', 'exists:faq_groups,id'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'translate.' . $locale . '.subject' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['required', 'string'],
            'translate' => ['array'],
            'translate.*.subject' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = Faq::query()->findOrFail($id);

        $translate = (array)$request->get('translate', []);
        $payload = [
            'faq_group_id' => (int)$request->get('faq_group_id'),
            'sort' => (int)$request->get('sort', 0),
        ];

        $model->update(array_merge($payload, $translate));

        return redirect()->route('admin.faq.index')->with('success', 'Updated');
    }

    public function updateSort(Request $request, $id)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sort' => ['required', 'integer', 'min:0'],
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 1, 'msg' => $validator->errors()->first()]);
        }

        $model = Faq::query()->findOrFail($id);
        $model->sort = (int)$request->input('sort', 0);
        $model->save();

        return response()->json(['code' => 0, 'msg' => __('排序已更新'), 'data' => ['sort' => (int)$model->sort]]);
    }

    public function destroy($id)
    {
        $model = Faq::query()->findOrFail($id);
        $model->delete();
        return redirect()->route('admin.faq.index')->with('success', 'Deleted');
    }

    public function batchDestroy(Request $request)
    {
        $ids = collect((array)$request->input('ids', []))
            ->map(fn ($v) => (int)$v)
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if ($ids === []) {
            return response()->json(['code' => 1, 'msg' => __('请先选择要删除的数据')]);
        }

        try {
            Faq::query()->whereIn('id', $ids)->delete();
        } catch (\Throwable $e) {
            return response()->json(['code' => 1, 'msg' => __('批量删除失败')]);
        }

        return response()->json(['code' => 0, 'msg' => __('批量删除成功'), 'data' => ['count' => count($ids)]]);
    }
}
