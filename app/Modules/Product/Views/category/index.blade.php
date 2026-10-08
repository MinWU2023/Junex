<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom:15px;">
                    <div class="table-reload-btn">
                        <div class="test-table-reload-btn layui-form">
                            {{ __('分类名') }}：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}"  id="search_name" autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                            <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="is_admin"  value="{{ auth()->id()==1?true:false }}">
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="is_show">
                    @{{#  if(d.is_show){ }}
                    <a lay-event="category_show" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="category_show" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="is_menu">
                    @{{#  if(d.is_menu){ }}
                    <a lay-event="category_menu" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="category_menu" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="products">
                    <a lay-href="{{ route('admin.product.index') }}?category_id=@{{ d.id }}">@{{ d.product_count }}</a>
                </script>

                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.category.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
