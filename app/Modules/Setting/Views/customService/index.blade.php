<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-header" style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;height:auto;line-height:1.4;box-sizing:border-box;">
                <span style="font-size:16px;font-weight:600;padding-left:2px;">{{ __('定制服务') }}</span>
                <span class="layui-badge-rim" style="border-color:#e6e6e6;color:#888;padding:4px 10px;line-height:1.4;height:auto;">{{ __('Junex Custom Service') }}</span>
            </div>
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

                <div class="table-reload-btn" style="padding-bottom:16px;">
                    <form class="test-table-reload-btn layui-form" method="get" action="{{ route('admin.customService.index') }}" style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;">
                        <div class="layui-inline" style="margin:0;">
                            <label style="margin-right:6px;color:#666;">{{ __('关键词') }}</label>
                            <div class="layui-input-inline" style="width:180px;margin:0;">
                                <input class="layui-input" name="keyword" value="{{ $keyword ?? '' }}" placeholder="{{ __('标识 / 标题') }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="layui-inline" style="margin:0;">
                            <label style="margin-right:6px;color:#666;">{{ __('启用') }}</label>
                            <div class="layui-input-inline" style="width:120px;margin:0;">
                                <select name="active">
                                    <option value="">{{ __('全部') }}</option>
                                    <option value="1" @if(($active ?? '')==='1' || ($active ?? null)===1) selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if(($active ?? '')==='0' || ($active ?? null)===0) selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>
                        </div>

                        <button class="layui-btn layuiadmin-btn-list" type="submit">
                            <i class="layui-icon layui-icon-search"></i> {{ __('搜索') }}
                        </button>
                        <a class="layui-btn layui-btn-primary layuiadmin-btn-list" href="{{ route('admin.customService.index') }}">
                            <i class="layui-icon layui-icon-refresh"></i> {{ __('重置') }}
                        </a>
                        <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.customService.create') }}" style="margin-left:auto;">
                            <i class="layui-icon layui-icon-add-1"></i> {{ __('添加一级列') }}
                        </a>
                    </form>
                </div>

                <div class="layui-table-box">
                    <table class="layui-table" lay-skin="line">
                        <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th style="width:90px;">{{ __('背景') }}</th>
                            <th style="width:90px;">{{ __('标识') }}</th>
                            <th>{{ __('标题') }}</th>
                            <th style="width:90px;">{{ __('布局') }}</th>
                            <th style="width:90px;">{{ __('二级项数') }}</th>
                            <th style="width:80px;">{{ __('排序') }}</th>
                            <th style="width:90px;">{{ __('状态') }}</th>
                            <th style="width:160px;">{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->bg_image)
                                        <img src="{{ front_image_url($item->bg_image) }}" alt=""
                                             style="width:56px;height:40px;object-fit:cover;border-radius:3px;border:1px solid #eee;background:#fafafa;">
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="layui-badge layui-bg-blue" style="text-transform:uppercase;">{{ $item->code }}</span>
                                </td>
                                <td>
                                    <div style="line-height:1.5;">
                                        <div style="font-weight:600;">
                                            <span style="color:#FF5722;">{{ $item->title_prefix }}</span>
                                            <span style="color:#333;"> {{ $item->title_suffix }}</span>
                                        </div>
                                        @if($item->subtitle)
                                            <div style="color:#999;font-size:12px;margin-top:2px;">{{ $item->subtitle }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($item->layout === 'list')
                                        <span class="layui-badge-rim" style="color:#1E9FFF;border-color:#1E9FFF;">{{ __('列表') }}</span>
                                    @else
                                        <span class="layui-badge-rim" style="color:#009688;border-color:#009688;">{{ __('网格') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="layui-badge layui-bg-gray">{{ $item->items->count() }}</span>
                                </td>
                                <td>{{ $item->sort }}</td>
                                <td>
                                    @if($item->active)
                                        <span class="layui-badge layui-bg-green">{{ __('启用') }}</span>
                                    @else
                                        <span class="layui-badge">{{ __('禁用') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        <a class="layui-btn layui-btn-normal layui-btn-xs" href="{{ route('admin.customService.edit', $item->id) }}">
                                            <i class="layui-icon layui-icon-edit"></i> {{ __('编辑') }}
                                        </a>
                                        <form method="post" action="{{ route('admin.customService.destroy', $item->id) }}" style="display:inline;margin:0;" onsubmit="return confirm('{{ __('确定删除该一级列及其全部二级项？') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="layui-btn layui-btn-danger layui-btn-xs" type="submit">
                                                <i class="layui-icon layui-icon-delete"></i> {{ __('删除') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;padding:40px 0;color:#999;">
                                    <i class="layui-icon layui-icon-face-surprised" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                    {{ __('暂无数据，请点击右上角添加一级列') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:12px;">
                    {{ $items->links('pagination.front') }}
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
