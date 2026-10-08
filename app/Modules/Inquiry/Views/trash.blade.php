<x-layui-layout>
    <body>
    <style>
        .myInquiry .layui-layer-title {
            position: relative;
            background: #fff;
        }

        .myInquiry .layui-layer-title::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 20px;
            background-color: #4385f6;
            left: 0;
            top: 11px;
        }
    </style>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn" style="padding-bottom:25px;">
                    <div class="test-table-reload-btn layui-form">
                        <div class="layui-inline my-box">
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                        </div>
                        <div class="layui-btn-group test-table-operate-btn">
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleRestore">{{ __('批量恢复') }}</button>
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="multipleDestroy">
                                <i class="icon-trash"></i>{{ __('批量删除') }}
                            </button>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-trash-list" lay-filter="LAY-app-content-trash-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="restore"><i
                            class="icon-trash03"></i>{{ __('恢复') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
                <script type="text/html" id="is_read">
                    @{{#  if(d.reads.length){ }}
                    {{ __('已读') }}
                    @{{#  } else { }}
                    {{ __('未读') }}
                    @{{#  } }}
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.inquiry.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
