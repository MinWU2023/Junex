<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Blog\Models\Blog;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\ExcitingUpdate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExcitingUpdateController extends BaseController
{
    public function __construct(ExcitingUpdate $excitingUpdate)
    {
        $this->modelName = 'ExcitingUpdate';
        $this->model = $excitingUpdate;
        $this->viewPath = 'Setting.Views.excitingUpdate';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $title = (string)$request->get('title', '');
        $active = $request->get('active');

        $query = ExcitingUpdate::query()->with(['blog.translations', 'blog.url']);

        if ($title !== '') {
            $query->whereHas('blog.translations', function ($q) use ($title) {
                $q->where('name', 'like', '%' . $title . '%');
            });
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
        $blogs = $this->selectableBlogs();
        return view($this->viewPath . '.create', compact('blogs'));
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'blog_id' => [
                'required',
                'integer',
                Rule::exists('blogs', 'id'),
                Rule::unique('exciting_updates', 'blog_id'),
            ],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
        ], [
            'blog_id.unique' => __('该博客已关联，请勿重复添加'),
            'blog_id.required' => __('请选择博客'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        ExcitingUpdate::create([
            'blog_id' => (int)$request->get('blog_id'),
            'sort' => (int)$request->get('sort', 0),
            'active' => (int)$request->get('active', 1),
        ]);

        return redirect()->route('admin.excitingUpdate.index')->with('success', '关联成功');
    }

    public function edit($id)
    {
        $model = ExcitingUpdate::query()->with(['blog.translations'])->findOrFail($id);
        $blogs = $this->selectableBlogs($model->blog_id);
        return view($this->viewPath . '.edit', compact('model', 'blogs'));
    }

    public function update($id, Request $request)
    {
        $model = ExcitingUpdate::query()->findOrFail($id);

        $validator = $this->getValidationFactory()->make($request->all(), [
            'blog_id' => [
                'required',
                'integer',
                Rule::exists('blogs', 'id'),
                Rule::unique('exciting_updates', 'blog_id')->ignore($model->id),
            ],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
        ], [
            'blog_id.unique' => __('该博客已关联，请勿重复添加'),
            'blog_id.required' => __('请选择博客'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model->update([
            'blog_id' => (int)$request->get('blog_id'),
            'sort' => (int)$request->get('sort', 0),
            'active' => (int)$request->get('active', 1),
        ]);

        return redirect()->route('admin.excitingUpdate.index')->with('success', '更新成功');
    }

    public function destroy($id)
    {
        $model = ExcitingUpdate::query()->findOrFail($id);
        // 仅删除关联，不删除博客本身
        $model->delete();
        return redirect()->route('admin.excitingUpdate.index')->with('success', '已取消关联');
    }

    /**
     * Active blogs for select; exclude already linked except current.
     */
    protected function selectableBlogs($keepBlogId = null)
    {
        $linkedIds = ExcitingUpdate::query()
            ->when($keepBlogId, function ($q) use ($keepBlogId) {
                $q->where('blog_id', '<>', (int)$keepBlogId);
            })
            ->whereNotNull('blog_id')
            ->pluck('blog_id')
            ->all();

        return Blog::query()
            ->with(['translations'])
            ->active()
            ->when(!empty($linkedIds), function ($q) use ($linkedIds) {
                $q->whereNotIn('id', $linkedIds);
            })
            ->orderByDesc('id')
            ->limit(500)
            ->get();
    }
}
