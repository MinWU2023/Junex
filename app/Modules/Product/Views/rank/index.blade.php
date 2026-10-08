<x-layui-layout>
    <body>
    @if($keyword_active)
        <div class="layui-fluid">
            <div class="layui-card">
                <div class="layui-card-body">
                    <div>
                        <div class="test-table-reload-btn layui-form" style="margin-bottom: 10px;">
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <div class="layui-nameinput">
                                <div class="layui-name">{{ __('关键词') }}：</div>
                                <div class="layui-inline">
                                    <input class="layui-input" value="{{ $name }}" name="name" id="name"
                                           autocomplete="off">
                                    <input type="hidden" value="{{ $name }}" id="name">
                                </div>
                                <button class="layui-btn layuiadmin-btn-list" data-type="reload">{{ __('搜索') }}</button>
                            </div>
                        </div>
                    </div>
                    <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
                    <script type="text/html" id="table-content-list">
                        <div class="layui-maxfont">
                            <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="show">{{ __('查看') }}</a>
                        </div>
                    </script>
                    <script type="text/html" id="table-rank">
                        <div class="flex">
                            <p class="num"><a target="_blank" href="@{{d.snapshot}}">@{{d.current_rank}}</a></p>
                            @{{# if(d.discrepancy.type=='up'){ }}
                            <div class="img "><img src="{{ asset('admin/images/svg/up.svg') }}"/></div>
                            <span class="red">@{{ d.discrepancy.num }}</span>
                            @{{# } else if(d.discrepancy.type=='down') { }}
                            <div class="img"><img src="{{ asset('admin/images/svg/down.svg') }}"/></div>
                            <span class="green">@{{ d.discrepancy.num }}</span>
                            @{{# } else { }}
                            @{{# } }}
                        </div>
                    </script>
                </div>
            </div>
        </div>
    @else
        <div class="white_bg" style="position: relative;">
            <div class="module_04 child-boxmask">
                <div class="mian_title">
                    <h2>{{ __('关键词排名') }}</h2>
                </div>
                <div class="key_sm">
                    {{ __('最新关键词排名 Google') }}
                    {{ __('1-10位') }}：<span>1450</span>{{ __('个词') }}。
                </div>
                <div class="table_div">
                    <table>
                        <thead>
                        <tr>
                            <td>{{ __('关键词') }}</td>
                            <td>{{ __('排名URL') }}</td>
                            <td>
                                <div class="san_father">
                                    {{ __('谷歌排名') }}<i class="san_top"></i><i class="san_bot"></i>
                                </div>
                            </td>
                            <td>
                                <div class="san_father">
                                    {{ __('更新时间') }}<i class="san_top"></i><i class="san_bot"></i>
                                </div>
                            </td>
                            <td>{{ __('谷歌快照') }}</td>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i=0;$i<12;$i++)
                        <tr>
                            <td>Sheep Tag 134.2khz Manufacturers</td>
                            <td><a href="#">/hdx-sheep-tag/</a></td>
                            <td>2</td>
                            <td>2023-07-02</td>
                            <td><a href="#">查看</a></td>
                        </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mask-box">
                    <div class="m-box">
                        <div class="ck_div">
                            <p>{{ __('请联系第一页管理员安装关键词插件......') }}</p>
                        </div>
                    </div>
            </div>
        </div>
        <link rel="stylesheet" href="{{ asset('/report/css/versiontwo.css') }}" />
    @endif
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.rank.js') }}"></script>
    @endsection

    <style>

.layui-table .flex{display: -webkit-flex;display: flex;align-items: center;}
.layui-table .flex .img{margin: -2px 3px 0 5px;}
.layui-table .flex .num{display: inline-block;min-width: 24px;}
.layui-table .red{color: #F45B59;}
.layui-table .green{color: #33D0BD;}

    </style>
    </body>
</x-layui-layout>
