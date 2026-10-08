<x-layui-layout>
    <style>
        body {
            background: #F7F8FA;
        }
    </style>
    <body>
    <div class="js_page_nav" id="navHeight">
        <input type="hidden" value="{{ csrf_token() }}" id="token">
        <dl id="nav-wrap">
            <dd class="pnav_item">
                <a href="#section1" class="pnav_link active">{{ __('数据概况') }}</a>
            </dd>
            <dd class="pnav_item">
                <a href="#section2" class="pnav_link">{{ __('推广成效') }}</a>
            </dd>
            <dd class="pnav_item">
                <a href="#section3" class="pnav_link">{{ __('流量分析') }}</a>
            </dd>
            <dd class="pnav_item">
                <a href="#section4" class="pnav_link">{{ __('运营指数') }}</a>
            </dd>
            <dd class="pnav_item">
                <a href="#section5" class="pnav_link">{{ __('内容数量') }}</a>
            </dd>
            @if(in_array(auth()->user()->id,[1,2]))
                <dd class="pnav_item">
                    <a href="#section7" class="pnav_link">{{ __('账号情况') }}</a>
                </dd>
            @endif
        </dl>
    </div>

    <div class="home_pagebox fix_stiky_box">
        <div class="home_fl">
            <div class="fix_stiky">
                <div class="halfbox">
                    <div class="halfdiv">
                        <div class="pagebox">
                            <div class="white_bg">
                                <div class="nav_page" id="overview1">
                                    <div class="mian_title">
                                        <h2>{{ __('基本概况') }}</h2>
                                    </div>
                                    <ul>
                                        <li>{{ __('营销网站域名') }}：{{ parse_url(url('/'))['host'] }}
                                            @if(isset($website_info['start_time']) && time() < strtotime($website_info['expiration_time']))
                                                <span style="color: #16A291;padding-left: 10px;">{{ __('使用中') }}</span>
                                            @else
                                                <span style="color: red;padding-left: 10px;">{{ __('已停用') }}</span>
                                            @endif
                                        </li>
                                        <li>
                                            {{ __('营销网站上线时间') }}：{{!is_null($website_info) ? $website_info['start_time'] : ''}}</li>
                                        <li>{{ __('营销网站多语言') }}：{{ $data['locale_count'] }}{{ __('种语言') }}
                                        </li>
                                        @if(isset($website_info['count_month']) && $website_info['db_month']>0 )
                                            <li>{{ __('网站服务时间共计') }} {{ $website_info['count_month'] }}
                                                {{ __('个月') }}，{{ __('已开启') }}{{ $website_info['db_month'] }}
                                                {{ __('个月') }}，{{ __('剩余服务时间') }}{{ $website_info['sy_month'] }}
                                                {{ __('个月') }}
                                            </li>
                                        @endif
                                        <li>
                                            {{ __('预计到期时间') }}：{{!is_null($website_info) ? $website_info['expiration_time'] : ''}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="halfdiv">
                        <div class="operatebox">
                            <div class="white_bg">
                                <div class="nav_page" id="overview1">
                                    <div class="mian_title">
                                        <h2>{{ __('运营中心') }}</h2>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="img">
                                                <img src="{{ asset('admin/images/svg/svg_17.svg') }}"/>
                                            </div>
                                            <div class="txt">
                                                <h4>{{ __('客服经理') }}</h4>
                                                <p>
                                                    TEL:{{ isset($website_info['customer_manager_tel']) ? $website_info['customer_manager_tel'] : ''}}
                                                    <br>Email:{{ isset($website_info['customer_manager_email']) ? $website_info['customer_manager_email'] : ''}}
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
                                                    TEL:{{ isset($website_info['operations_manager_tel']) ? $website_info['operations_manager_tel'] : ''}}
                                                    <br>Email:{{ isset($website_info['operations_manager_email']) ? $website_info['operations_manager_email'] : ''}}
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
                                                        TEL:{{ isset($website_info['operate_manager_tel']) ? $website_info['operate_manager_tel'] : ''}}
                                                        <br>Email:{{ isset($website_info['operate_manager_email']) ? $website_info['operate_manager_email'] : ''}}
                                                    </p>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_20 top_20" id="section1">
                    <div class="module_03">
                        <div class="mian_title" style="padding-top: 20px;">
                            <h2>{{ __('数据概况') }}<span>{{ __('截至') }}{{ $current_time }}  </span></h2>
                        </div>
                        <ul class="data_house">
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_05.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{ $data['tag_rank_num'] }}<span>{{ __('个词') }}</span></h4>
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
                                    <img src="{{ asset('admin/images/svg/svg_07.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{  $data['product_count']  }}<span>{{ __('个') }}</span></h4>
                                    <p>{{ __('有效产品') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_08.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{ $data['product_category_count'] }}<span>{{ __('个') }}</span></h4>
                                    <p>{{ __('有效产品分类') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_09.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{ $data['product_tag_count'] }}<span>{{ __('个') }}</span></h4>
                                    <p>{{ __('产品关键词') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_10.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{ $data['keyword_scale'] }}</h4>
                                    <p>{{ __('产品关键词比例') }}<i lay-tips="{{ __('关键词总数 / 产品总数') }}" lay-offset="5"
                                                        class="layui-icon layui-icon-tips"></i>
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_11.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{ $data['product_video_count'] }}<span>{{ __('个') }}</span></h4>
                                    <p>{{ __('案例/应用/视频数量') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_12.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>{{  $data['article_count'] }}<span>{{ __('篇') }}</span></h4>
                                    <p>{{ __('新闻资讯') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_14.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>
                                        {{ $data['inquiry_count'] }}<span>{{ __('个') }}<span
                                                style="font-size: 15px;color: #a5a5a5;padding: 0 8px;">|</span></span>{{ $data['inquiry_country_count'] }}
                                        <span>{{ __('个') }}</span>
                                    </h4>
                                    <p>{{ __('累计询盘') }} | {{ __('国家与地区') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_15.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>
                                        {{  $data['woodpecker_count']  }}<span style="padding-right: 15px">{{ __('个') }}</span>
                                    </h4>
                                    <p>{{ __('啄木鸟线索') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img style="padding-top: 3px;" src="{{ asset('admin/images/svg/svg_16.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>
                                        <span style="padding-left:0">{{ __('本月') }}</span> {{ $data['tl_data_month_count'] }}
                                        <span style="padding-left: 0">{{ __('条') }}</span><span
                                            style="font-size: 15px;color: #a5a5a5;padding: 0 8px;">|</span><span>{{ __('累计') }}</span> {{  $data['tl_data_count'] }}
                                        <span>{{ __('条') }}</span>
                                    </h4>
                                    <p>Listing</p>
                                </div>
                            </li>
                        </ul>
                        <div class="renew">
                            <p>
                                {{ __('最新发布产品时间') }}：{{ isset($data['last_create_product']['created_at'])?$data['last_create_product']['created_at']:'' }}</p>
                            <p>
                                {{ __('最新更新产品时间') }}：{{ isset($data['last_update_product']['updated_at'])?$data['last_update_product']['updated_at']:'' }}</p>
                            <p>{{ __('最新登录时间') }}：{{ auth()->user()->last_login_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- 推广成效 -->
                <div class="box_20 top_20" id="section2">
                    <div class="single_01">
                        <div class="big_title">{{ __('推广成效') }}</div>
                        <div class="sec_title" style="margin-bottom: 8px;">
                            <h2>{{ __('关键词排名') }}</h2>
                        </div>
                        <div class="explain_title">
                            <h3>{{ __('最新关键词排名 Google1-10位') }}：<span>{{ $data['tag_rank_num'] }}</span>{{ __('个词') }}。</h3>
                            <div class="more">
                                <a class="redirect_btn" data-value="keyword" href="javascript:void(0)">{{ __('查看更多') }}</a>
                            </div>
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
                                @foreach($data['keywordsRankData'] as $keywordsRankDatum)
                                    <tr>
                                        <td>{{ $keywordsRankDatum['name'] }}</td>
                                        <td><a href="{{ $keywordsRankDatum['discrepancy']['catch_url'] }}"
                                               target="_blank">{{ $keywordsRankDatum['discrepancy']['catch_url'] }}</a>
                                        </td>
                                        <td>
                                            <div class="flex"><span
                                                    class="num">{{ $keywordsRankDatum['current_rank'] }}</span>
                                                @if($keywordsRankDatum['discrepancy']['type'])
                                                    @if($keywordsRankDatum['discrepancy']['type'] === 'up')
                                                        <div class="img"><img
                                                                src="{{ asset('admin/images/svg/up.svg') }}"/></div>
                                                        <span
                                                            class="red">{{ $keywordsRankDatum['discrepancy']['num'] }}</span>
                                                    @else
                                                        <div class="img"><img
                                                                src="{{ asset('admin/images/svg/down.svg') }}"/></div>
                                                        <span
                                                            class="green">{{ $keywordsRankDatum['discrepancy']['num'] }}</span>
                                                    @endif
                                                @endif
                                            </div>

                                        </td>
                                        <td>{{ $keywordsRankDatum['discrepancy']['check_date'] }}</td>
                                        <td>
                                            @if($keywordsRankDatum['current_rank']  > 0 && $keywordsRankDatum['discrepancy']['snapshot'])
                                                <a href="{{ $keywordsRankDatum['discrepancy']['snapshot'] }}"
                                                   target="_blank">{{ __('查看') }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="datebox">
                        <div class="date_filter">
                            <div class="layui-inline">
                                <div class="layui-inline">
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" autocomplete="off" id="start-date"
                                               placeholder="{{ __('开始日期') }}">
                                    </div>
                                    <div class="layui-form-mid">{{ __('至') }}</div>
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" autocomplete="off" id="end-date"
                                               placeholder="{{ __('结束日期') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="datasure flash_white" id="generated_data">{{ __('生成数据') }}</div>
                        </div>
                        <p>
                            {{ __('网站运营指数、产品各项待修改数量、产品分类部分数据、产品关键词比例为数据管家新增内容') }}
                        </p>
                    </div>


                    <div class="top_40">
                        <div class="single_01_01">
                            <div class="sec_title">
                                <h2>{{ __('关键词排名数量') }}<b>({{ __('提示') }}:{{ __('查询Google.com排名时，请访问英文Google') }}:<a
                                            href="https://www.google.com/ncr"
                                            target="_blank">https://www.google.com/ncr</a>)</b></h2>
                            </div>
                            <div class="wrapper" id="sheet1">
                                <div class="sheet_canvas" id="sheet_canvas1" style="margin-top: 20px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="top_40">
                        <div class="sec_title">
                            <h2>{{ __('询盘数量') }}<b>({{ __('截至') }}{{ $current_time }}，{{ __('累计询盘数量为') }}{{ $data['inquiry_count'] }} {{ __('个') }})</b>
                            </h2>
                        </div>
                        <div class="wrapper" id="sheet2">
                            <div class="sheet_canvas" id="sheet_canvas2" style="margin-top: 30px"></div>
                        </div>
                        <div class="wrapper" id="sheet3">
                            <div class="sheet_canvas" id="sheet_canvas3" style="margin-top: -10px"></div>
                        </div>
                        <div class="sec_title">
                            <h2>{{ __('询盘地域') }}<b>({{ __('截至') }}{{ $current_time }}
                                    ，{{ __('询盘总共来自') }}{{ $data['inquiry_countries']->count() }}
                                    {{ __('个国家及地区') }}。{{ __('累计询盘地域分布如下所示') }})</b></h2>
                        </div>
                        <div class="wrapper" id="sheet4">
                            <div class="sheet_canvas" id="sheet_canvas4"></div>
                        </div>

                        <div class="top_40" style="display: none">
                            <div class="sec_title">
                                <h2>{{ __('产品收录率') }}<b>({{ __('最新产品收录率为') }}{{ $data['currentProductIndexRate'] }}%，{{ __('更新时间') }}{{ $current_time }}。)</b></h2>
                            </div>
                            <div class="wrapper" id="sheet6">
                                <div class="sheet_canvas" id="sheet_canvas6"></div>
                            </div>
                        </div>
                        <div class="table_div" style="display: none">
                            <table>
                                <thead>
                                <tr>
                                    <td>{{ __('序号') }}</td>
                                    <td>{{ __('产品分类') }}</td>
                                    <td>{{ __('产品数量（已收录/总数）') }}</td>
                                    <td>{{ __('收录率') }}</td>
                                    <td>{{ __('更新时间') }}</td>
                                </tr>
                                </thead>
                                <tbody id="loadingContainer">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 流量分析 -->
                <?php
                $report_addon = \App\Modules\AddonsMarket\Models\Addon::query()->where('sign', 'WebsiteReport')->first();
                ?>
                <div class="box_20 top_20" id="section3">
                    <div class="big_title">{{ __('流量分析') }}</div>
                    <!-- 访客分析 -->
                    <div class="sec_title" style="margin-bottom: 8px;">
                        <h2>{{ __('访客分析') }}</h2>
                    </div>
                    @if($report_addon)
                        <div class="explain_title">
                            @isset($data['analysisData']['data'][0])
                                <h3 style="width: calc(100% - 86px);">
                                    {{ __('会话次数最多的是') }}{{ $data['analysisData']['max_sessions_date'] }}
                                    {{ __('，浏览次数（PV）最多的是') }}{{ $data['analysisData']['max_screenPageViews'] }}
                                    {{ __('，访客数（UV）最多的是') }}{{ $data['analysisData']['max_newUsers_date'] }}
                                </h3>
                                <div class="more" style="width: 76px;"><a class="redirect_btn"
                                                                          data-version="{{ $report_addon->version }}"
                                                                          data-value="flowAnalysis"
                                                                          href="javascript:void(0)">{{ __('查看更多') }}</a></div>
                            @else
                                <h3 style="width: calc(100% - 86px);">{{ __('请安装数据统计插件后查看') }}</h3>
                            @endif
                        </div>
                        <div class="table_div minwidth_two">
                            <table>
                                <thead>
                                <tr>
                                    <td>{{ __('月份') }}</td>
                                    <td>
                                        <div class="tips_hint"><span>{{ __('会话次数') }}</span><i
                                                lay-tips="{{ __('会话次数，访客访问网站的次数。访客第一次访问您网站或者距离上次访问时间超过30分钟，会被统计为新的访问。') }}"
                                                lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                    </td>
                                    <td>{{ __('环比增长') }}</td>
                                    <td>
                                        <div class="tips_hint"><span>{{ __('浏览次数(PV)') }}</span><i
                                                lay-tips="{{ __('浏览次数，访客浏览的页面总数。每打开一个页面就被记录一次，多次打开同一个页面，浏览次数累计。') }}"
                                                lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                    </td>
                                    <td>{{ __('环比增长') }}</td>
                                    <td>
                                        <div class="tips_hint"><span>{{ __('访客数(UV)') }}</span><i
                                                lay-tips="{{ __('访客数，您网站的独立访客数(以Cookie为依据)，一天内同一访客多次访问您网站只计算一个访客。') }}"
                                                lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                    </td>
                                    <td>{{ __('环比增长') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['analysisData']['data']  as $analysisData_k=>$analysisData)
                                    @if($analysisData_k>0)
                                    <tr>
                                        <td>{{ $analysisData['time'] }}</td>
                                        <td>{{ $analysisData['sessions'] }}</td>
                                        <td class="@if($analysisData['sessions_hb_rate'] > 0) red @else green @endif ">{{ $analysisData['sessions_hb_rate'] }}
                                            %
                                        </td>
                                        <td>{{ $analysisData['screenPageViews'] }}</td>
                                        <td class="@if($analysisData['screenPageViews_hb_rate'] > 0) red @else green @endif">{{ $analysisData['screenPageViews_hb_rate'] }}
                                            %
                                        </td>
                                        <td>{{ $analysisData['newUsers'] }}</td>
                                        <td class="@if($analysisData['newUsers_hb_rate'] > 0) red @else green @endif">{{ $analysisData['newUsers_hb_rate'] }}
                                            %
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <!-- 访问次数TOP10的页面 -->
                    <div class="sec_title top_40" style="margin-bottom: 8px;">
                        <h2>{{ __('最近三个月网页访问用户数TOP10的页面') }}</h2>
                    </div>
                    @isset($data['pageViewRankData'][0])
                        <div class="explain_title">
                            <h3>{{ __('在此期间，访问用户数最多的页面是') }}<a
                                    href="{{ $data['pageViewRankData'][0]['name'] }}">{{ $data['pageViewRankData'][0]['name'] }}</a>，为{{ isset($data['pageViewRankData'][0]['activeUsers'])?$data['pageViewRankData'][0]['activeUsers']:0 }}
                                {{ __('。可以对访问用户数较多的页面进行内容调整，比如放置一些爆款，把热门分类放置在更前面等，提高转化率') }}
                            </h3>
                        </div>
                    @endif
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>{{ __('序号') }}</td>
                                <td>{{ __('页面链接') }}</td>
                                <td>
                                    <div class="tips_hint"><span>{{ __('访问用户数') }}</span>
                                        <i lay-tips="{{ __('访问过您的网站或应用的不同用户数量') }}"
                                           lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['pageViewRankData'] as $k=>$pageViewRankDatum)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td><a href="{{ $pageViewRankDatum['name'] }}"
                                           target="_blank">{{ $pageViewRankDatum['name'] }}</a></td>
                                    <td>{{ isset($pageViewRankDatum['activeUsers'])?$pageViewRankDatum['activeUsers']:0 }}</td>
                                    {{--                                    <td>2032</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @isset($data['countryReport'][0])
                        <!-- 访问次数TOP10的国家与地区 -->
                        <div class="sec_title top_40" style="margin-bottom: 8px;">
                            <h2>{{ __('最近一个月访问用户数TOP10的国家与地区') }}</h2>
                        </div>
                        <div class="explain_title">
                            <h3>
                                {{ __('在此期间，访问用户数最多的国家与地区是') }}{{ $data['countryReport'][0]['name'] }}
                                {{ __('，为') }}{{ $data['countryReport'][0]['view_count'] }}
                                {{ __('，可以发布更多的更吸引访问用户数较多的国家喜欢的产品') }}
                            </h3>
                        </div>
                        <div class="table_div">
                            <table>
                                <thead>
                                <tr>
                                    <td>{{ __('序号') }}</td>
                                    <td>{{ __('国家与地区') }}</td>
                                    <td>
                                        <div class="tips_hint"><span>{{ __('访问用户数') }}</span><i
                                                lay-tips="{{ __('访问过您的网站或应用的不同用户数量') }}"
                                                lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                    </td>
                                    <td>
                                        <div class="tips_hint"><span>{{ __('访问用户数占比') }}</span><i
                                                lay-tips="{{ __('统计周期内，某国家的访问用户数占总访问用户数的百分比。') }}"
                                                lay-offset="5"
                                                class="layui-icon layui-icon-tips"></i></div>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['countryReport'] as $countryReport)
                                    <tr>
                                        <td>{{ $countryReport['rank'] }}</td>
                                        <td>{{ $countryReport['name'] }}</td>
                                        <td>{{ $countryReport['view_count'] }}</td>
                                        <td>{{ $countryReport['rate'] }}%</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <!-- 运营指数 -->
                <div class="box_20 top_20" style="padding-bottom: 0;" id="section4">
                    <div class="big_title">{{ __('运营指数') }}</div>
                    <div class="explain_title">
                        @if(in_array('OperationalScore',app('myAddons')))
                            @isset($data['website_score_model']->score)
                                <h3>{{ __('最新网站运营指数分数为') }}{{ $data['website_score_model']->score }}
                                    {{ __('分') }}，{{ __('更新时间') }}{{ $data['website_score_model']->created_at }}。</h3>
                            @endif
                        @else
                            <h3>{{ __('请安装运营指数插件后查看') }}</h3>
                        @endif
                    </div>
                    <div class="wrapper" id="sheet7">
                        <div class="sheet_canvas" id="sheet_canvas7"></div>
                    </div>
                </div>

                <!-- 内容数量 -->
                <div class="box_20 top_20" style="padding-bottom: 0;" id="section5">
                    <div class="big_title">{{ __('内容数量') }}</div>
                    <div class="wrapper" id="sheet8">
                        <div class="inner">
                            <ul class="tab_uldiv">
                                <?php
                                $content_temp_data = [
                                    [
                                        'title' => __('有效产品'),
                                        'field' => 'product_count',
                                        'month_field' => 'product_count_last_month'
                                    ],
                                    [
                                        'title' => __('产品分类'),
                                        'field' => 'product_category_count',
                                        'month_field' => 'product_category_count_last_month'
                                    ],
                                    [
                                        'title' => __('产品关键词'),
                                        'field' => 'product_tag_count',
                                        'month_field' => 'product_tag_count_last_month'
                                    ],
                                    [
                                        'title' => __('案例/应用/视频'),
                                        'field' => 'product_video_count',
                                        'month_field' => 'product_video_count_last_month'
                                    ],
                                    [
                                        'title' => __('新闻资讯'),
                                        'field' => 'article_count',
                                        'month_field' => 'article_count_last_month'
                                    ],
                                ];
                                ?>
                                @foreach($content_temp_data as $temp_k=>$content_temp_datum)
                                    <li class="testli @if($temp_k === 0) active @endif " data-value="{{ $temp_k }}">
                                        <h2>{{ $content_temp_datum['title'] }}</h2>
                                        <h3><strong>{{ $data[$content_temp_datum['field']] }}</strong>
                                            <div class="up_down">
                                                @if($data[$content_temp_datum['field']] > $data[$content_temp_datum['month_field']])
                                                    <div class="img img_up"><img
                                                            src="{{ asset('admin/images/svg/up.svg') }}"/></div>

                                                    <span
                                                        class="num red">{{ $data[$content_temp_datum['field']] - $data[$content_temp_datum['month_field']] }}</span>
                                                    <span class="compared">{{ __('较上月') }}</span>
                                                @endif
                                            </div>
                                        </h3>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="plot_content">
                                <div class="item content_item_0 active">
                                    <div class="mall_title">
                                        <h4>{{ __('有效产品') }}</h4>
                                        <p>{{ __('截至') }}{{ $current_time }}，{{ __('有效产品数量为') }}{{ $data['product_count'] }}
                                            {{ __('个') }}。
                                        </p>
                                        <?php
                                        $create_product_num = \App\Modules\Product\Models\Product::query()->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime("-1month")), date('Y-m-d H:i:s')])->count();
                                        $update_product_num = \App\Modules\Product\Models\Product::query()->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime("-1month")), date('Y-m-d H:i:s')])->count();
                                        ?>
                                        <p>
                                            {{ __('近30天新增产品') }}{{ $create_product_num }}
                                            {{ __('个') }}，{{ __('更新产品') }}{{ $update_product_num }}
                                            {{ __('个') }}
                                            @if($update_product_num < 5)
                                                {{ __('，建议每周上传和更新不少于5个产品，有利于提高搜索引擎蜘蛛索引率和快照时间') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="plot_singal" id="content_chart_0" style="width: 100%"></div>
                                </div>
                                <div class="item content_item_1">
                                    <div class="mall_title">
                                        <h4>{{ __('产品分类') }}</h4>
                                        <p>
                                            <?php
                                            $ca_count = \Illuminate\Support\Facades\DB::table('product_product_category')->groupBy('product_category_id')->get();
                                            ?>
                                            {{ __('截至') }}{{ $current_time }}，{{ __('有产品的产品分类数量为') }}{{ $ca_count->count() }}
                                            {{ __('个') }}，{{ __('建议发布不少于30个有效产品分类') }}
                                        </p>
                                    </div>
                                    <div id="content_chart_1" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item content_item_2">
                                    <div class="mall_title">
                                        <h4>{{ __('产品关键词') }}</h4>
                                        <p>{{ __('截至') }}{{ $current_time }}，{{ __('产品关键词数量为') }}{{ $data['product_tag_count'] }}
                                            {{ __('个') }} </p>
                                        @if($data['product_tag_count'] < $data['product_count']*3)
                                            <p>
                                                {{ __('每个产品都有3个关键词分配比例，建议发布不少于') }}{{ $data['product_count']*3 }}
                                                {{ __('个产品关键词') }}</p>
                                        @endif
                                    </div>
                                    <div id="content_chart_2" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item content_item_3">
                                    <div class="mall_title">
                                        <h4>{{ __('案例/应用/视频') }}</h4>
                                        <p>{{ __('截至') }}{{ $current_time }}
                                            {{ __('，案例/应用/视频数量为') }}{{ $data['product_video_count'] }}
                                            {{ __('个') }}</p>
                                        <p>{{ __('良好的视频宣传不仅仅可以提高搜索排名，更能提高询盘咨询的转化率') }}</p>
                                    </div>
                                    <div id="content_chart_3" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item content_item_4">
                                    <div class="mall_title">
                                        <h4>{{ __('新闻资讯') }}</h4>
                                        <p>{{ __('截至') }}{{ $current_time }}，{{ __('新闻资讯数量为') }}{{ $data['article_count'] }}
                                            {{ __('篇') }}，{{ __('建议每周发布不少于5篇新闻资讯') }} </p>
                                        <p>
                                            {{ __('定期更新新闻有利于保持网站的活跃度，对提高搜索引擎蜘蛛索引率和缩短快照频率大有裨益') }} </p>
                                    </div>
                                    <div id="content_chart_4" class="plot_singal" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 内容质量 -->
                <div class="box_20 top_20" style="padding-bottom:0;">
                    <div class="big_title">{{ __('内容质量') }}</div>
                    <!-- 产品名称待修改数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>{{ __('产品名称待修改数量') }}</h2>
                    </div>
                    <div class="wrapper" id="sheet9">
                        <div class="sheet_canvas" id="sheet_canvas9" style="height: 300px;"></div>
                    </div>


                    <!-- 产品关键词待修改数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>{{ __('产品关键词待修改数量') }}</h2>
                    </div>
                    <div class="wrapper" id="sheet10">
                        <div class="sheet_canvas" id="sheet_canvas10" style="height: 300px;"></div>
                    </div>


                    <!-- 产品内链待修改数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>{{ __('产品内链待修改数量') }}</h2>
                    </div>
                    <div class="wrapper" id="sheet11">
                        <div class="sheet_canvas" id="sheet_canvas11" style="height: 300px;"></div>
                    </div>

                    <!-- 产品图片重复超过3次的图片数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>{{ __('产品图片标签待修改数量') }}</h2>
                    </div>
                    <div class="wrapper" id="sheet12">
                        <div class="sheet_canvas" id="sheet_canvas12" style="height: 300px;"></div>
                    </div>
                </div>
                <!-- 财务状况 -->
                @if(in_array(auth()->user()->id,[1,2]))
                        <?php
                        $month = trim(date('m'), 0);
                        ?>
                    <div class="box_20 top_20" id="section7">
                        <div class="big_title">{{ __('账号情况') }}</div>
                        <div class="table_div">
                            <table>
                                <thead>
                                <tr>
                                    <td>{{ __('账号') }}</td>
                                    <td>{{ __('有效产品') }} <span style="color: #999;">({{ __('共计') }} | {{ $month }}{{ __('月新增') }} | {{ $month }}{{ __('月更新') }})</span>
                                    </td>
                                    <td>{{ __('询盘') }} <span style="color: #999;">({{ __('共计') }} | {{ $month }}{{ __('月新增') }})</span></td>
                                    <td>{{ __('登录次数') }}</td>
                                    <td>{{ __('上次登录时间') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['users'] as $user_data)
                                    @if(auth()->id() != 1 && $user_data['id']==1)
                                        @continue;
                                    @else
                                        <tr>
                                            <td>{{ $user_data['name'] }}</td>
                                            <td>{{ $user_data['product_count'] }}丨{{ $user_data['month_create'] }}
                                                丨{{ $user_data['month_update'] }}</td>
                                            {{--                                    <td>74丨0</td>--}}
                                            <td>{{ $user_data['inquiry_count'] }}
                                                丨{{ $user_data['inquiry_month_count'] }}</td>
                                            <td>{{ $user_data['login_count'] }}
                                                | {{ $user_data['login_month_count'] }}</td>
                                            <td>{{ $user_data['last_login_at'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="home_fr">
            <div class="fix_stiky">
                <div class="box_20">
                    @if(in_array('OperationalScore',app('myAddons')))
                        <div class="module_08">
                            <div class="mian_title">
                                <h2 style="text-align: center; width: 100%">
                                    {{ __('网站运营指数') }}
                                </h2>
                            </div>
                            <div id="round-box"></div>
                            <div class="detail_btn ">
                                <a href="javascript:void(0)" class="flash_white redirect_btn"
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
        </div>
    </div>
    @section('css')
        <link rel="stylesheet" href="{{ asset('/report/css/versiontwo.css') }}"/>
    @endsection
    @section('scripts')
        <script type="text/javascript" src="{{ asset('report/js/versiontwo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('report/js/circleChart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('report/js/echarts.js') }}"></script>
        <script>
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
            // 内容信息导航吸顶
            $(document).ready(function () {
                var navHeight = $("#navHeight").offset().top;
                var navFix = $("#nav-wrap");
                $(window).scroll(function () {
                    if ($(this).scrollTop() > navHeight) {
                        navFix.addClass("navFix");
                    } else {
                        navFix.removeClass("navFix");
                    }
                })
                //内容信息导航锚点
                $('#nav-wrap').navScroll({
                    mobileDropdown: true,
                    mobileBreakpoint: 768,
                    scrollSpy: true
                });
            })

        </script>
        <script src="{{ asset('/js/admin/admin.dataManager.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
