<x-layui-layout>

    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn">
                    <div class="test-table-reload-btn layui-form">
                        <div class="layui-nameinput">
                            <div class="layui-name">{{ __('属性名') }}：</div>
                            <div class="layui-inline">
                                <input class="layui-input" id="search_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name">{{ __('分类') }}：</div>
                            <div class="layui-inline">
                                <select id="category_id">
                                    <option value="">{{ __('请选择') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                        </div>
                        <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                    </div>
                </div>

                <div style="padding-bottom: 10px;">

                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.attribute.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
