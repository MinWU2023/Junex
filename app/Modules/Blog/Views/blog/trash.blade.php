<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom:25px;">
                    <div class="table-reload-btn">
                        <div class="test-table-reload-btn layui-form">
                            {{ __('博客名') }}：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}" id="search_name" autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload_trash">{{ __('搜索') }}</button>
                        </div>
                    </div>
                </div>
                <div class="layui-btn-group test-table-operate-btn" style="margin-bottom:15px;">
                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleRestore">{{ __('批量恢复') }}</button>
                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="multipleDestroy">
                        <i class="icon-trash"></i>{{ __('批量删除') }}</button>
                </div>
                <table id="LAY-app-content-trash-list" lay-filter="LAY-app-content-trash-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="restore"><i
                            class="icon-trash03"></i>{{ __('恢复') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="con-trash"></i>{{ __('删除') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.blog.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
