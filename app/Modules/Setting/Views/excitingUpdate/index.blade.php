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
                        <form class="test-table-reload-btn layui-form" method="get" action="{{ route('admin.excitingUpdate.index') }}">
                            {{ __('博客标题') }}：
                            <div class="layui-inline">
                                <input class="layui-input" name="title" value="{{ $title ?? '' }}" autocomplete="off">
                            </div>

                            {{ __('启用') }}：
                            <div class="layui-inline">
                                <select name="active">
                                    <option value="">{{ __('请选择') }}</option>
                                    <option value="1" @if(($active ?? '')==='1' || ($active ?? null)===1) selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if(($active ?? '')==='0' || ($active ?? null)===0) selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>

                            <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('搜索') }}</button>
                            <a class="layui-btn layui-btn-primary layuiadmin-btn-list" href="{{ route('admin.excitingUpdate.index') }}">{{ __('重置') }}</a>
                            <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.excitingUpdate.create') }}">{{ __('添加关联') }}</a>
                        </form>
                    </div>
                </div>

                <div class="layui-table-box">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('博客ID') }}</th>
                            <th>{{ __('封面') }}</th>
                            <th>{{ __('博客标题') }}</th>
                            <th>{{ __('日期') }}</th>
                            <th>{{ __('链接') }}</th>
                            <th>{{ __('排序') }}</th>
                            <th>{{ __('启用') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            @php
                                $blog = $item->blog;
                                $cover = $blog && $blog->path ? front_image_url($blog->path) : '';
                                $blogTitle = $blog ? (string)($blog->name ?? '') : '';
                                $blogDate = '';
                                if ($blog && !empty($blog->customer_at)) {
                                    try { $blogDate = \Illuminate\Support\Carbon::parse($blog->customer_at)->format('Y-m-d'); } catch (\Throwable $e) {}
                                }
                                $blogUrl = ($blog && $blog->url) ? ('/' . ltrim($blog->url->url, '/')) : '';
                            @endphp
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->blog_id ?: '-' }}</td>
                                <td>
                                    @if($cover)
                                        <img src="{{ $cover }}" alt="" style="max-height:40px;max-width:80px;">
                                    @endif
                                </td>
                                <td>
                                    <div style="width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $blogTitle ?: __('（博客已删除）') }}
                                    </div>
                                </td>
                                <td>{{ $blogDate }}</td>
                                <td>
                                    <div style="width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $blogUrl }}
                                    </div>
                                </td>
                                <td>{{ $item->sort }}</td>
                                <td>{{ $item->active ? __('启用') : __('禁用') }}</td>
                                <td>
                                    <a class="layui-btn layui-btn-xs" href="{{ route('admin.excitingUpdate.edit', $item->id) }}">{{ __('编辑') }}</a>
                                    <form method="post" action="{{ route('admin.excitingUpdate.destroy', $item->id) }}" style="display:inline;" onsubmit="return confirm('{{ __('仅删除关联，不会删除博客本身，确认？') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="layui-btn layui-btn-danger layui-btn-xs" type="submit">{{ __('取消关联') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;">{{ __('暂无关联博客') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
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
