<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom:15px;">
                    <input type="hidden" value="{{ csrf_token() }}" id="token">
                    {{ __('搜索单页面名') }}：
                    <div class="layui-inline">
                        <input class="layui-input" value="{{ $name }}"  id="search_name" autocomplete="off">
                        <input type="hidden" value="{{ $name }}" id="name">
                    </div>
                    <div class="layui-inline my-box">
                        <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                        <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                        <button type="button" class="layui-btn layui-btn-normal" id="btn-edit-robots">{{ __('修改robot') }}</button>
                    </div>
                </div>
                <input type="hidden" id="is_admin"  value="{{ auth()->id()==1?true:false }}">
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('放入回收站') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.page.js') }}"></script>
        <script>
            layui.use(['layer'], function () {
                var layer = layui.layer;
                var $ = layui.$;
                var robotsUrl = '/{{ trim(config('app.admin_prefix'), '/') }}/page/robots';
                var csrf = $('#token').val();

                $(document).on('click', '#btn-edit-robots', function () {
                    var loading = layer.load();
                    fetch(robotsUrl, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
                    }).then(function (res) {
                        return res.json();
                    }).then(function (data) {
                        layer.close(loading);
                        var original = data.content || '';
                        var useCRLF = original.indexOf('\r\n') !== -1;

                        layer.open({
                            type: 1,
                            title: 'robots.txt',
                            area: ['760px', '600px'],
                            maxmin: true,
                            shadeClose: false,
                            btn: ['{{ __('提交') }}', '{{ __('取消') }}'],
                            content: '<div style="padding:15px;">' +
                                '<textarea id="robots-content" spellcheck="false" wrap="off" ' +
                                'style="width:100%;height:440px;box-sizing:border-box;font-family:Consolas,Monaco,monospace;' +
                                'font-size:13px;line-height:1.5;white-space:pre;overflow:auto;padding:10px;border:1px solid #e6e6e6;resize:none;"></textarea>' +
                                '</div>',
                            success: function () {
                                // 用 .val() 赋值，原样保留换行，不经过 HTML 解析
                                $('#robots-content').val(original);
                            },
                            yes: function (index) {
                                var text = $('#robots-content').val();
                                // 浏览器 textarea 会把换行统一成 \n，原文件是 CRLF 时还原回去
                                if (useCRLF) {
                                    text = text.replace(/\r?\n/g, '\r\n');
                                }
                                var saving = layer.load();
                                fetch(robotsUrl, {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': csrf
                                    },
                                    body: JSON.stringify({content: text})
                                }).then(function (res) {
                                    return res.json().then(function (j) {
                                        return {ok: res.ok, body: j};
                                    });
                                }).then(function (r) {
                                    layer.close(saving);
                                    if (r.ok) {
                                        layer.msg('{{ __('修改成功') }}', {icon: 1, time: 1200});
                                        layer.close(index);
                                    } else {
                                        layer.msg((r.body && r.body.message) || '保存失败', {icon: 2});
                                    }
                                }).catch(function () {
                                    layer.close(saving);
                                    layer.msg('保存失败', {icon: 2});
                                });
                            }
                        });
                    }).catch(function () {
                        layer.close(loading);
                        layer.msg('读取 robots.txt 失败', {icon: 2});
                    });
                });
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
