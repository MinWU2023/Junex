<x-layui-layout>
    <style>
        .layui-btn-group.test-table-operate-btn {
            margin-top: 10px;
        }

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
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('Path') }}：</div>
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $path ?? '' }}" name="path" id="path" autocomplete="off"
                                       placeholder="{{ __('请输入 path') }}">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('用户') }}：</div>
                            <div class="layui-inline">
                                <select name="user_id" id="user_id">
                                    <option value="">{{ __('全部用户') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($userId == $user->id) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('IP') }}：</div>
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $ip ?? '' }}" name="ip" id="ip" autocomplete="off"
                                       placeholder="{{ __('请输入 IP') }}">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-inline my-box">
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload">
                                    <i class="layui-icon layui-icon-search"></i>{{ __('搜索') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="show"><i
                            class="layui-icon layui-icon-show"></i>{{ __('查看') }}</a>
                </script>
            </div>
        </div>
    </div>
    <style>
        .layui-icon-download-circle:before,.layui-icon-upload-drag:before{padding-right: 3px;}
    </style>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.log.js') }}"></script>
    @endsection
    @section('css')
    <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
