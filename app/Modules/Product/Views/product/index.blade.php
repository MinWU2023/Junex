<x-layui-layout>
    <style>
        .layui-btn-group.test-table-operate-btn {
            margin-top: 10px;
        }

        .my-box {
            margin-top: 0px;
        }

        @media screen and (max-width: 1506px) {
            .my-box {
                margin-top: 10px;
            }
        }
    </style>

    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="table-reload-btn" style="margin-bottom:10px;">
                    <div class="test-table-reload-btn layui-form">
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('产品ID') }}：</div>
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $id }}" name="id" id="dom-id" autocomplete="off">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name">{{ __('产品名') }}：</div>
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $name }}" name="name" id="dom-name" autocomplete="off">
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('关键词') }}：</div>

                            <div class="layui-inline">
                                <input class="layui-input" name="keywords" id="dom-keywords" autocomplete="off">
                            </div>
                            <div class="layui-nameinput">
                                <div class="layui-name"> {{ __('属性') }}：</div>
                                <div class="layui-inline">
                                    <input class="layui-input" name="attribute_value" id="dom-attribute_value" autocomplete="off">
                                </div>
                            </div>
                            <div class="layui-nameinput">
                                <div class="layui-name"> {{ __('所属分类') }}：</div>
                                <div class="layui-inline">
                                    <x-admin.form-base-category verify="required" name="category_id" model="" :modelName="\App\Modules\Product\Models\ProductCategory::class">
                                    </x-admin.form-base-category>
                                </div>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('所属品牌') }}：</div>
                            <div class="layui-inline">

                                <x-admin.form-select-brand verify="required" :brand="$productBrand" showLevel0="0"></x-admin.form-select-brand>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                            <div class="layui-name"> {{ __('排序') }}：</div>
                            <div class="layui-inline">
                                <select name="sort" id="product_sort" lay-verify="product_sort">
                                    <option value="">{{ __('请选择') }}</option>
                                    <option value="name-asc">{{ __('产品名称A-Z') }}</option>
                                    <option value="name-desc">{{ __('产品名称Z-A') }}</option>
                                    <option value="created_at-asc">{{ __('已创建（创建时间最早的优先）') }}</option>
                                    <option value="created_at-desc">{{ __('已创建（创建时间最晚的优先）') }}</option>
                                    <option value="updated_at-asc">{{ __('已更新（更新时间最早的优先）') }}</option>
                                    <option value="updated_at-desc">{{ __('已更新（更新时间最晚的优先）') }}</option>

                                    <option value="sort-desc">{{ __('按照排序降序') }}</option>
                                    <option value="sort-asc">{{ __('按照排序升序') }}</option>

                                </select>
                            </div>
                        </div>
                        @if(in_array(auth()->id(),\App\Modules\Admin\Models\User::ALLOW_ADMIN_ID))
                            <div class="layui-nameinput">
                                <div class="layui-name"> {{ __('管理员') }}：</div>
                                <div class="layui-inline">
                                    <select id="select_admin" lay-verify="select_admin">
                                        <option value="">{{ __('请选择') }}</option>
                                        @foreach($admins as $admin)
                                            @continue($admin->id==1)
                                            <option value="{{ $admin->id }}">{{ $admin->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="layui-nameinput">
                            <div class="layui-inline my-box">
                                <input type="checkbox" name="attribute" value="is_new" title="{{ __('最新') }}">
                                <input type="checkbox" name="attribute" value="is_hot" title="{{ __('最热') }}">
                                <input type="checkbox" name="attribute" value="is_recommend" title="{{ __('推荐') }}">
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                                <input type="hidden" value="{{ csrf_token() }}" id="token">
                                <input type="hidden" value="{{ $category_id }}" id="category_id">
                                <input type="hidden" value="{{ $brand_id }}" id="brand_id">
                                <input type="hidden" value="{{ $name }}" id="name">
                                <input type="hidden" value="{{ $id }}" id="id">
                                <button class="layui-btn layuiadmin-btn-list" data-type="add">{{ __('添加') }}</button>
                            </div>
                        </div>
                        <div class="layui-nameinput">
                                <span class="layui-btn-group test-table-operate-btn" style="margin-top:0;">
                                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-framebtn" data-type="multipleMoveCategory">{{ __('批量更改分类') }}</button>
                                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-framebtn" data-type="multipleMoveBrand">{{ __('批量更改品牌') }}</button>
                                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-framebtn" data-type="multipleMoveTrash">{{ __('批量放入回收站') }}</button>
                                    <button class="layui-btn layui-btn-sm layuiadmin-btn-list layui-framebtn" data-type="multipleMoveUser">{{ __('批量移动到子帐户') }}</button>
                                </span>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="is_new">
                    @{{# if(d.is_new){ }}
                    <a lay-event="product_new" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{# } else { }}
                    <a lay-event="product_new" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{# } }}
                </script>
                <script type="text/html" id="is_hot">
                    @{{# if(d.is_hot){ }}
                    <a lay-event="product_hot" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{# } else { }}
                    <a lay-event="product_hot" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{# } }}
                </script>
                <script type="text/html" id="is_recommend">
                    @{{# if(d.is_recommend){ }}
                    <a lay-event="product_recommend" href="javascript:;"><img src="{{ asset('images/yes.gif') }}" alt=""></a>
                    @{{# } else { }}
                    <a lay-event="product_recommend" href="javascript:;"><img src="{{ asset('images/no.gif') }}" alt=""></a>
                    @{{# } }}
                </script>
                <script type="text/html" id="table-content-list">
                    <div class="layui-maxfont">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i></a>
                        <a class="layui-btn layui-btn-success layui-btn-xs" lay-event="copy"><i class="icon-copy"></i></a>
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
                <script type="text/html" id="productThumb">
                    <img lay-event="layui-img" src="@{{d.path}}" alt="">
                </script>
            </div>
        </div>
    </div>
    <style>
        .layui-icon-download-circle:before,.layui-icon-upload-drag:before{padding-right: 3px;}
    </style>
    @section('scripts')
        @if (file_exists(public_path('mix-manifest.json')))
            <script src="{{ mix('/js/admin/admin.product.js') }}"></script>
        @endif
    @endsection
    @section('css')
        @if (file_exists(public_path('mix-manifest.json')))
            <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
        @endif
    @endsection
    </body>
</x-layui-layout>
