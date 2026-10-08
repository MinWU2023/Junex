<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn" style="padding-bottom: 10px;">
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            单页面名 ：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}"  id="search_name" autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload_trash">搜索</button>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-trash-list" lay-filter="LAY-app-content-trash-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="restore"><i
                            class="layui-icon layui-icon-edit"></i>恢复</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="layui-icon layui-icon-delete"></i>删除</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.page.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
