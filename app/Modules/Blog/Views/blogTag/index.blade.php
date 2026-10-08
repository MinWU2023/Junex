<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="margin-bottom: 20px" class="test-table-reload-btn layui-form">
                    <input type="hidden" value="{{ csrf_token() }}" id="token">
                    {{ __('关键词') }}：
                    <div class="layui-inline">
                        <input class="layui-input" value="{{ $name }}" name="name" id="name" autocomplete="off">
                        <input type="hidden" value="{{ $name }}" id="name">
                    </div>
                    <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                    @role('超级管理员')
                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="export">{{ __('导出关键词') }}</button>
                    @endrole
                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="removes">{{ __('清除未关联关键词') }}</button>
                    @role('超级管理员')
                    <div class="layui-nameinput" style="margin-left:10px;margin-bottom: 0;">
                        <div class="layui-name">{{ __('导出语种') }}：</div>
                        <div class="layui-inline">
                            <select name="export_locale" id="export_locale" lay-verify="export_locale">
                                <option value="">{{ __('请选择语种') }}</option>
                                @foreach($locales as $locale)
                                    <option value="{{$locale->language_code}}">{{$locale->language}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endrole
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                @if(auth()->user()->id == 1)
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i>编辑</a>
                        @endif
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                <script type="text/html" id="blogs">
                    <span><a href="javascript:;" style="margin-left:10px;">@{{ d.blogs.length }}</a></span>
                </script>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('report/js/echarts.js')}}"></script>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.blog.tag.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
