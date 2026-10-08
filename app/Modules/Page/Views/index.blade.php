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
    @endsection
    </body>
</x-layui-layout>
