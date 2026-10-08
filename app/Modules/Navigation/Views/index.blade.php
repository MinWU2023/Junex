<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <input type="hidden" value="{{ csrf_token() }}" id="token">
                <div class="layui-tab layui-tab-brief" lay-filter="nav-area-tabs">
                    <ul class="layui-tab-title">
                        <li class="layui-this" data-area="头部">{{ __('头部导航') }}</li>
                        <li data-area="底部">{{ __('底部导航') }}</li>
                    </ul>
                    <div class="layui-tab-content" style="padding-top:15px;">
                        <div class="layui-tab-item layui-show">
                            <div style="padding-bottom:10px;">
                                {{ __('名称') }}：
                                <div class="layui-inline">
                                    <input class="layui-input" id="search_name_head" autocomplete="off">
                                </div>
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload" data-area="头部">{{ __('搜索') }}</button>
                                <button class="layui-btn layuiadmin-btn-list" data-type="add" data-area="头部">{{ __('添加') }}</button>
                            </div>
                            <table id="LAY-nav-head" lay-filter="LAY-nav-head"></table>
                        </div>
                        <div class="layui-tab-item">
                            <div style="padding-bottom:10px;">
                                {{ __('名称') }}：
                                <div class="layui-inline">
                                    <input class="layui-input" id="search_name_foot" autocomplete="off">
                                </div>
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload" data-area="底部">{{ __('搜索') }}</button>
                                <button class="layui-btn layuiadmin-btn-list" data-type="add" data-area="底部">{{ __('添加') }}</button>
                            </div>
                            <table id="LAY-nav-foot" lay-filter="LAY-nav-foot"></table>
                        </div>
                    </div>
                </div>

                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete"><i class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                <script type="text/html" id="is_new">
                    @{{#  if(d.is_new){ }}
                    <a lay-event="event_new" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="event_new" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="is_show">
                    @{{#  if(d.is_show){ }}
                    <a lay-event="event_show" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="event_show" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="is_nofollow">
                    @{{#  if(d.is_nofollow){ }}
                    <a lay-event="event_nofollow" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="event_nofollow" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.navigation.js') }}?v=20260814"></script>
    @endsection
    </body>
</x-layui-layout>
