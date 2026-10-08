<x-layui-layout>

    <body>
        <div class="layui-fluid">
            <div class="layui-card">
                <div class="layui-card-body">
                    <div class="table-reload-btn" style="padding-bottom:25px;">
                        <div class="test-table-reload-btn layui-form">
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            {{ __('关键词') }}：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}" name="name" id="name"
                                    autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>
                            <button class="layui-btn layuiadmin-btn-list"
                                data-type="reload">{{ __('搜索') }}</button>
                            <button class="layui-btn layuiadmin-btn-list layui-btn-warm" id="filterHotBtn"
                                data-type="filterHot">{{ __('筛选热门关键词') }}</button>
                            <button class="layui-btn layuiadmin-btn-list layui-btn-primary" id="cancelFilterBtn"
                                data-type="cancelFilter" style="display:none;">{{ __('取消筛选') }}</button>
                            <button class="layui-btn layuiadmin-btn-list layui-batchbtn"
                                data-type="export">{{ __('导出关键词') }}</button>
                            <button class="layui-btn layuiadmin-btn-list layui-batchbtn"
                                data-type="removes">{{ __('清除未关联关键词') }}</button>
                            <div class="layui-nameinput" style="margin-left:10px;margin-bottom: 0;">
                                <div class="layui-name">{{ __('导出语种') }}：</div>
                                <div class="layui-inline">
                                    <select name="export_locale" id="export_locale" lay-verify="export_locale">
                                        <option value="">{{ __('请选择') }}</option>
                                        @foreach ($locales as $locale)
                                            <option value="{{ $locale->language_code }}">{{ $locale->language }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                    <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                    <script type="text/html" id="show_product">
                    <a lay-event="showProducts" href="javascript:;">@{{ d.product_count }}</a>
                </script>
                    <script type="text/html" id="is_hot">
                    @{{#  if(d.is_hot){ }}
                    <a lay-event="edit_hot" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="edit_hot" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('report/js/echarts.js') }}"></script>
        @section('scripts')
            <script src="{{ mix('/js/admin/admin.tag.js') }}"></script>
        @endsection
    </body>
</x-layui-layout>
