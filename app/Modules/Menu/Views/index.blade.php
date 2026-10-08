<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 15px;">
                    <input type="hidden" value="{{ csrf_token() }}" id="token">
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                <script type="text/html" id="icon">
                    <i class="@{{d.icon}}"></i>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.menu.js') }}"></script>
    @endsection

    <style>
        .layui-icon-layer,.layui-icon-file{font-size: 0;}
    </style>

    </body>
</x-layui-layout>
