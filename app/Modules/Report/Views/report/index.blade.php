<x-layui-layout x-once>
    <body>
    @inject('showThumbImagePresenter','App\Presenters\ShowThumbImagePresenter')
    <div class="home_pagebox">
        <div class="home_fl">
            <!-- bannerSwiper -->
            <div class="swiper bannerSwiper">
                <div class="swiper-wrapper">
                    @foreach($ad_spaces as $ad_space)
                        <div class="swiper-slide">
                            <div class="image">
                                <a href="{{ $ad_space->url }}" target="_blank">
                                    <img src="{{ $showThumbImagePresenter->downloadImage(trim(config("cloud_api") ?? env('MIX_API_CLOUD'), '/').'/'.$ad_space->img) }}"/>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- 网站基本信息 -->
            <div class="box_20 top_20">
                <div class="web_infor">
                    <div class="mian_title">
                        <h2 style="font-size: 18px">{{ __('网站基本信息') }}</h2>
                    </div>
                    <div class="module_01">
                        <ul>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_01.svg')}}"/>
                                </div>
                                <a href="javascript:void(0)" class="fast_click" data-value="product">
                                    <div class="txt">
                                        <h3>{{ __('产品总数') }}</h3>
                                        <p>{{ $data['product_count'] }}</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_02.svg')}}"/>
                                </div>
                                <a href="javascript:void(0)" class="fast_click" data-value="inquiry">
                                    <div class="txt">
                                        <h3>{{ __('询盘总数') }}</h3>
                                        <p>{{ $data['inquiry_count'] }}</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{asset('admin/images/svg/svg_03.svg')}}"/>
                                </div>
                                <a href="javascript:void(0)" class="fast_click" data-value="article">
                                    <div class="txt">
                                        <h3>{{ __('文章总数') }}</h3>
                                        <p>{{ $data['article_count'] }}</p>
                                    </div>
                                </a>
                            </li>
                            @if(in_array('Woodpecker',app('myAddons')))
                                <li>
                                    <div class="image">
                                        <img src="{{asset('admin/images/svg/svg_04.svg')}}"/>
                                    </div>
                                    <a href="javascript:void(0)" class="fast_click" data-value="woodpecker">
                                        <div class="txt">
                                            <h3>{{ __('啄木鸟线索') }}</h3>
                                            <p>{{ $data['woodpecker_count'] }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="module_02">
                        <div class="mian_title" style="margin-top: 20px">
                            <h2>{{ __('海外买家销售线索') }}</h2>
                        </div>
                        <div class="tabbtn_more">
                            <div class="tab_btn">
                                <ul>
                                    <li class="on" data-value="woodpecker">{{ __('啄木鸟挖掘') }}</li>
                                    @isset($data['tl_data'][0])
                                    <li data-value="listing">{{ __('Listing推荐线索') }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="morediv">
                                <div class="more active fast_click" data-value="woodpecker"><a
                                        href="javascript:void(0)">{{ __('更多') }}</a>
                                </div>

                                <div class="more fast_click" data-value="listing">
                                    @isset($data['tl_data'][0])
                                        <a href="javascript:void(0)">{{ __('更多') }}</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="item_box">
                            <div class="single active">
                                <div class="table_div">
                                    <table class="layui-table-body">
                                        <thead>
                                        <tr>
                                            <td>ip</td>
                                            <td>{{ __('地址') }}</td>
                                            <td>{{ __('邮箱') }}</td>
                                            <td>{{ __('电话') }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($data['woodpeckers'][0])
                                            @foreach($data['woodpeckers'] as $woodpecker)
                                                <tr>
                                                    <td>{{ $woodpecker->ip }}</td>
                                                    <td>{{ $woodpecker->ip_adr }}</td>
                                                    <td>{{ $woodpecker->email }}</td>
                                                    <td>{{ $woodpecker->tel }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="layui-none" colspan="4">{{ __('暂时没有数据') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="single">
                                <div class="table_div">
                                    <table class="layui-table-body">
                                        <thead>
                                        <tr>
                                            <td>{{ __('内容') }}</td>
                                            <td>{{ __('国家地区') }}</td>
                                            <td>{{ __('买家邮件') }}</td>
                                            <td>{{ __('联系电话') }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($data['tl_data'][0])
                                            @foreach($data['tl_data'] as $tl_datum)
                                                <tr>
                                                    <td>{{ $tl_datum->content }}</td>
                                                    <td>{{ $tl_datum->location }}</td>
                                                    <td>{{ $tl_datum->email }}</td>
                                                    <td>{{ $tl_datum->tel }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="layui-none" colspan="4">{{ __('暂时没有数据') }}</td>
                                            </tr>
                                        @endif
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
                        <h2>{{ __('数据概况') }}<span>{{ __('截至') }}{{ date('Y-m-d H:i:s') }}</span></h2>
                        <div class="more fast_click" data-value="dataManager"><a href="javascript:void(0)">{{ __('更多') }}</a>
                        </div>
                    </div>
                    <ul class="data_house">
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_05.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['num'] }}<span>{{ __('个词') }}</span></h4>
                                <p>{{ __('上月关键词排名Google1-10位') }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_06.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $data['website_score'] }}<span>{{ __('分') }}</span></h4>
                                <p>{{ __('运营指数') }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_08.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['productCategoryCount'] }}<span>{{ __('个') }}</span></h4>
                                <p>{{ __('有效产品分类') }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_09.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['product_tag_count'] }}<span>{{ __('个') }}</span></h4>
                                <p>{{ __('产品关键词') }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_10.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ $profileInfo['keyword_scale'] }}</h4>
                                <p>{{ __('产品关键词比例') }}<i lay-tips="{{ __('关键词总数 / 产品总数') }}" lay-offset="5"
                                                    class="layui-icon layui-icon-tips"></i></p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_11.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{  $data['product_video'] }}<span>{{ __('个') }}</span></h4>
                                <p>{{ __('案例/应用/视频数量') }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{ asset('admin/images/svg/svg_14.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>
                                    {{ $data['inquiry_count'] }}<span>{{ __('个') }}</span><span
                                        style="font-size: 15px;color: #a5a5a5;padding: 0 8px;">|</span>
                                    {{ $data['inquiry_country_count'] }}<span>{{ __('个') }}</span>
                                </h4>
                                <p>{{ __('累计询盘 | 国家与地区') }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img style="padding-top: 3px;" src="{{ asset('admin/images/svg/svg_16.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>
                                    <span style="padding-left:0">{{ __('本月') }}</span> {{ $data['tl_data_month'] }} <span
                                        style="padding-left: 0">{{ __('条') }}</span><span
                                        style="font-size: 15px;color: #a5a5a5;padding: 0 8px;">|</span><span
                                    >{{ __('累计') }}</span> {{  $data['tl_all_data'] }}
                                    <span>{{ __('条') }}</span>
                                </h4>
                                <p>{{ __('Listing推荐线索') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="box_20 top_20">
                <div class="module_04">
                    <div class="mian_title">
                        <h2>{{ __('关键词排名') }}</h2>
                        <div class="more fast_click" data-value="keyword"><a href="javascript:void(0)">{{ __('更多') }}</a>
                        </div>
                    </div>
                    <div class="key_sm">
                        {{ __('最新关键词排名 Google') }}
                        1-10{{ __('位') }}：<span>{{ $profileInfo['num'] }}</span>{{ __('个词') }}。
                    </div>
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>{{ __('关键词') }}</td>
                                <td>{{ __('排名URL') }}</td>
                                <td>
                                    <div class="san_father">
                                        {{ __('谷歌排名') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="san_father">
                                        {{ __('更新时间') }}
                                    </div>
                                </td>
                                <td>{{ __('谷歌快照') }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($profileInfo['tags'] as $tag)
                                <tr>
                                    <td>{{ $tag->name }}</td>
                                    <td><a href="@isset($tag['productRanks'][0])
                                                {{ $tag['productRanks'][0]['catch_url'] }}
                                            @else
                                                -
                                            @endif" target="_blank">
                                            @isset($tag['productRanks'][0])
                                                {{ $tag['productRanks'][0]['catch_url'] }}
                                            @else
                                                -
                                            @endif
                                        </a></td>
                                    <td>{{ $tag['current_rank'] }}</td>
                                    <td>{{ $tag['discrepancy']['check_date'] }}</td>
                                    <td>
                                        @if($tag['current_rank']  > 0 && $tag['discrepancy']['snapshot'])
                                            <a href="{{ $tag['discrepancy']['snapshot'] }}" target="_blank">{{ __('查看') }}</a>
                                        @endif
                                    </td>
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
                        <h2>{{ __('我的多语言营销网站') }}</h2>
                    </div>
                    <dl>
                        <dt>
                            <a href="javascript:void(0);" class="layui-btn-language">
                                <div class="add"></div>
                                <div class="language">{{ __('开通语言') }}</div>
                            </a>
                        </dt>
                        @php(          $http =  env('REDIRECT_HTTPS')?'https://':'http://')
                        @foreach($locales as $locale)
                            <dd>
                                <a href="{{ $http.$locale->url }}" target="_blank">
                                    <div class="hui"><img src="{{ asset('/admin/images/locales/'.strtolower($locale->language_code).'.png') }}"/></div>
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
                        <h2>{{ __('快捷入口') }}</h2>
                    </div>
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="product">
                                <div class="icon">
                                    <i class="icon-shopping"></i>
                                </div>
                                <h3>{{ __('产品管理') }}</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="article">
                                <div class="icon"><i class="icon-server"></i></div>
                                <h3>{{ __('文章管理') }}</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="blog">
                                <div class="icon"><img src="{{ asset('admin/images/svg/svg_26.svg') }}"/></div>
                                <h3>{{ __('博客管理') }}</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="inquiry">
                                <div class="icon">
                                    <img src="{{ asset('admin/images/svg/svg_23.svg') }}"/>
                                    @if($data['inquiry_wd_count'])
                                        <div class="hint_mes">{{ $data['inquiry_wd_count'] }}</div>
                                    @endif
                                </div>
                                <h3>{{ __('询盘管理') }}</h3>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="fast_click" data-value="newsletter">
                                <div class="icon">
                                    <img src="{{ asset('admin/images/svg/svg_21.svg') }}"/>
                                    @if($data['newsletter_wd_count'])
                                        <div class="hint_mes">{{ $data['newsletter_wd_count'] }}</div>
                                    @endif
                                </div>
                                <h3>{{ __('邮箱订阅') }}</h3>
                            </a>
                        </li>
                        @if(in_array('Woodpecker',app('myAddons')))
                            <li>
                                <a href="javascript:void(0)" class="fast_click" data-value="woodpecker">
                                    <div class="icon"><img src="{{ asset('admin/images/svg/svg_24.svg') }}"/></div>
                                    <h3>{{ __('啄木鸟') }}</h3>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="postbox">
                    <div class="mian_title" style="margin-bottom: 10px;">
                        <h2>{{ __('公告') }}</h2>
                        <div class="more"><img src="{{ asset('admin/images/reportimg.png') }}"/></div>
                    </div> 
                    <div>
                        @foreach($notices as $notice)
                        @if($notice->open_show)
                        <dl>
                            <dd class="layui-btn-notice_wrap layui-btn-notice" data-id="{{ $notice->id }}">
                                <a href="javascript:void(0)">{!! $notice->title !!}</a>
                            </dd>
                        </dl>
                        @else
                        <ul>
                            <li class='layui-btn-notice' data-id="{{ $notice->id }}">
                                <a href="javascript:void(0)">{!! $notice->title !!}</a>
                            </li>
                        </ul>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
           @if(count($added_services))
            <div class="box_20 top_20">
                <div class="module_05">
                    <div class="mian_title">
                        <h2>{{ __('增值服务') }}</h2>
                    </div>
                    <dl class="table_service">
                        @foreach($added_services as $added_service)
                            <dd>
                                <p>{{ $added_service->name }}</p>
                                <div @if($added_service->active == 1) class="done_btn" @else class="nodone_btn" @endif >
                                    {{ $added_service->active == 1 ? __('已开通') : __('未开通') }}
                                </div>
                            </dd>
                        @endforeach
                    </dl>
                </div>
            </div>
            @endif
            <div class="box_20 top_20">
                <div class="module_06">
                    <div class="mian_title">
                        <h2>{{ __('服务中心') }}</h2>
                    </div>
                    <ul>
                        <li>
                            <div class="img">
                                <img src="{{ asset('admin/images/svg/svg_17.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ __('客服经理') }}</h4>
                                <p>
                                    TEL:{{ isset($website_info['customer_manager_tel']) ? $website_info['customer_manager_tel'] : '' }}
                                    <br/>Email:{{ isset( $website_info['customer_manager_email']) ? $website_info['customer_manager_email'] :'' }}
                                </p>
                            </div>
                        </li>

                        <li>
                            <div class="img">
                                <img src="{{ asset('admin/images/svg/svg_18.svg') }}"/>
                            </div>
                            <div class="txt">
                                <h4>{{ __('销售经理') }}</h4>
                                <p>
                                    TEL:{{ isset($website_info['operations_manager_tel']) ? $website_info['operations_manager_tel'] : '' }}
                                    <br/>Email:{{ isset($website_info['operations_manager_email']) ? $website_info['operations_manager_email'] :'' }}
                                </p>
                            </div>
                        </li>
                        @if(isset($website_info['operate_manager_tel']) && isset($website_info['operate_manager_email']))
                            <li>
                                <div class="img">
                                    <img src="{{ asset('admin/images/svg/manager.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{ __('运营经理') }}</h4>
                                    <p>
                                        TEL:{{ isset($website_info['operate_manager_tel']) ? $website_info['operate_manager_tel'] :'' }}
                                        <br/>Email:{{ isset($website_info['operate_manager_email']) ? $website_info['operate_manager_email'] : '' }}
                                    </p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="box_20 top_20">
                <div class="module_07">
                    <div class="mian_title">
                        <h2>{{ __('网站基本信息') }}</h2>
                    </div>
                    <div class="txt">
                        <p>{{ __('公司名称') }}：{{!is_null($website_info) ? $website_info['company_name'] : ''}}</p>
                        <p>
                            {{ __('合作年限') }}：{{!is_null($website_info) ? ($website_info['cooperation_year'] > 0 ? $website_info['cooperation_year']:'<1') : ''}}
                            {{ __('年') }}
                        </p>
                        <p>{{ __('服务剩余') }}：{{!is_null($website_info) ? days_diff($website_info['expiration_time']) : ''}}
                            {{ __('天') }}({{ __('到期时间') }}{{!is_null($website_info) ? $website_info['expiration_time'] : ''}})</p>
                        {{-- <p>{{ __('网站域名权重') }}：{{ __('谷歌首页且排在第') }}{{ $site_count_data['weight_rank'] }}{{ __('位') }}</p> --}}
                        {{-- <p>{{ __('主网站收录') }}：{{ $site_count_data['main_web_rank'] }}{{ __('条') }}</p>
                        <p>{{ __('网站总收录') }}：{{ $site_count_data['web_rank'] }}{{ __('条') }}</p> --}}
                    </div>
                </div>
            </div>
            <div class="box_20 top_20">
                @if(in_array('OperationalScore',app('myAddons')))
                    <div class="module_08">
                        <div class="mian_title">
                            <h2 style="text-align: center; width: 100%">
                                {{ __('网站运营指数') }}
                            </h2>
                        </div>
                        <div id="round-box"></div>
                        <div class="detail_btn ">
                            <a href="javascript:void(0)" class="flash_white fast_click"
                               data-value="operational/score">{{ __('查看详情') }}</a>
                        </div>
                        <h5>
                            {{ __('网站运营指数通过专业的内容质量判定标准，提升您的网站内容，吸引更多的受众，实现更多的业务。') }}
                        </h5>
                    </div>
                @else
                    <div class="module_08">
                        <div class="mian_title">
                            <h2 style="text-align: center; width: 100%">
                                {{ __('网站运营指数') }}
                            </h2>
                        </div>
                        <div id="round-box"></div>
                        <div class="detail_btn ">
                            <a href="javascript:void(0)" class="flash_white">{{ __('请安装运营指数插件后查看') }}</a>
                        </div>
                        <h5>
                            {{ __('关键词等检查是检测优化通营销网站关键词等分布的合理性，匹配度和个数等，有助于提高网站排名') }}
                        </h5>
                    </div>
                @endif
            </div>
        </div>
        @section('css')
            <link rel="stylesheet" href="{{ asset('/report/css/swiper.css') }}"/>
            <link rel="stylesheet" href="{{ asset('/report/css/versiontwo.css') }}"/>
        @endsection
        @section('scripts')
            <script src="{{ asset('/js/admin/admin.home.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/circleChart.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/swiper.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('report/js/versiontwo.js') }}"></script>
            <script>
                $(function () {
                    var swiper = new Swiper(".bannerSwiper", {
                        spaceBetween: 30,
                        centeredSlides: true,
                        loop: false,
                        autoplay: {
                            pauseOnMouseEnter: true, //鼠标置于swiper时暂停自动切换，鼠标离开时恢复自动切换。
                            disableOnInteraction: false, //手动播放后继续自动播放
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                    });
                });
                $('.tab_btn li').click(function () {
                    var index = $(this).index()
                    $(this).addClass('on').siblings().removeClass('on');
                    $('.morediv .more').eq(index).addClass('active').siblings().removeClass('active')
                    $('.item_box .single').eq(index).addClass('active').siblings().removeClass('active')
                })

                //初始化圆形抽奖进度
                $("#round-box").circleChart({
                    size: 170, //圆形大小
                    maxval: 100, //抽奖满足条件值
                    value: "{{ $data['website_score'] }}", //当前进度值
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

            .layui-layer-iframe {max-width:800px;border-radius: 10px;overflow: hidden;}
            /* .layui-layer-iframe iframe{max-height: 90vh!important} */

            /* #layui-layer1{max-width: 500px!important;height: 400px!important;} */

        </style>
    </div>
    </body>
</x-layui-layout>
