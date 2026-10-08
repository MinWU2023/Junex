<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 25px;">
                    <input type="hidden" value="{{ csrf_token() }}" id="token">
                    <div class="layui-inline my-box">
                        <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                        <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="photo"><i class="icon-eye"></i>{{ __('查看图片') }}</a>
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="upload"><i
                            class="icon-upload"></i>{{ __('上传图片') }}</a>
                </script>

                <script type="text/html" id="imgCount">
                    <a lay-href="{{ route('admin.picture.index') }}?album_id=@{{ d.id }}" >@{{ d.img_count }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.album.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
