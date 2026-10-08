<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom:15px;">
                    <div class="table-reload-btn">
                        <div class="test-table-reload-btn layui-form">
                            url：
                            <div class="layui-inline">
                                <input class="layui-input" value="{{ $url }}"  id="url" autocomplete="off">
                            </div>

                            id：
                            <div class="layui-inline">
                                <input class="layui-input" value=""  id="urlable_id" autocomplete="off">
                            </div>

                            <?php
                            $types = \App\Modules\Url\Models\Url::TYPENAMES;
                            ?>
                            搜索类别：
                            <div class="layui-inline">
                                <select name="urlable_type" id="urlable_type" lay-verify="inquiry_cate">
                                    <option value="">请选择</option>
                                    @foreach($types as $val=>$name)
                                    <option value="{{ $val }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <button class="layui-btn layuiadmin-btn-list" data-type="reload">搜索</button>
                        </div>
                    </div>
                </div>
                <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="is_main">
                    @{{#  if(d.deleted_at){ }}
                    <a  href="javascript:;">是</a>
                    @{{#  } else { }}
                    <a  href="javascript:;">不是</a>
                    @{{#  } }}
                </script>

                <script type="text/html" id="table-content-list">
                    @{{#  if(d.deleted_at){ }}
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i
                            class="icon-trash"></i>删除</a>
                    @{{#  } else { }}
                    <a class="layui-btn layui-btn-danger layui-btn-xs" style="color: red">当前url被使用中，不可删除</a>
                    @{{#  } }}
                </script>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.url.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
