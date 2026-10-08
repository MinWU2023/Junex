<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <input type="hidden" value="{{ csrf_token() }}" id="token">
                </div>
                <table data-id="{{ $id }}" id="LAY-app-products-content-list" lay-filter="LAY-app-products-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="layui-icon layui-icon-delete"></i>{{ __('解除关联') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.blog.tag.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
