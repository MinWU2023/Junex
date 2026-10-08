<x-layui-layout>
    <body>
    <div class="home_pagebox">
        <div class="home_fl">
            <!-- bannerSwiper -->
            <div class="swiper bannerSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="image">
                            <img src="{{ asset('admin/images/image.jpg') }}"/>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="image">
                            <img src="{{ asset('admin/images/image.jpg') }}"/>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- 网站基本信息 -->
            <div class="box_20 top_20">
                <div class="web_infor">
                    <div class="mian_title">
                        <h2 style="font-size: 18px">网站基本信息</h2>
                    </div>
                    <div class="module_01">
                        <ul>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_01.svg')}}"/>
                                </div>
                                <div class="txt">
                                    <h3>产品总数</h3>
                                    <p>{{ $data['product_count'] }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_02.svg')}}"/>
                                </div>
                                <div class="txt">
                                    <h3>询盘总数</h3>
                                    <p>{{ $data['inquiry_count'] }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_03.svg')}}"/>
                                </div>
                                <div class="txt">
                                    <h3>文章总数</h3>
                                    <p>{{ $data['article_count'] }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_04.svg')}}"/>
                                </div>
                                <div class="txt">
                                    <h3>啄木鸟线索</h3>
                                    <p>{{ $data['woodpecker_count'] }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="module_02">
                        <div class="mian_title" style="margin-top: 20px">
                            <h2>推荐买家</h2>
                            <div class="more fast_click" data-value="woodpecker"><a href="javascript:void(0)">更多</a>
                            </div>
                        </div>
                        <div class="tab_btn">
                            <ul>
                                <li class="on">啄木鸟</li>
                                <li>Listing</li>
                            </ul>
                        </div>
                        <div class="item_box">
                            <div class="single active">
                                <div class="table_div">
                                    <table>
                                        <thead>
                                        <tr>
                                            <td>ip</td>
                                            <td>地址</td>
                                            <td>邮箱</td>
                                            <td>电话</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['woodpeckers'] as $woodpecker)
                                            <tr>
                                                <td>{{ $woodpecker['ip'] }}</td>
                                                <td>{{ $woodpecker['ip_adr'] }}</td>
                                                <td>{{ $woodpecker['email'] }}</td>
                                                <td>{{ $woodpecker['tel'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="single">
                                <div class="table_div">
                                    <table>
                                        <thead>
                                        <tr>
                                            <td>公司名称/公司主站2</td>
                                            <td>关键词</td>
                                            <td>国家地区</td>
                                            <td>买家邮件</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <a href="#">Unified Information Devices</a>
                                            </td>
                                            <td>
                                                Laboratory Animal Identification、PI
                                                Software Sui...
                                            </td>
                                            <td>Other Country</td>
                                            <td>info@uidevices.com</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="module_03">
                    <div class="mian_title">
                        <h2>数据概况<span>截至2023-03-14 00:00:00 </span></h2>
                        <div class="more fast_click" data-value="dataManager"><a href="javascript:void(0)">更多</a></div>
                    </div>
                    <ul class="data_house">
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_05.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['num'] }}<span>个词</span></h4>
                                <p>上月关键词排名Google1-10位</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_06.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>178</h4>
                                <p>运营指数</p>
                            </div>
                        </li>
{{--                        <li>--}}
{{--                            <div class="image">--}}
{{--                                <img src="{{ asset('admin/images/svg/svg_07.svg') }}"/>--}}
{{--                            </div>--}}
{{--                            <div class="txt">--}}
{{--                                <h4>317<span>个</span></h4>--}}
{{--                                <p>有效产品</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_08.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['productCategoryCount'] }}<span>个</span></h4>
                                <p>有效产品分类</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_09.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['product_tag_count'] }}<span>个</span></h4>
                                <p>产品关键词</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_10.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['keyword_scale'] }}</h4>
                                <p>产品关键词比例</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_11.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>567<span>个</span></h4>
                                <p>视频</p>
                            </div>
                        </li>
{{--                        <li>--}}
{{--                            <div class="image">--}}
{{--                                <img src="{{ asset('admin/images/svg/svg_12.svg') }}"/>--}}
{{--                            </div>--}}
{{--                            <div class="txt">--}}
{{--                                <h4>567<span>篇</span></h4>--}}
{{--                                <p>新闻资讯</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_13.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>100<span>个</span></h4>
                                <p>关键词智能挖掘</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_14.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>
                                    {{ $data['inquiry_count'] }}<span style="padding-right: 15px">个</span
                                    >{{ $data['inquiry_country_count'] }}<span>个</span>
                                </h4>
                                <p>累计询盘 | 国家与地区</p>
                            </div>
                        </li>
{{--                        <li>--}}
{{--                            <div class="image">--}}
{{--                                <img src="{{ asset('admin/images/svg/svg_15.svg') }}"/>--}}
{{--                            </div>--}}
{{--                            <div class="txt">--}}
{{--                                <h4>--}}
{{--                                    272<span style="padding-right: 15px">个</span--}}
{{--                                    >--}}
{{--                                </h4>--}}
{{--                                <p>啄木鸟线索</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                        <li>
                            <div class="image">
                                <img style="padding-top: 3px;" src="{{ asset('admin/images/svg/svg_16.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>
                                    <span style="padding-left:0">本月</span>0<span style="padding-left: 0">个词</span><span style="padding-left: 15px">累计</span>74<span>条</span>
                                </h4>
                                <p>Listing</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="box_20 top_20">
                <div class="module_04">
                    <div class="mian_title">
                        <h2>关键词排名</h2>
                        <div class="more fast_click" data-value="keywordRank"><a href="javascript:void(0)">更多</a></div>
                    </div>
                    <div class="key_sm">
                        最新关键词排名 Google
                        1-10位：<span>{{ $profileInfo['num'] }}</span>个词。
                    </div>
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>关键词</td>
                                <td>排名URL</td>
                                <td>
                                    <div class="san_father">
                                        谷歌排名
{{--                                        <i class="san_top"></i>--}}
{{--                                        <i class="san_bot"></i>--}}
                                    </div>
                                </td>
                                <td>
                                    <div class="san_father">
                                        更新时间
{{--                                        <i class="san_top"></i--}}
{{--                                        ><i class="san_bot"></i>--}}
                                    </div>
                                </td>
                                <td>谷歌快照</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($profileInfo['tags'] as $tag)
                                <tr>
                                    <td>{{ $tag->name }}</td>
                                    <td><a href="#">
                                            @isset($tag['productRanks'][0])
                                                {{ $tag['productRanks'][0]['catch_url'] }}
                                            @else
                                                -
                                            @endif
                                        </a></td>
                                    <td>{{ $tag['current_rank'] }}</td>
                                    <td>{{ $tag['check_date'] }}</td>
                                    <td><a href="#">查看</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="box_20 top_20">
                <div class="flag_box">
                    <div class="mian_title">
                        <h2>我的多语言营销网站</h2>
                    </div>
                    <dl>
                        @if( auth()->id()=== 1)
                            <dt>
                                <a href="javascript:void(0);" class="layui-btn-language">
                                    <div class="add"></div>
                                    <div class="language">开通语言</div>
                                </a>
                            </dt>
                        @endif
                        @foreach($locales as $locale)
                            <dd>
                                <a href="javascript:void(0)">
                                    <div class="hui"><img src="{{ asset($locale->path) }}"/></div>
                                    <div class="language">{{ $locale->language }}</div>
                                </a>
                            </dd>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
        <div class="home_fr">
            <div class="box_20">
                <div class="module_05">
                    <div class="mian_title">
                        <h2>快捷入口</h2>
                    </div>
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="product">
                                <div class="icon">
                                    <i class="icon-shopping"></i>
                                </div>
                                <h3>产品管理</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="article">
                                <div class="icon"><i class="icon-server"></i></div>
                                <h3>文章管理</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="blog">
                                <div class="icon"><i class="icon-box"></i></div>
                                <h3>博客管理</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="inquiry">
                                <div class="icon">
                                    <img src="{{ asset('admin/images/svg/svg_23.svg') }}"/>
                                </div>
                                <h3>询盘管理</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="newsletter">

                                <div class="icon">
                                    <img src="{{ asset('admin/images/svg/svg_21.svg') }}"/>
                                </div>
                                <h3>邮箱订阅</h3>
                            </a>
                        </li>
                        @if(in_array('Woodpecker',app('myAddons')))
                            <li>
                                <a href="javascript:void(0)" class="fast_click" data-value="woodpecker">
                                    <div class="icon"><img src="{{ asset('admin/images/svg/svg_24.svg') }}"/></div>
                                    <h3>啄木鸟</h3>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="postbox">
                    <div class="mian_title">
                        <h2>公告</h2>
                    </div>
                    <ul>
                        @foreach($notices as $notice)
                        <li class="layui-btn-notice" data-id="{{ $notice->id }}"><a href="javascript:void(0)">{{ $notice->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="module_06">
                    <div class="mian_title">
                        <h2>服务中心</h2>
                    </div>
                    <ul>
                        <li>
                            <div class="img">
                                <img src="{{ asset('admin/images/svg/svg_17.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>客服经理</h4>
                                <p>TEL:{{!is_null($website_info) ? $website_info['customer_manager_tel'] : ''}} <br/>Email:{{!is_null($website_info) ? $website_info['customer_manager_email'] : ''}}</p>
                            </div>
                        </li>

                        <li>
                            <div class="img">
                                <img src="{{ asset('admin/images/svg/svg_18.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>销售经理</h4>
                                <p>TEL:{{!is_null($website_info) ? $website_info['operations_manager_tel'] : ''}} <br/>Email:{{!is_null($website_info) ? $website_info['operations_manager_email'] : ''}}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="module_07">
                    <div class="mian_title">
                        <h2>网站基本信息</h2>
                    </div>
                    <div class="txt">
                        <p>公司名称：{{!is_null($website_info) ? $website_info['company_name'] : ''}}</p>
                        <p>合作年限：{{!is_null($website_info) ? ($website_info['cooperation_year'] > 0 ? $website_info['cooperation_year']:'<1') : ''}}年</p>
                        <p>服务剩余：{{!is_null($website_info) ? $website_info['expiration_day'] : ''}}天(到期时间{{!is_null($website_info) ? $website_info['expiration_time'] : ''}})</p>
                        <p>网站域名权重：谷歌首页且排在第{{ $site_count_data['weight_rank'] }}位</p>
                        <p>主网站收录：{{ $site_count_data['main_web_rank'] }}</p>
                        <p>网站总收录：{{ $site_count_data['web_rank'] }}</p>
                        <!-- <h4><a href="javascript:void(0)" class="view_renew" >查看续费政策</a></h4> -->
                    </div>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="module_08">
                    <div class="mian_title">
                        <h2>商家成长</h2>
                        <div class="more">
                            <a href="#">查看更多</a>
                        </div>
                    </div>
                    <ul class="txt">
                        <li>
                        <span class="red">热点</span
                        ><a href="#">DTC品牌推广平台</a>
                        </li>
                        <li>
                        <span class="green">品牌</span
                        ><a href="#">品牌发展目标与品牌资产</a>
                        </li>
                        <li>
                        <span class="blue">电商</span
                        ><a href="#">跨境电商如何选品</a>
                        </li>
                        <li>
                        <span class="red">热点</span
                        ><a href="#">海外支付和物流洞察</a>
                        </li>
                    </ul>
                </div>
            </div>
{{--            @if(in_array('OperationalScore',app('myAddons')))--}}
            <div class="box_20 top_20">
                <div class="module_08">
                    <div class="mian_title">
                        <h2 style="text-align: center; width: 100%">
                            网站运营指数
                        </h2>
                    </div>
                    <div id="round-box"></div>
                    <div class="detail_btn">
                        <a href="javascript:void(0)" class="flash_white fast_click" data-value="operational/score">查看详情</a>
                    </div>
                    <h5>
                        关键词等检查是检测优化通营销网站关键词等分布的合理性，匹配度和个数等，有助于提高网站排名
                    </h5>
                    <!-- <div class="inspect_tool">
                    <a href="#">
                        <div class="img">
                            <img
                                src="{{ asset('admin/images/svg/svg_19.svg') }}"
                            />
                        </div>
                        <p>检查工具</p>
                    </a>
                </div> -->
                </div>
            </div>
{{--            @endif--}}
            <!-- <div class="submit_order">
                <a href="#" class="flash_white">提交工单</a>
            </div> -->
        </div>

        @section('css')
        <link rel="stylesheet" href="{{ asset('/report/css/swiper.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/report/css/versiontwo.css') }}"/>
        @endsection

        @section('scripts')
            <script src="{{ mix('/js/admin/admin.home.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/jquery-1.10.2.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/circleChart.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/echarts.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/swiper.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/versiontwo.js') }}"></script>
            <script>
                //初始化圆形抽奖进度
                $("#round-box").circleChart({
                    size: 170, //圆形大小
                    maxval: 100, //抽奖满足条件值
                    value: 84, //当前进度值
                    color: "#656EE5", //进度条颜色
                    backgroundColor: "#f0f0f0", //进度条背景色
                    speed: 1500, // 出现的时间
                    widthRatio: 0.17, // 进度条宽度
                    unit: "percent",
                    counterclockwise: false, // 进度条反方向
                    startAngle: 0, // 进度条起点
                    animate: true, // 进度条动画
                    backgroundFix: true,
                    lineCap: "round",
                    animation: "easeInOutCubic",
                    text: true, // 显示进度条 进度文字百分比内容
                    textColor: "#656EE5", // 进度文字百分比颜色
                    redraw: false,
                    cAngle: 0,
                    textCenter: true,
                    textSize: 56,
                    textWeight: "normal",
                    textFamily: "Helvetica",
                    relativeTextSize: 1 / 5, // 进度条中字体占比
                    autoCss: true,
                    onDraw: function (el, circle) {
                        circle.text(Math.round(circle.value)); // 根据value修改text
                    },
                });
            </script>
        @endsection

        <style>
            .layui-layer-page {
                max-width: 90%;
                max-height: 90%;
            }
        </style>
    </div>
    </body>
</x-layui-layout>
