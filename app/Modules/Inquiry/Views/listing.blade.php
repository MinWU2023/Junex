<x-layui-layout>

    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn" style="margin-bottom:10px;">
                    <div class="test-table-reload-btn layui-form">
                        <div class="layui-nameinput">
                            {{ __('搜索类别') }}：
                            <div class="layui-inline">
                                <select name="sort" id="inquiry_cate" lay-verify="inquiry_cate">
                                    <option value="">{{ __('请选择') }}</option>
                                    <option value="ip">{{ __('ip') }}</option>
                                    <option value="email">{{ __('邮箱') }}</option>
                                    <option value="tel">{{ __('电话') }}</option>
                                </select>
                            </div>
                        </div>
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

                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="show"><i class="icon-eye"></i>{{ __('查看') }}</a>

                    @hasanyrole('超级管理员|网站管理员')
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-bind"></i>{{ __('绑定') }}</a>
                    @endhasanyrole

                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                <script type="text/html" id="is_read">
                    @{{# if(d.reads.length){ }}
                    {{ __('已读') }}
                    @{{# } else { }}
                    {{ __('未读') }}
                    @{{# } }}
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.listing.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
