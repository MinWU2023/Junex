<x-layui-layout>

    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn">
                        <div class="test-table-reload-btn layui-form">
                            <div class="layui-nameinput">
                                <div class="layui-name"> {{ __('所属分类') }}：</div>
                                <div class="layui-inline">
                                    <x-admin.form-base-category verify="required" name="article_category_id" model="" :modelName="\App\Modules\Article\Models\ArticleCategory::class">

                                    </x-admin.form-base-category>
                                </div>
                            </div>
                            <div class="layui-nameinput">
                                <div class="layui-name"> {{ __('搜索标题') }}：</div>
                                <div class="layui-inline">
                                    <input class="layui-input" value="{{ $name }}" id="search_name" autocomplete="off">
                                    <input type="hidden" value="{{ $name }}" id="name">
                                </div>
                                <input type="hidden" value="{{ csrf_token() }}" id="token">
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload_draft">{{ __('搜索') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="is_admin" value="{{ auth()->id()==1?true:false }}">
                <table id="LAY-app-content-draft-list" lay-filter="LAY-app-content-draft-list"></table>
                <script type="text/html" id="is_show">
                    @{{# if(d.is_show){ }}
                    <a lay-event="article_show" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{# } else { }}
                    <a lay-event="article_show" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{# } }}
                </script>
                <script type="text/html" id="is_menu">
                    @{{# if(d.is_menu){ }}
                    <a lay-event="article_menu" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{# } else { }}
                    <a lay-event="article_menu" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{# } }}
                </script>
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
                <script type="text/html" id="table-content-list">
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
        <script src="{{ mix('/js/admin/admin.article.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
