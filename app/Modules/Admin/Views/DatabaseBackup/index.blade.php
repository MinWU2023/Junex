<x-layui-layout>
    <style>
        .my-box {
            margin-top: 0px;
        }

        @media screen and (max-width: 1506px) {
            .my-box {
                margin-top: 10px;
            }
        }
    </style>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn" style="margin-bottom:10px;">
                    <div class="test-table-reload-btn layui-form">
                        <input type="hidden" value="{{ csrf_token() }}" id="token">
                        <div class="layui-nameinput">
                            <div class="layui-name">{{ __('状态') }}：</div>
                            <div class="layui-inline">
                                <select name="status" id="status">
                                    <option value="">{{ __('全部') }}</option>
                                    <option value="success" @if(($status ?? '') === 'success') selected @endif>{{ __('成功') }}</option>
                                    <option value="failed" @if(($status ?? '') === 'failed') selected @endif>{{ __('失败') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name">{{ __('类型') }}：</div>
                            <div class="layui-inline">
                                <select name="type" id="type">
                                    <option value="">{{ __('全部') }}</option>
                                    <option value="auto" @if(($type ?? '') === 'auto') selected @endif>{{ __('自动') }}</option>
                                    <option value="manual" @if(($type ?? '') === 'manual') selected @endif>{{ __('手动') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-inline my-box">
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload">
                                    <i class="layui-icon layui-icon-search"></i>{{ __('搜索') }}
                                </button>
                                <button class="layui-btn layui-btn-normal layuiadmin-btn-list" data-type="backup">
                                    <i class="layui-icon layui-icon-upload-drag"></i>{{ __('立即备份') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    {{# if(d.status === 'success'){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="download">
                        <i class="layui-icon layui-icon-download-circle"></i>{{ __('下载') }}
                    </a>
                    {{# } }}
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">
                        <i class="icon-trash"></i>{{ __('删除') }}
                    </a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.databaseBackup.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{ mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
