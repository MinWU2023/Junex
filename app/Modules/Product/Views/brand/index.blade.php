<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom:25px;">
                    <div class="table-reload-btn">
                        <div class="test-table-reload-btn layui-form">
                            {{ __('品牌名') }}：
                            <div class="layui-inline">
                                <input class="layui-input"  id="search_name" autocomplete="off">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                            <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>

                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
            </div>
        </div>
        <script type="text/html" id="products">
            <a lay-href="{{ route('admin.product.index') }}?brand_id=@{{ d.id }}">@{{ d.products.length }}</a>
        </script>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.brand.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
