<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn" style="margin-bottom:10px">
                    <div class="test-table-reload-btn layui-form">
                        <div class="layui-nameinput">
                            <div class="layui-inline my-box">
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                                <input type="hidden" value="{{ csrf_token() }}" id="token">
                                {{--                                <button class="layui-btn layuiadmin-btn-list" data-type="add">添加</button>--}}
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name">{{ __('相册') }}：</div>
                            <div class="layui-inline">
                                <select id="select_album_id" lay-verify="select_admin">
                                    <option value="">{{ __('请选择') }}</option>
                                    @foreach($albums as $album)
                                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                                <span class="layui-btn-group test-table-operate-btn" style="margin-top:0;">
                                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="multipleMoveAlbum">{{ __('批量移动相册') }}</button>
                                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-batchbtn" data-type="multipleMoveRemove"><i class="icon-trash"></i>{{ __('批量删除') }}</button>
                                </span>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{ $album_id }}" id="album_id">
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    {{--                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i--}}
                    {{--                            class="icon-edit02"></i>编辑</a>--}}
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>

                <script type="text/html" id="imageThumb">
                    <img lay-event="layui-img" src="/@{{d.true_path}}" alt="">
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.picture.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
