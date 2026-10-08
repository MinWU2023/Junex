<x-layui-layout>

    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div>
                    <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                        <input type="hidden" value="{{ csrf_token() }}" id="token">
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('所属分类') }}：</div>
                            <div class="layui-inline">
                                <x-admin.form-base-category verify="required" name="blog_category_id" model="" :modelName="\App\Modules\Blog\Models\BlogCategory::class">

                                </x-admin.form-base-category>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('博客标题') }}：</div>
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}" name="name" id="name" autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                        </div>
                        <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                        <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-framebtn" data-type="multipleMoveTrash"><i class="icon-trash"></i>{{ __('批量放入回收站') }}</button>

                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>

                <script type="text/html" id="table-content-list">
                    <div class="layui-maxfont">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i></a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i class="icon-trash"></i></a>
                    </div>
                    <div class="renew-box">
                        <p>{{ __('更新时间') }}: @{{d.updated_at}}</p>
                        <p>{{ __('发布时间') }}: @{{d.created_at}}</p>
                        @{{# if(d.admin){ }}
                        <p>{{ __('账户') }}: @{{d.admin.name}}</p>
                        @{{# } }}
                    </div>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.blog.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
