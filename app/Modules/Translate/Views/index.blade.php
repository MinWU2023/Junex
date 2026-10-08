<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn" style="padding-bottom: 10px;">
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            {{ __('模型ID') }}：
                            <div class="layui-inline">
                                <input class="layui-input" value=""  id="source_id" autocomplete="off">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="status">
                    @{{#  if(d.status === 0){ }}
                    <p>{{ __('等待翻译') }}</p>
                    @{{#  } else if(d.status === 1){ }}
                    <p>{{ __('翻译成功') }}</p>
                    @{{#  } else { }}
                    <p>{{ __('翻译失败') }}</p>
                    @{{#  } }}
                </script>

{{--                <script type="text/html" id="table-content-list">--}}
{{--                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="translate"><i--}}
{{--                            class="layui-icon layui-icon-refresh"></i>重新翻译</a>--}}
{{--                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="show">查看</a>--}}
{{--                </script>--}}
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.translateJob.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
