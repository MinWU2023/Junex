<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn" style="padding-bottom: 10px;">
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            {{ __('下载标题') }} ：
                            <div class="layui-inline">
                                <input class="layui-input"  id="search_name" autocomplete="off">
                            </div>
                            {{ __('所属分类') }}：
                            <div class="layui-inline">
                                <x-admin.form-base-category verify="required" name="download_category_id" model="" :modelName="\App\Modules\Download\Models\DownloadCategory::class">
                                </x-admin.form-base-category>
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                            <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                            @if(auth()->user()->id == 1)
                                <button class="layui-btn layuiadmin-btn-list" data-type="reset_download_key">{{ __('重置下载key') }}</button>
                            @endif
                        </div>
                    </div>

                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="icon-edit02"></i>{{ __('编辑') }}</a>
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="download_record">{{ __('下载记录') }}</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="icon-trash"></i>{{ __('删除') }}</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.download.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
