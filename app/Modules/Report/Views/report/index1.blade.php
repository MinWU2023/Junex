<link rel="stylesheet" href="{{asset('/css/admin/admin.public.css')}}">
<link rel="stylesheet" href="{{ asset('/report/css/report.css') }}">
<script type="text/javascript" src="{{asset('/js/admin/admin.public.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    var tData = {!! $data !!};
    layui.data('myTableDdata',{
        key: 'data',
        value: tData,
    });
</script>
<div class="container">
    <div class="top-box">
        <div class="base-info">
            <h3 class="title">网站基本信息
{{--                <button type="button" class="layui-btn layui-hide" id="export-pdf">导出数据</button>--}}
            </h3>
            <div class="my-info-box">
                <div class="inner-box">
                    <div class="main-box">
                        <div class="company">
                            <img src="{{ asset('/report/images/c.png') }}" class="c-img">
                            <div class="info-box">
                                <h3 class="c-name">欢迎您：{{!is_null($website_info) ? $website_info['company_name'] : ''}}</h3>
                                <p class="s-text">所属服务：{{!is_null($website_info) ? $website_info['belongs_service'] : ''}}</p>
                            </div>
                        </div>
                        <div class="cooperate">
                            <p class="s-num">{{!is_null($website_info) ? ($website_info['cooperation_year'] > 0 ? $website_info['cooperation_year']:'<1') : ''}}<span class="s-time">年</span></p>
                            <p class="s-text">合作年限</p>
                        </div>
                        <div class="surplus">
                            <p class="s-num">{{!is_null($website_info) ? $website_info['expiration_day'] : ''}}<span class="s-time">天(剩余)</span></p>
                            <p class="s-text">到期日{{!is_null($website_info) ? $website_info['expiration_time'] : ''}}</p>
                        </div>
                    </div>
                    <div class="slide-box">
                        <ul>
                            <li class="s-item">
                                <h3 class="s-title">今日数据总概</h3>
                                <p class="weight">网站域名权重：</p>
                                 <p class="s-text">谷歌首页且排在第{{$site_count_data['weight_rank']}}位</p>
                            </li>
                            <li class="s-item">
                                <p class="s-num">{{ $site_count_data['main_web_rank'] }}</p>
                                <p class="s-text">主网站收录</p>
                            </li>
                            <li class="s-item">
                                <p class="s-num">{{$site_count_data['web_rank']}}</p>
                                <p class="s-text">网站总收录</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="i-box">
                <div class="item">
                    <div class="slide">
                        <i class="r-img">
                            <i class="icon-01n_icon4"></i>
                        </i>
                        <h3 class="num info-num">0</h3>
                        <p class="text">产品总数</p>
                    </div>
                    <div class="p-main">
                        <div id="myCharts1" class="myChartsBox"></div>
                    </div>
                </div>
                <div class="item two-item">
                    <div class="slide">
                        <i class="r-img">
                            <i class="icon-01n_icon2"></i>
                        </i>
                        <h3 class="num inquiry-num">0</h3>
                        <p class="text">询盘总数</p>
                    </div>
                    <div class="p-main">
                        <div id="myCharts2" class="myChartsBox"></div>
                    </div>
                </div>
                <div class="item three-item">
                    <div class="slide">
                        <i class="r-img">
                            <i class="icon-01n_icon3"></i>
                        </i>
                        <h3 class="num article-num">0</h3>
                        <p class="text">文章总数</p>
                    </div>
                    <div class="p-main">
                        <div id="myCharts3" class="myChartsBox"></div>
                    </div>
                </div>
                <div class="item four-item">
                    <div class="slide">
                        <i class="r-img">
                            <i class="icon-01n_icon5"></i>
                        </i>
                        <h3 class="num siteCount-num">0</h3>
                        <p class="text">收录总数</p>
                    </div>
                    <div class="p-main">
                        <div id="myCharts4" class="myChartsBox"></div>
                    </div>
                </div>
            </div>
            <div class="contact">
                <ul class="list">
                    <li class="c-item add-pos">
                        <i class="icon-box">
                            <i class="icon-01n_icon6"></i>
                        </i>
                        <p class="name">客服经理</p>
                    </li>
                    <li class="add-pos">
                        <i class="icon-box">
                            <i class="icon-01n_icon8"></i>
                        </i>
                        <div class="tel-box">
                            <p class="name">TEL:</p>
                            <p class="name">{{!is_null($website_info) ? $website_info['customer_manager_tel'] : ''}}</p>
                        </div>
                    </li>
                    <li class="email-box">
                        <i class="icon-box">
                            <i class="icon-01n_icon9"></i>
                        </i>
                        <div class="tel-box">
                            <p class="name">Email:</p>
                            <p class="name">{{!is_null($website_info) ? $website_info['customer_manager_email'] : ''}}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list">
                    <li class="c-item add-pos">
                        <i class="icon-box">
                            <i class="icon-01n_icon7"></i>
                        </i>
                        <p class="name">销售经理</p>
                    </li>
                    <li class="add-pos">
                        <i class="icon-box">
                            <i class="icon-01n_icon8"></i>
                        </i>
                        <div class="tel-box">
                            <p class="name">TEL:</p>
                            <p class="name">{{!is_null($website_info) ? $website_info['operations_manager_tel'] : ''}}</p>
                        </div>
                    </li>
                    <li class="email-box">
                        <i class="icon-box">
                            <i class="icon-01n_icon9"></i>
                        </i>
                        <div class="tel-box">
                            <p class="name">Email:</p>
                            <p class="name">{{!is_null($website_info) ? $website_info['operations_manager_email'] : ''}}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="btn-wrap">
        <ul class="btn-item">
            <li class="active">流量统计/SEO概览</li>
            <li>上月和本月流量对比</li>
            <li>近半年整体/SEO流量流量</li>
            <li>浏览器占比及网页浏览量</li>
            <li>国家/设备访问</li>
        </ul>
        <div class="btn-box">
            <div class="box active bg-fff">
                <div class="child-box">
                    <h3 class="title">流量统计/SEO概览</h3>
                    <form class="layui-form select-box">
                        <div class="layui-form-item">
                            <select lay-filter="time">
                                <option value="5">最近三个月流量</option>
                                <option value="4">最近二个月流量</option>
                                <option value="3">最近一个月流量</option>
                                <option value="2">最近一周流量</option>
                                <option value="1" selected>昨日流量</option>
                            </select>
                        </div>
                    </form>
                    <div class="main-box">
                        <table id="report_1" lay-filter="report_1"></table>
                    </div>
                </div>
                <div class="mask-box layui-hide">
                    <div class="m-box">
                        <div class="ck_div">
                            <p>请联系第一页管理员安装统计插件......</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box bg-fff">
                <div class="child-box">
                    <h3 class="title">上月和本月流量对比</h3>
                    <div class="sessions">
                        <div class="descr"><span class="month this">本月流量</span><span class="month">上月流量</span></div>
                        <div id="sessions-echarts"></div>
                    </div>
                    <div class="no-text layui-hide">暂无数据...</div>
                </div>
                <div class="mask-box layui-hide">
                    <div class="m-box">
                        <div class="ck_div">
                            <p>请联系第一页管理员安装统计插件......</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="child-box">
                    <div class="bg-fff">
                        <h3 class="title">网站近半年整体流量趋势图</h3>
                        <div class="whole-box">
                            <div id="whole-earchts">

                            </div>
                            <div class="no-text layui-hide">暂无数据...</div>
                        </div>
                    </div>
                    <div class="bg-fff mt-20">
                        <h3 class="title">网站近半年SEO流量趋势图</h3>
                        <div class="seo-box">
                            <div id="seo-earchts"></div>
                            <div class="no-text layui-hide">暂无数据...</div>
                        </div>
                    </div>
                </div>
                <div class="mask-box layui-hide">
                    <div class="m-box">
                        <div class="ck_div">
                            <p>请联系第一页管理员安装统计插件......</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="child-box">
                    <div class="webs-wap">
                        <div class="l-box">
                            <h3 class="title">最近一个月浏览器的访问</h3>
                            <div id="webs-echarts"></div>
                            <ul class="webs-rank">
                            </ul>
                            <div class="no-text layui-hide">暂无数据...</div>
                        </div>
                        <div class="r-box">
                            <h3 class="title">最近三个月网页浏览量排名</h3>
                            <div class="report_2_wrap">
                                <table id="report_2" lay-filter="report_2"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mask-box layui-hide">
                    <div class="m-box">
                        <div class="ck_div">
                            <p>请联系第一页管理员安装统计插件......</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="child-box">
                    <div class="country-box">
                        <div class="cleft-box">
                            <h3 class="title">最近一个月国家浏览量分布图</h3>
                            <div class="c-box">
                                <div class="left-box">
                                    <div id="country-echarts"></div>
                                </div>
                                <ul class="webs-rank r-list">
                                </ul>
                                <div class="no-text layui-hide">暂无数据...</div>
                            </div>
                        </div>
                        <div class="device-box">
                            <h3 class="title">设备访问</h3>
                            <div class="device-table-wrap">
                                <table id="report_3" lay-filter="report_3"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mask-box layui-hide">
                    <div class="m-box">
                        <div class="ck_div">
                            <p>请联系第一页管理员安装统计插件......</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('report/js/echarts.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/jquery.countTo.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/exporting.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/variable-pie.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/decimal.js')}}"></script>
<script type="text/javascript" src="{{asset('report/js/a.js')}}"></script>
<script>
    $("#export-pdf").on("click", function () {
        var type = $(".layui-anim-upbit .layui-this").attr("lay-value");
        var $index = layer.load(2, {
            shade: 0.5
        });
        $.ajax({
            url: "{{config('app.cloud_api', 'https://api.dyycloud.com/')}}" + "api/customerWebsite/getReportPdf",
            type: 'post',
            dataType: "json",
            data: {token: "{{$website_token}}", type: type},
            success: function (res) {
                layer.close($index);
                if (res.status) {
                    window.open(res.src, 'target');
                }else{
                    layer.msg(res.error_msg, {icon: 5});
                }

            },
            error: function () {
                layer.close($index);
            }
        })
    })
</script>
