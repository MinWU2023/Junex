<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                @if(session('success') || session('error') || $errors->any())
                    <div id="status-message" style="
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
                            <i class="layui-icon layui-icon-ok-circle" style="margin-right: 8px;"></i>
                            {{ session('success') }}
                        @elseif(session('error'))
                            <i class="layui-icon layui-icon-close-fill" style="margin-right: 8px;"></i>
                            {{ session('error') }}
                        @elseif($errors->any())
                            <i class="layui-icon layui-icon-close-fill" style="margin-right: 8px;"></i>
                            {{ $errors->first() }}
                        @endif
                    </div>
                @endif

                <div style="padding-bottom:15px;">
                    <div class="table-reload-btn">
                        <form class="test-table-reload-btn layui-form" method="get" action="{{ route('admin.faqGroup.index') }}">
                            {{ __('名称') }}：
                            <div class="layui-inline">
                                <input class="layui-input" name="name" value="{{ $name ?? '' }}" autocomplete="off">
                            </div>

                            <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('搜索') }}</button>
                            <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.faqGroup.create') }}">{{ __('添加') }}</a>
                        </form>
                    </div>
                </div>

                <div class="layui-table-box">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('名称') }}</th>
                            <th>{{ __('更新时间') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($groups as $g)
                            <tr>
                                <td>{{ $g->id }}</td>
                                <td style="max-width:520px;word-break:break-all;">{{ $g->name }}</td>
                                <td>{{ $g->updated_at }}</td>
                                <td>
                                    <a class="layui-btn layui-btn-xs" href="{{ route('admin.faqGroup.edit', $g->id) }}">{{ __('编辑') }}</a>
                                    <form method="post" action="{{ route('admin.faqGroup.destroy', $g->id) }}" style="display:inline;" onsubmit="return confirm('Delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="layui-btn layui-btn-danger layui-btn-xs" type="submit">{{ __('删除') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;">{{ __('暂无数据') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $groups->links('pagination.front') }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            layui.use(['form'], function () {
                var form = layui.form;
                form.render();

                var statusMsg = document.getElementById('status-message');
                if (statusMsg) {
                    setTimeout(function() {
                        statusMsg.style.transition = 'opacity 0.5s ease';
                        statusMsg.style.opacity = '0';
                        setTimeout(function() {
                            statusMsg.style.display = 'none';
                        }, 500);
                    }, 2000);
                }
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
