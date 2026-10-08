<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn" style="padding-bottom: 10px;">
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            <div class="layui-inline" style="margin-right: 20px;">
                                <span class="layui-badge layui-bg-blue">总下载次数: {{ $count }}</span>
                            </div>
                            {{ __('ip') }} ：
                            <div class="layui-inline">
                                <input class="layui-input"  id="ip" autocomplete="off">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="record_reload">{{ __('搜索') }}</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{ $id }}" id="id">
                <table id="LAY-app-content-record-list" lay-filter="LAY-app-content-record-list"></table>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.download.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
