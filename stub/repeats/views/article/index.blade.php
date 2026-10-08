<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <div class="table-reload-btn" style="padding-bottom: 10px;">
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            所属分类：
                            <div class="layui-inline">

                                <x-admin.form-base-category verify="required" name="article_category_id" model="" :modelName="\App\Modules\Article\Models\ArticleCategory::class">

                                </x-admin.form-base-category>
                            </div>

                            搜索标题：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}"  id="search_name" autocomplete="off">
                                <input type="hidden" value="{{ $name }}" id="name">
                            </div>


                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">搜索</button>
                            <button class="layui-btn layuiadmin-btn-list" data-type="add">添加</button>
                        </div>
                        <span class="layui-btn-group test-table-operate-btn">
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleMoveTrash">批量放入回收站</button>
                        </span>
                    </div>

                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="is_show">
                    @{{#  if(d.is_show){ }}
                    <a lay-event="article_show" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="article_show" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="is_menu">
                    @{{#  if(d.is_menu){ }}
                    <a lay-event="article_menu" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="article_menu" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="remove"><i
                            class="layui-icon layui-icon-delete"></i>放入回收站</a>
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.article.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
