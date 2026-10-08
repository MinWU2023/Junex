<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <input type="hidden" value="{{ $data['guest'] }}" id="guest">
                <input type="hidden" value="{{ csrf_token() }}" id="token">
                <script type="text/html" id="table-content-list">
                    @{{#  if(d.inject){ }}
                    @{{#  if(d.inject.status === 1){ }}

                    @{{#  if(d.inject.configuration){ }}

                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="layui-icon layui-icon-edit"></i>{{ __('编辑') }}</a>
                    @{{#  } }}
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="uninstall"><i
                            class="layui-icon layui-icon-delete"></i>{{ __('卸载') }}</a>
                    @{{#  } }}
                    @{{#  if(d.inject.status === 2){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event=""><i
                            class="layui-icon layui-icon-add-1"></i>{{ __('安装失败') }}</a>
                    @{{#  } }}
                    @{{#  } else { }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="install"><i
                        class="layui-icon layui-icon-add-1"></i>{{ __('安装') }}</a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="version">
                    @{{#  if(d.is_upgrade){ }}
                    @{{  d.inject.version }} -> @{{  d.version }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="upgrade">{{ __('更新') }}</a>
                    @{{#  } else { }}
                    @{{ d.version }}
{{--                    <a lay-event="product_hot" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>--}}
                    @{{#  } }}
                </script>
                <script type="text/html" id="bannerThumb">
                    <img lay-event="layui-img" data-type="showImage" src="@{{d.img}}" alt="">
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.addonsMarket.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
