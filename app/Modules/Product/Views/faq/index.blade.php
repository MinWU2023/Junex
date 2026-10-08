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
                        <form class="test-table-reload-btn layui-form" method="get" action="{{ route('admin.faq.index') }}">
                            {{ __('分组') }}：
                            <div class="layui-inline">
                                <select name="faq_group_id">
                                    <option value="">{{ __('请选择') }}</option>
                                    @foreach(($groups ?? []) as $g)
                                        <option value="{{ $g->id }}" @if((int)($faqGroupId ?? 0)===(int)$g->id) selected @endif>{{ $g->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{ __('问题') }}：
                            <div class="layui-inline">
                                <input class="layui-input" name="subject" value="{{ $subject ?? '' }}" autocomplete="off">
                            </div>

                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('搜索') }}</button>
                            <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.faq.create') }}">{{ __('添加') }}</a>
                            <button class="layui-btn layuiadmin-btn-list" type="button" id="btn-batch-destroy" style="background:#c74a4a;border-color:#c74a4a;">{{ __('批量删除') }}</button>
                            <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.faqGroup.index') }}">{{ __('Faqs分组管理') }}</a>
                            <a class="layui-btn layuiadmin-btn-list" href="{{ route('admin.productFaq.index') }}">{{ __('产品Faqs') }}</a>
                        </form>
                    </div>
                </div>

                <div class="layui-table-box">
                    <table class="layui-table" id="faq-table">
                        <thead>
                        <tr>
                            <th style="width:44px;"><input type="checkbox" id="check-all" title="{{ __('全选') }}"></th>
                            <th>ID</th>
                            <th>{{ __('分组') }}</th>
                            <th>{{ __('问题') }}</th>
                            <th style="width:120px;">{{ __('排序') }}</th>
                            <th>{{ __('更新时间') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td><input type="checkbox" class="row-check" value="{{ $faq->id }}"></td>
                                <td>{{ $faq->id }}</td>
                                <td>{{ $faq->faqGroup->name ?? '' }}</td>
                                <td style="max-width:520px;word-break:break-all;">{{ $faq->subject }}</td>
                                <td>
                                    <input type="number"
                                           class="layui-input js-faq-sort"
                                           data-id="{{ $faq->id }}"
                                           value="{{ (int)($faq->sort ?? 0) }}"
                                           min="0"
                                           step="1"
                                           style="width:90px;height:32px;line-height:32px;"
                                           title="{{ __('回车或失焦保存') }}">
                                </td>
                                <td>{{ $faq->updated_at }}</td>
                                <td>
                                    <a class="layui-btn layui-btn-xs" href="{{ route('admin.faq.edit', $faq->id) }}">{{ __('编辑') }}</a>
                                    <form method="post" action="{{ route('admin.faq.destroy', $faq->id) }}" style="display:inline;" onsubmit="return confirm('{{ __('确定删除？') }}');">
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

                <div>
                    {{ $faqs->links('pagination.front') }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            layui.use(['form', 'jquery', 'layer'], function () {
                var form = layui.form, $ = layui.$, layer = layui.layer;
                form.render();

                var token = $('#token').val();

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

                $('#check-all').on('change', function () {
                    $('.row-check').prop('checked', this.checked);
                });

                $('#btn-batch-destroy').on('click', function () {
                    var ids = [];
                    $('.row-check:checked').each(function () { ids.push(parseInt(this.value, 10)); });
                    if (!ids.length) {
                        layer.msg('{{ __('请先选择要删除的数据') }}');
                        return;
                    }
                    layer.confirm('{{ __('确定批量删除选中的') }} ' + ids.length + ' {{ __('条数据？') }}', function (index) {
                        layer.close(index);
                        var loading = layer.load(1);
                        $.ajax({
                            url: '{{ route('admin.faq.batchDestroy') }}',
                            type: 'POST',
                            data: { _token: token, ids: ids },
                            success: function (res) {
                                layer.close(loading);
                                if (res && res.code === 0) {
                                    layer.msg(res.msg || '{{ __('批量删除成功') }}', { time: 1200 }, function () {
                                        location.reload();
                                    });
                                } else {
                                    layer.msg((res && res.msg) || '{{ __('批量删除失败') }}');
                                }
                            },
                            error: function () {
                                layer.close(loading);
                                layer.msg('{{ __('批量删除失败') }}');
                            }
                        });
                    });
                });

                function saveFaqSort(input) {
                    var id = parseInt(input.getAttribute('data-id'), 10) || 0;
                    var sort = parseInt(input.value, 10);
                    if (!id || isNaN(sort) || sort < 0) {
                        layer.msg('{{ __('排序值无效') }}');
                        return;
                    }
                    $.ajax({
                        url: "{{ route('admin.faq.updateSort', ['id' => '__ID__']) }}".replace('__ID__', id),
                        type: 'POST',
                        data: { _token: token, sort: sort },
                        success: function (res) {
                            if (res && res.code === 0) {
                                layer.msg(res.msg || '{{ __('排序已更新') }}', { time: 800 });
                                if (res.data && typeof res.data.sort !== 'undefined') {
                                    input.value = res.data.sort;
                                }
                            } else {
                                layer.msg((res && res.msg) || '{{ __('保存失败') }}');
                            }
                        },
                        error: function () {
                            layer.msg('{{ __('保存失败') }}');
                        }
                    });
                }

                $(document).on('change', '.js-faq-sort', function () {
                    saveFaqSort(this);
                });
                $(document).on('keydown', '.js-faq-sort', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.blur();
                    }
                });
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
