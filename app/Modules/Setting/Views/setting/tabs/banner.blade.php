{{-- Banner设置 --}}
<div class="layui-tab-item">
    <div class="layui-card1">
        <div class="layui-card-body1">
            <div style="padding-bottom: 25px;">
                <input type="hidden" value="{{ csrf_token() }}" id="token">
                <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
            </div>
            <table class="my-special-table" id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
            <script type="text/html" id="table-content-list">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i>{{ __('编辑') }}</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="icon-trash"></i>{{ __('删除') }}</a>
            </script>
            <script type="text/html" id="bannerThumb">
                <img lay-event="layui-img" data-type="showImage" src="@{{d.path}}" alt="">
            </script>
        </div>
    </div>
</div>