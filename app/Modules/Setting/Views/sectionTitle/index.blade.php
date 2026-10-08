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
                    <div style="font-size:16px;font-weight:bold;">{{ __('板块标题') }}</div>
                    <div style="margin-top:6px;color:#888;">{{ __('共六个首页板块，仅支持编辑标题与副标题') }}</div>
                </div>

                <div class="layui-table-box">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('板块') }}</th>
                            <th>{{ __('标识') }}</th>
                            <th>{{ __('板块标题') }}</th>
                            <th>{{ __('板块副标题') }}</th>
                            <th>{{ __('排序') }}</th>
                            <th>{{ __('启用') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->sign }}</td>
                                <td>
                                    <div style="width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $item->title }}
                                    </div>
                                </td>
                                <td>
                                    <div style="width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $item->subtitle }}
                                    </div>
                                </td>
                                <td>{{ $item->sort }}</td>
                                <td>{{ $item->active ? __('启用') : __('禁用') }}</td>
                                <td>
                                    <a class="layui-btn layui-btn-xs" href="{{ route('admin.sectionTitle.edit', $item->id) }}">{{ __('编辑') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;">{{ __('暂无数据') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            layui.use(['form'], function () {
                var statusMsg = document.getElementById('status-message');
                if (statusMsg) {
                    setTimeout(function () {
                        statusMsg.style.transition = 'opacity 0.5s ease';
                        statusMsg.style.opacity = '0';
                        setTimeout(function () { statusMsg.style.display = 'none'; }, 500);
                    }, 2000);
                }
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
