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
                        <form class="test-table-reload-btn layui-form" method="get" action="{{ route('admin.snsIcon.index') }}">
                            {{ __('标识') }}：
                            <div class="layui-inline">
                                <input class="layui-input" name="sign" value="{{ $sign ?? '' }}" autocomplete="off" placeholder="twitter">
                            </div>

                            {{ __('静态链接') }}：
                            <div class="layui-inline">
                                <select name="link_active">
                                    <option value="">{{ __('请选择') }}</option>
                                    <option value="1" @if(($linkActive ?? '')==='1' || ($linkActive ?? null)===1) selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if(($linkActive ?? '')==='0' || ($linkActive ?? null)===0) selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>

                            {{ __('分享') }}：
                            <div class="layui-inline">
                                <select name="share_active">
                                    <option value="">{{ __('请选择') }}</option>
                                    <option value="1" @if(($shareActive ?? '')==='1' || ($shareActive ?? null)===1) selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if(($shareActive ?? '')==='0' || ($shareActive ?? null)===0) selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>

                            <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('搜索') }}</button>
                            <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.snsIcon.create') }}">{{ __('添加') }}</a>
                        </form>
                    </div>
                </div>

                <div class="layui-table-box">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('图标') }}</th>
                            <th>{{ __('标识') }}</th>
                            <th>{{ __('Alt') }}</th>
                            <th>{{ __('链接') }}</th>
                            <th>{{ __('排序') }}</th>
                            <th>{{ __('静态链接') }}</th>
                            <th>{{ __('分享') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->path)
                                        <img src="{{ front_image_url($item->path) }}" alt="" style="max-height:36px;max-width:36px;">
                                    @endif
                                </td>
                                <td>{{ $item->sign }}</td>
                                <td>{{ $item->alt }}</td>
                                <td>
                                    <div style="width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $item->link }}
                                    </div>
                                </td>
                                <td>{{ $item->sort }}</td>
                                <td>
                                    <a href="javascript:;"
                                       class="js-sns-toggle layui-badge {{ (int)$item->link_active === 1 ? 'layui-bg-green' : 'layui-bg-gray' }}"
                                       data-id="{{ $item->id }}"
                                       data-field="link_active"
                                       data-value="{{ (int)$item->link_active }}"
                                       style="cursor:pointer;">
                                        {{ (int)$item->link_active === 1 ? __('启用') : __('禁用') }}
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;"
                                       class="js-sns-toggle layui-badge {{ (int)$item->share_active === 1 ? 'layui-bg-blue' : 'layui-bg-gray' }}"
                                       data-id="{{ $item->id }}"
                                       data-field="share_active"
                                       data-value="{{ (int)$item->share_active }}"
                                       style="cursor:pointer;">
                                        {{ (int)$item->share_active === 1 ? __('启用') : __('禁用') }}
                                    </a>
                                </td>
                                <td>
                                    <a class="layui-btn layui-btn-xs" href="{{ route('admin.snsIcon.edit', $item->id) }}">{{ __('编辑') }}</a>
                                    <form method="post" action="{{ route('admin.snsIcon.destroy', $item->id) }}" style="display:inline;" onsubmit="return confirm('Delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="layui-btn layui-btn-danger layui-btn-xs" type="submit">{{ __('删除') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;">{{ __('暂无数据') }}</td>
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
            layui.use(['form', 'jquery', 'layer'], function () {
                var form = layui.form;
                var $ = layui.jquery;
                var layer = layui.layer;
                form.render();

                var statusMsg = document.getElementById('status-message');
                if (statusMsg) {
                    setTimeout(function () {
                        statusMsg.style.transition = 'opacity 0.5s ease';
                        statusMsg.style.opacity = '0';
                        setTimeout(function () { statusMsg.style.display = 'none'; }, 500);
                    }, 2000);
                }

                var toggleUrlTpl = @json(route('admin.snsIcon.toggleStatus', ['id' => '__ID__']));
                var csrf = @json(csrf_token());

                $(document).on('click', '.js-sns-toggle', function () {
                    var $el = $(this);
                    if ($el.data('loading')) return;
                    var id = $el.data('id');
                    var field = $el.data('field');
                    $el.data('loading', 1);

                    $.ajax({
                        url: toggleUrlTpl.replace('__ID__', id),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: csrf,
                            field: field
                        },
                        success: function (res) {
                            if (!res || res.code !== 0) {
                                layer.msg((res && res.msg) ? res.msg : 'Failed', {icon: 5});
                                return;
                            }
                            var val = parseInt(res.data.value, 10) === 1 ? 1 : 0;
                            $el.attr('data-value', val);
                            if (field === 'link_active') {
                                $el.toggleClass('layui-bg-green', val === 1)
                                    .toggleClass('layui-bg-gray', val !== 1);
                            } else {
                                $el.toggleClass('layui-bg-blue', val === 1)
                                    .toggleClass('layui-bg-gray', val !== 1);
                            }
                            $el.text(val === 1 ? @json(__('启用')) : @json(__('禁用')));
                        },
                        error: function () {
                            layer.msg('Failed', {icon: 5});
                        },
                        complete: function () {
                            $el.data('loading', 0);
                        }
                    });
                });
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
