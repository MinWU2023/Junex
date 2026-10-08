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
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload_draft">{{ __('搜索') }}</button>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-draft-list" lay-filter="LAY-app-content-draft-list"></table>

                <script type="text/html" id="scheduled_publish">
                    @{{# if(d.scheduled_publish_at){ }}
                    <a lay-event="set_schedule" href="javascript:;" class="layui-btn layui-btn-xs layui-btn-normal">
                        @{{d.scheduled_publish_at}}
                    </a>
                    @{{# } else { }}
                    <a lay-event="set_schedule" href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary">
                        {{ __('设置定时') }}
                    </a>
                    @{{# } }}
                </script>

                <script type="text/html" id="table-content-draft-list">
                    <div class="layui-maxfont">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i></a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="icon-trash"></i></a>
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
