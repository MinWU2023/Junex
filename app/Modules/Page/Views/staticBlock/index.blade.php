<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                @if(session('success') || session('error') || $errors->any())
                    <div id="status-message" style="padding:10px 16px;margin-bottom:16px;border-radius:4px;font-size:14px;line-height:1.4;
                        @if(session('success')) background-color:#f0f9eb;color:#67c23a;border:1px solid #e1f3d8;
                        @else background-color:#fef0f0;color:#f56c6c;border:1px solid #fde2e2; @endif">
                        @if(session('success'))
                            {{ session('success') }}
                        @elseif(session('error'))
                            {{ session('error') }}
                        @elseif($errors->any())
                            {{ $errors->first() }}
                        @endif
                    </div>
                @endif

                <div style="padding-bottom:15px;">
                    <form class="layui-form" method="get" action="{{ route('admin.staticBlock.index') }}">
                        {{ __('标题') }}：
                        <div class="layui-inline">
                            <input class="layui-input" name="title" value="{{ $title ?? '' }}" autocomplete="off">
                        </div>
                        {{ __('标识') }}：
                        <div class="layui-inline">
                            <input class="layui-input" name="sign" value="{{ $sign ?? '' }}" autocomplete="off">
                        </div>
                        {{ __('单页面') }}：
                        <div class="layui-inline">
                            <select name="page_id" lay-search>
                                <option value="">{{ __('请选择') }}</option>
                                @foreach(($allPages ?? []) as $page)
                                    <option value="{{ $page->id }}" @if((int)($pageId ?? 0)===(int)$page->id) selected @endif>
                                        {{ $page->name }} ({{ $page->url_key }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{ __('虚拟页') }}：
                        <div class="layui-inline">
                            <select name="page_key" lay-search>
                                <option value="">{{ __('请选择') }}</option>
                                @foreach(($virtualPages ?? []) as $virtual)
                                    <option value="{{ $virtual['key'] }}" @if(($pageKey ?? '')===$virtual['key']) selected @endif>
                                        {{ $virtual['name'] }} ({{ $virtual['key'] }})
                                    </option>
                                @endforeach
                                @foreach(($categoryPages ?? []) as $category)
                                    <option value="{{ $category['key'] }}" @if(($pageKey ?? '')===$category['key']) selected @endif>
                                        {{ $category['name'] }} [{{ __('产品分类') }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{ __('启用') }}：
                        <div class="layui-inline">
                            <select name="active">
                                <option value="">{{ __('请选择') }}</option>
                                <option value="1" @if(($active ?? '')==='1' || ($active ?? null)===1) selected @endif>{{ __('启用') }}</option>
                                <option value="0" @if(($active ?? '')==='0' || ($active ?? null)===0) selected @endif>{{ __('禁用') }}</option>
                            </select>
                        </div>
                        <button class="layui-btn" type="submit">{{ __('搜索') }}</button>
                        <a class="layui-btn layui-btn-primary" href="{{ route('admin.staticBlock.index') }}">{{ __('重置') }}</a>
                        <a class="layui-btn" href="{{ route('admin.staticBlock.create') }}">{{ __('添加') }}</a>
                    </form>
                </div>

                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('标识') }}</th>
                        <th>{{ __('标题') }}</th>
                        <th>{{ __('关联单页面') }}</th>
                        <th>{{ __('排序') }}</th>
                        <th>{{ __('启用') }}</th>
                        <th>{{ __('操作') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->sign }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                @php
                                    $realNames = $item->pages->map(function ($p) { return $p->name ?: $p->url_key; })->filter()->all();
                                    $virtualMap = collect($virtualPages ?? [])->keyBy('key');
                                    $categoryMap = collect($categoryPages ?? [])->keyBy('key');
                                    $pageKeyRows = $item->relationLoaded('pageKeys') ? $item->pageKeys : collect();
                                    $virtualNames = $pageKeyRows->map(function ($row) use ($virtualMap, $categoryMap) {
                                        $key = trim((string)$row->page_key, '/');
                                        if ($categoryMap->has($key)) {
                                            return ($categoryMap->get($key)['name'] ?? $key) . '[产品分类]';
                                        }
                                        $label = optional($virtualMap->get($key))['name'] ?? $key;
                                        return $label . '[虚拟]';
                                    })->filter()->all();
                                    $names = implode('、', array_merge($realNames, $virtualNames));
                                @endphp
                                {{ $names !== '' ? $names : '-' }}
                            </td>
                            <td>{{ $item->sort }}</td>
                            <td>{{ $item->active ? __('启用') : __('禁用') }}</td>
                            <td>
                                <a class="layui-btn layui-btn-xs" href="{{ route('admin.staticBlock.edit', $item->id) }}">{{ __('编辑') }}</a>
                                <form method="post" action="{{ route('admin.staticBlock.destroy', $item->id) }}" style="display:inline;" onsubmit="return confirm('{{ __('确认删除？') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="layui-btn layui-btn-danger layui-btn-xs" type="submit">{{ __('删除') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;">{{ __('暂无数据') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div>{{ $items->links('pagination.front') }}</div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            layui.use(['form'], function () {
                layui.form.render();
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
