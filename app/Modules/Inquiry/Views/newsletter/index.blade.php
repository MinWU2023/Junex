<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">

            <div class="table-reload-btn" style="margin-bottom:10px;">
                    <div class="test-table-reload-btn layui-form">
                        <div class="layui-nameinput">
                            {{ __('搜索内容') }}：
                            <div class="layui-inline">
                                <input class="layui-input" name="q" id="search_q" autocomplete="off">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            {{ __('开始时间') }}：
                            <div class="layui-inline">
                                <input type="text" class="layui-input" id="start_time" placeholder="{{ __('开始时间') }}">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            {{ __('结束时间') }}：
                            <div class="layui-inline">
                                <input type="text" class="layui-input" id="end_time" placeholder="{{ __('结束时间') }}">
                            </div>
                        </div>

                        <div class="layui-inline my-box">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                        </div>

                        <span class="layui-btn-group test-table-operate-btn" style="margin-left:8px;">
                            <button class="layui-btn layuiadmin-btn-list layui-batchbtn" data-type="exportSelected">{{ __('导出选中') }}</button>
                            <button class="layui-btn layuiadmin-btn-list layui-batchbtn" data-type="exportAll">{{ __('导出所有') }}</button>
                        </span>

                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.newsletter.js') }}"></script>
    @endsection
    </body>
    <style>
        .layui-table-view .layui-table{width:100%;}
    </style>
</x-layui-layout>
