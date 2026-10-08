<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                @if(session('success') || session('error') || $errors->any())
                    <div style="
                        padding: 10px 16px;
                        margin-bottom: 16px;
                        border-radius: 4px;
                        font-size: 14px;
                        line-height: 1.4;
                        @if(session('success'))
                            background-color: #f0f9eb;
                            color: #67c23a;
                            border: 1px solid #e1f3d8;
                        @else
                            background-color: #fef0f0;
                            color: #f56c6c;
                            border: 1px solid #fde2e2;
                        @endif
                    ">
                        @if(session('success'))
                            {{ session('success') }}
                        @elseif(session('error'))
                            {{ session('error') }}
                        @elseif($errors->any())
                            {{ $errors->first() }}
                        @endif
                    </div>
                @endif
                <div style="padding-bottom:15px;" class="table-reload-btn">
                    <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.productVideoCategory.create') }}">{{ __('添加') }}</a>
                </div>
                <div class="layui-table-box">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('封面') }}</th>
                            <th>{{ __('名称') }}</th>
                            <th>{{ __('URL') }}</th>
                            <th>{{ __('排序') }}</th>
                            <th>{{ __('启用') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->path)
                                        <img src="{{ $item->path }}" alt="" style="max-height:40px;max-width:80px;">
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->url_key }}</td>
                                <td>{{ $item->sort }}</td>
                                <td>{{ $item->active ? __('启用') : __('禁用') }}</td>
                                <td>
                                    <a class="layui-btn layui-btn-xs" href="{{ route('admin.productVideoCategory.edit', $item->id) }}">{{ __('编辑') }}</a>
                                    <form method="post" action="{{ route('admin.productVideoCategory.destroy', $item->id) }}" style="display:inline;" onsubmit="return confirm('{{ __('确认删除？') }}');">
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
                </div>
                <div>{{ $items->links('pagination.front') }}</div>
            </div>
        </div>
    </div>
    </body>
</x-layui-layout>
