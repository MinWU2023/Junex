<x-layui-layout x-once>
    <body class="layui-layout-body">
    <div id="LAY_app">
        <div class="layui-layout layui-layout-admin">
            <!-- 头部区域 -->
            <x-admin.layui-header></x-admin.layui-header>
            <!-- 侧边菜单 -->
            <div id="layui-side-menu">
                <x-admin.layui-side-scroll></x-admin.layui-side-scroll>
            </div>
            <!-- 页面标签 -->
            <x-admin.layui-pagetabs></x-admin.layui-pagetabs>

            <!-- 主体内容 -->
            <div class="layui-body" id="LAY_app_body">
                <div class="layadmin-tabsbody-item layui-show">
                    <iframe src="{{ route('admin.report.index') }}" frameborder="0" class="layadmin-iframe"></iframe>
                </div>
            </div>
            <!-- 辅助元素，一般用于移动设备下遮罩 -->
            <div class="layadmin-body-shade" layadmin-event="shade"></div>
        </div>
    </div>

    @section('scripts')
        <script>
            var chat_status = {{ app('settings')['setting']->chat_status }};
            var chat_token = '{{ app('settings')['setting']->chat_token }}';
            var forceChangePassword = "{{ \request()->session()->get('forceChangePassword') }}";

            $(".global-color").on('click', function () {
                let color = $(this).attr('data-color');
                $.ajax({
                    url: '/' + window.admin_prefix + '/globalcolor/' + color,
                    type: 'get',
                    success: function (res) {
                        $("#layui-side-menu").html(res.data);
                        layui.element.init();
                    }
                })
            })


        </script>

        {{--        <script src="{{ asset('js/app.js') }}"></script>--}}
        <script src="{{ asset('/js/admin/admin.dashboard.js') }}"></script>
        <style>
                .layeroHint{padding-bottom:10px;box-sizing: inherit;}
                @media screen and (max-width: 529px) {
                    .layui-layer-iframe.layeroHint{
                        width: 96% !important;
                    }
                }
        </style>
    @endsection
    @if($size_status)
        <script>
            window.onload = function () {
                layer.open({
                    title: false,
                    type: 2,
                    skin: 'no-border', //加上边框
                    content:"/nosay/getSizeContent",
                    area: ['517px!important', '320px'], //宽高
                    success: function(layero, index){
                        parent.layer.iframeAuto(index)
                        layero.addClass('layeroHint')
                    },
                    btn: ['{{ __('知道了') }}']
                });
            }
        </script>
    @endif
    </body>
</x-layui-layout>


