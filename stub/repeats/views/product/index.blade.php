<x-layui-layout>
    <style>
        .layui-btn-group.test-table-operate-btn{
            margin-top: 10px;
        }
        .my-box{
            margin-top: 0px;
        }

        @media screen and (max-width: 1506px) {
            .my-box{
                margin-top: 10px;
            }
        }
    </style>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn" style="padding-bottom: 10px;">
                    <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                        产品名：
                        <div class="layui-inline">
                            <input class="layui-input" value="{{ $name }}" name="name" id="dom-name" autocomplete="off">
                        </div>
                        关键词：
                        <div class="layui-inline">
                            <input class="layui-input" name="keywords" id="dom-keywords" autocomplete="off">
                        </div>
                        所属分类：
                        <div class="layui-inline">
                            <x-admin.form-select-category cate="product" :category="$productCategory"
                                                          showLevel0="0"></x-admin.form-select-category>
                        </div>
                        所属品牌：
                        <div class="layui-inline">
                            <x-admin.form-select-brand verify="required" :brand="$productBrand"
                                                       showLevel0="0"></x-admin.form-select-brand>
                        </div>
                        排序：
                        <div class="layui-inline">
                            <select name="sort" id="product_sort" lay-verify="product_sort">
                                <option value="">请选择</option>
                                <option value="name-asc">产品名称A-Z</option>
                                <option value="name-desc">产品名称Z-A</option>
                                <option value="created_at-asc">已创建（创建时间最早的优先）</option>
                                <option value="created_at-desc">已创建（创建时间最晚的优先）</option>
                                <option value="updated_at-asc">已更新（更新时间最早的优先）</option>
                                <option value="updated_at-desc">已更新（更新时间最晚的优先）</option>
                            </select>
                        </div>
                        <div class="layui-inline my-box">
                            <input type="checkbox" name="attribute" value="is_new" title="最新">
                            <input type="checkbox" name="attribute" value="is_hot" title="最热">
                            <input type="checkbox" name="attribute" value="is_recommend" title="推荐">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">搜索</button>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <input type="hidden" value="{{ $category_id }}" id="category_id">
                            <input type="hidden" value="{{ $brand_id }}" id="brand_id">
                            <input type="hidden" value="{{ $name }}" id="name">
                            <button class="layui-btn layuiadmin-btn-list" data-type="add">添加</button>
                        </div>
                        <span class="layui-btn-group test-table-operate-btn">
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleMoveCategory">批量更改分类</button>
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleMoveBrand">批量更改品牌</button>
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleMoveTrash">批量放入回收站</button>
                            <button class="layui-btn layui-btn-sm layuiadmin-btn-list" data-type="multipleMoveUser">批量移动到子帐户</button>
                        </span>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list" ></table>
                <script type="text/html" id="is_new">
                    @{{#  if(d.is_new){ }}
                    <a lay-event="product_new" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="product_new" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="is_hot">
                    @{{#  if(d.is_hot){ }}
                    <a lay-event="product_hot" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="product_hot" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="is_recommend">
                    @{{#  if(d.is_recommend){ }}
                    <a lay-event="product_recommend" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{#  } else { }}
                    <a lay-event="product_recommend" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{#  } }}
                </script>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i
                            class="layui-icon layui-icon-edit"></i></a>
                    <a class="layui-btn layui-btn-success layui-btn-xs" lay-event="copy"><i
                            class="layui-icon layui-icon-file-b"></i></a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="layui-icon layui-icon-delete"></i></a>
                    <p>更新时间: @{{d.updated_at}}</p>
                    <p>发布时间: @{{d.created_at}}</p>
                </script>
                <script type="text/html" id="productThumb">
                    <img lay-event="layui-img" src="@{{d.path}}" alt="">
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.product.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>


