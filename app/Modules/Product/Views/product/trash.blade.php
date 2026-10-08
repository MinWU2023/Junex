<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn" style="padding-bottom: 10px;">
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            {{ __('产品名') }}：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}"  id="search_name" autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload_trash">{{ __('搜索') }}</button>
                        </div>
                    </div>
                </div>
                <div class="layui-btn-group test-table-operate-btn" style="margin-bottom: 10px;">
                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleRestore">{{ __('批量恢复') }}</button>
                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="multipleDestroy">
                        <i class="icon-trash"></i>{{ __('批量删除') }}</button>
                </div>
                <table id="LAY-app-content-trash-list" lay-filter="LAY-app-content-trash-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="restore"><i
                            class="icon-trash03"></i>{{ __('恢复') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                <script type="text/html" id="productThumb">
                    <img lay-event="layui-img" data-type="showImage" src="@{{d.path}}" alt="">
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.product.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
