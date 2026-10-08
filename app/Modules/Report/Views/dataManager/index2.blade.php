<x-layui-layout>
    <style>
        body {
            background: #F7F8FA;
        }
    </style>
    <body>
    <div class="js_page_nav" id="navHeight">
        <input type="hidden" value="{{ csrf_token() }}" id="token">
        <ul id="nav-wrap">
            <li class="pnav_item">
                <a href="#section1" class="active">数据概况</a>
            </li>
            <li class="pnav_item">
                <a href="#section2" class="pnav_link">推广成效</a>
            </li>
            <li class="pnav_item">
                <a href="#section3" class="pnav_link">流量分析</a>
            </li>
            <li class="pnav_item">
                <a href="#section4" class="pnav_link">运营指数</a>
            </li>
            <li class="pnav_item">
                <a href="#section5" class="pnav_link">内容数量</a>
            </li>
            <li class="pnav_item">
                <a href="#section6" class="pnav_link">工具使用</a>
            </li>
            <li class="pnav_item">
                <a href="#section7" class="pnav_link">账号情况</a>
            </li>
        </ul>
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
                                        <h2>基本概况</h2>
                                    </div>
                                    <ul>
                                        <li>营销网站域名：{{ parse_url(url('/'))['host'] }}
                                            @if(isset($website_info['start_time']) && time() < strtotime($website_info['expiration_time']))
                                                <span style="color: #16A291;padding-left: 10px;">使用中</span>
                                            @else
                                                <span style="color: red;padding-left: 10px;">已停用</span>
                                            @endif
                                        </li>
                                        <li>营销网站上线时间：{{!is_null($website_info) ? $website_info['start_time'] : ''}}</li>
                                        <li>营销网站多语言：{{ $data['locale_count'] }}种语言<a data-value="view_locale" class="redirect_btn" href="javascript:viod(0)"
                                                                      style="color: #656EE5;padding-left: 10px;">查看所有多语言及服务器</a>
                                        </li>
                                        @isset($website_info['count_month'])
                                        <li>网站服务时间共计{{ $website_info['count_month'] }}个月，已达标{{ $website_info['db_month'] }}个月，剩余服务时间{{ $website_info['sy_month'] }}个月</li>
                                        @endif
                                        <li>预计到期时间：{{!is_null($website_info) ? $website_info['expiration_time'] : ''}}</li>
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
                                        <h2>运营中心</h2>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="img">
                                                <img src="{{ asset('admin/images/svg/svg_17.svg') }}"/>
                                            </div>
                                            <div class="txt">
                                                <h4>客服经理</h4>
                                                <p>TEL:{{!is_null($website_info) ? $website_info['customer_manager_tel'] : ''}} <br>Email:{{!is_null($website_info) ? $website_info['customer_manager_email'] : ''}}</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="img">
                                                <img src="{{ asset('admin/images/svg/svg_18.svg') }}"/>
                                            </div>
                                            <div class="txt">
                                                <h4>销售经理</h4>
                                                <p>TEL:{{!is_null($website_info) ? $website_info['operations_manager_tel'] : ''}} <br>Email:{{!is_null($website_info) ? $website_info['operations_manager_email'] : ''}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_20 top_20" id="section1">
                    <div class="module_03">
                        <div class="mian_title" style="padding-top: 20px;">
                            <h2>数据概况<span>截至{{ date('Y-m-d') }} 00:00:00 </span></h2>
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
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_07.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>317<span>个</span></h4>
                                    <p>有效产品</p>
                                </div>
                            </li>
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
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_12.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>567<span>篇</span></h4>
                                    <p>新闻资讯</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_13.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>100<span>个</span></h4>
                                    <p>关键词智能挖掘
                                    </p>
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
                            <li>
                                <div class="image">
                                    <img src="{{ asset('admin/images/svg/svg_15.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>
                                        272<span style="padding-right: 15px">个</span
                                        >
                                    </h4>
                                    <p>啄木鸟线索</p>
                                </div>
                            </li>
                            <li>
                                <div class="image">
                                    <img style="padding-top: 3px;" src="{{ asset('admin/images/svg/svg_16.svg') }}"/>
                                </div>
                                <div class="txt">
                                    <h4>
                                        <span style="padding-left:0">本月</span>0<span style="padding-left: 0"
                                        >个词</span
                                        ><span style="padding-left: 15px">累计</span
                                        >74<span>条</span>
                                    </h4>
                                    <p> Listing</p>
                                </div>
                            </li>
                        </ul>
                        <div class="renew">
                            <p>最新发布产品时间：{{ isset($data['last_create_product']['created_at'])?$data['last_create_product']['created_at']:'' }}</p>
                            <p>最新更新产品时间：{{ isset($data['last_update_product']['updated_at'])?$data['last_update_product']['updated_at']:'' }}</p>
                            <p>最新登录时间：{{ auth()->user()->last_login_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- 推广成效 -->
                <div class="box_20 top_20" id="section2">
                    <div class="datebox">
                        <div class="date_filter">
                            <div class="layui-inline">
                                <div class="layui-inline">
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" id="start-date" placeholder="开始日期">
                                    </div>
                                    <div class="layui-form-mid">至</div>
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" id="end-date" placeholder="结束日期">
                                    </div>
                                </div>
                            </div>
                            <div class="datasure flash_white" id="generated_data">生成数据</div>
                        </div>
                        <p>
                            产品收录率、网站运营指数、产品各项待修改数量、产品分类部分数据、产品关键词比例为数据管家新增内容，数据从2021年7月开始记录
                        </p>
                    </div>
                    <div class="single_01">
                        <div class="big_title">推广成效</div>
                        <div class="sec_title" style="margin-bottom: 8px;">
                            <h2>关键词排名</h2>
                        </div>
                        <div class="explain_title">
                            <h3>最新关键词排名 Google1-10位：<span>1450</span>个词。</h3>
                            <div class="more"><a href="javascript:void(0)" class="keywords_download">下载更多</a><a class="redirect_btn" data-value="keywordRank" href="javascript:void(0)">查看更多</a></div>
                        </div>
                        <div class="table_div">
                            <table>
                                <thead>
                                <tr>
                                    <td>关键词</td>
                                    <td>排名URL</td>
                                    <td>
                                        <div class="san_father">
                                            谷歌排名<i class="san_top"></i><i class="san_bot"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="san_father">
                                            更新时间<i class="san_top"></i><i class="san_bot"></i>
                                        </div>
                                    </td>
                                    <td>谷歌快照</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($keywordsRankData as $keywordsRankDatum)
                                <tr>
                                    <td>{{ $keywordsRankDatum['name'] }}</td>
                                    <td><a href="{{ $keywordsRankDatum['discrepancy']['catch_url'] }}" target="_blank">{{ $keywordsRankDatum['discrepancy']['catch_url'] }}</a></td>
                                    <td>
                                        <div class="flex"><span class="num">{{ $keywordsRankDatum['current_rank'] }}</span>
                                            @if($keywordsRankDatum['discrepancy']['type'])
                                            @if($keywordsRankDatum['discrepancy']['type'] === 'up')
                                            <div class="img"><img src="{{ asset('admin/images/svg/up.svg') }}"/></div>
                                            <span class="red">{{ $keywordsRankDatum['discrepancy']['num'] }}</span>
                                            @else
                                                <div class="img"><img src="{{ asset('admin/images/svg/down.svg') }}"/></div>
                                                <span class="green">{{ $keywordsRankDatum['discrepancy']['num'] }}</span>
                                            @endif
                                            @endif
                                        </div>

                                    </td>
                                    <td>{{ $keywordsRankDatum['discrepancy']['check_date'] }}</td>
                                    <td><a href="#" target="_blank">查看</a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="top_40">
                        <div class="single_01_01">
                            <div class="sec_title">
                                <h2>关键词排名数量<b>(提示：查询Google.com排名时，请访问英文Google:<a
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
                            <h2>询盘数量<b>(截至2023-03-09 00:00:00，累计询盘数量为50个)</b></h2>
                        </div>
                        <div class="wrapper" id="sheet2">
                            <div class="sheet_canvas" id="sheet_canvas2" style="margin-top: 30px"></div>
                        </div>
                        <div class="wrapper" id="sheet3">
                            <div class="sheet_canvas" id="sheet_canvas3" style="margin-top: -10px"></div>
                        </div>
                        <div class="sec_title">
                            <h2>询盘地域<b>(截至2023-03-09
                                    00:00:00，询盘总共来自23个国家及地区。累计询盘地域分布如下所示)</b></h2>
                        </div>
                        <div class="wrapper" id="sheet4">
                            <div class="sheet_canvas" id="sheet_canvas4"></div>
                        </div>

                        <div class="top_40">
                            <div class="sec_title">
                                <h2>产品收录率<b>(最新产品收录率为14.51%，更新时间：2023-03-01。)</b></h2>
                            </div>
                            <div class="wrapper" id="sheet6">
                                <div class="sheet_canvas" id="sheet_canvas6"></div>
                            </div>
                        </div>
                        <div class="explain_title">
                            <h3></h3>
                            <div class="more"><a href="#">查看更多</a></div>
                        </div>
                        <div class="table_div">
                            <table>
                                <thead>
                                <tr>
                                    <td>序号</td>
                                    <td>产品分类</td>
                                    <td>产品数量（有收录/总数）</td>
                                    <td>收录率</td>
                                    <td>更新时间</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#" target="_blank">RFID reader</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="#" target="_blank">Microchip Applicator Gun</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><a href="#" target="_blank">RFID reader</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><a href="#" target="_blank">Microchip Applicator Gun</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><a href="#" target="_blank">RFID reader</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><a href="#" target="_blank">Microchip Applicator Gun</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><a href="#" target="_blank">RFID reader</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td><a href="#" target="_blank">Microchip Applicator Gun</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td><a href="#" target="_blank">RFID reader</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td><a href="#" target="_blank">Microchip Applicator Gun</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td><a href="#" target="_blank">RFID reader</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td><a href="#" target="_blank">Microchip Applicator Gun</a></td>
                                    <td>1/1</td>
                                    <td>100.00%</td>
                                    <td>2023-03-01</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 流量分析 -->
                <div class="box_20 top_20" id="section3">
                    <div class="big_title">流量分析</div>
                    <!-- 访客分析 -->
                    <div class="sec_title" style="margin-bottom: 8px;">
                        <h2>访客分析</h2>
                    </div>
                    <div class="explain_title">
                        <h3 style="width: calc(100% - 86px);">
                            访问次数最多的是2022-05，浏览次数（PV）最多的是2022-11，访客数（UV）最多的是2022-08，跳出率最低的是2023-02</h3>
                        <div class="more" style="width: 76px;"><a href="#">查看更多</a></div>
                    </div>
                    <div class="table_div minwidth_two">
                        <table>
                            <thead>
                            <tr>
                                <td>月份</td>
                                <td>
                                    <div class="tips_hint"><span>访问次数</span><i
                                            lay-tips="visit，访客访问网站的次数。访客第一次访问您网站或者距离上次访问时间超过30分钟，会被统计为新的访问。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>环比增长</td>
                                <td>
                                    <div class="tips_hint"><span>浏览次数(PV)</span><i
                                            lay-tips="page view，访客浏览的页面总数。每打开一个页面就被记录一次，多次打开同一个页面，浏览次数累计。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>环比增长</td>
                                <td>
                                    <div class="tips_hint"><span>访客数(UV)</span><i
                                            lay-tips="unique visitor，您网站的独立访客数(以Cookie为依据)，一天内同一访客多次访问您网站只计算一个访客。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>环比增长</td>
                                <td>
                                    <div class="tips_hint"><span>跳出率</span><i
                                            lay-tips="只浏览了一个页面便离开网站的访问次数占总访问次数的百分比。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>环比增长</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="green">-3.51%</td>
                                <td>651</td>
                                <td class="green">-13.89%</td>
                                <td>299</td>
                                <td class="green">-0.33%</td>
                                <td>63%</td>
                                <td class="red">1.61%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="red">4.51%</td>
                                <td>651</td>
                                <td class="red">12.49%</td>
                                <td>299</td>
                                <td class="red">0.33%</td>
                                <td>63%</td>
                                <td class="green">-2.85%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="green">-3.51%</td>
                                <td>651</td>
                                <td class="green">-13.89%</td>
                                <td>299</td>
                                <td class="green">-0.33%</td>
                                <td>63%</td>
                                <td class="red">1.61%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="red">4.51%</td>
                                <td>651</td>
                                <td class="red">12.49%</td>
                                <td>299</td>
                                <td class="red">0.33%</td>
                                <td>63%</td>
                                <td class="green">-2.85%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="green">-3.51%</td>
                                <td>651</td>
                                <td class="green">-13.89%</td>
                                <td>299</td>
                                <td class="green">-0.33%</td>
                                <td>63%</td>
                                <td class="red">1.61%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="red">4.51%</td>
                                <td>651</td>
                                <td class="red">12.49%</td>
                                <td>299</td>
                                <td class="red">0.33%</td>
                                <td>63%</td>
                                <td class="green">-2.85%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="green">-3.51%</td>
                                <td>651</td>
                                <td class="green">-13.89%</td>
                                <td>299</td>
                                <td class="green">-0.33%</td>
                                <td>63%</td>
                                <td class="red">1.61%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="red">4.51%</td>
                                <td>651</td>
                                <td class="red">12.49%</td>
                                <td>299</td>
                                <td class="red">0.33%</td>
                                <td>63%</td>
                                <td class="green">-2.85%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="green">-3.51%</td>
                                <td>651</td>
                                <td class="green">-13.89%</td>
                                <td>299</td>
                                <td class="green">-0.33%</td>
                                <td>63%</td>
                                <td class="red">1.61%</td>
                            </tr>
                            <tr>
                                <td>2023-07</td>
                                <td>302</td>
                                <td class="red">4.51%</td>
                                <td>651</td>
                                <td class="red">12.49%</td>
                                <td>299</td>
                                <td class="red">0.33%</td>
                                <td>63%</td>
                                <td class="green">-2.85%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 访问次数TOP10的页面 -->
                    <div class="sec_title top_40" style="margin-bottom: 8px;">
                        <h2>访问次数TOP10的页面</h2>
                    </div>
                    <div class="explain_title">
                        <h3>在此期间，访问次数最多的页面是<a href="http://www.fofiatag.com/">http://www.fofiatag.com/</a>，为1690。可以对访问次数较多的页面进行内容调整，比如放置一些爆款，把热门分类放置在更前面等，提高转化率
                        </h3>
                    </div>
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>序号</td>
                                <td>页面链接</td>
                                <td>
                                    <div class="tips_hint"><span>访问次数</span><i
                                            lay-tips="visit，访客访问网站的次数。访客第一次访问您网站或者距离上次访问时间超过30分钟，会被统计为新的访问。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>
                                    <div class="tips_hint"><span>浏览次数(PV)</span><i
                                            lay-tips="page view，统计周期内，访客浏览该页面的次数。页面每打开一次就被记录一次，多次打开，浏览次数累计。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><a href="#" target="_blank">/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><a href="#" target="_blank">/portable-reader/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><a href="#" target="_blank">/contact.html</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><a href="#" target="_blank">/animal-microchip/</a></td>
                                <td>1690</td>
                                <td>2032</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 访问次数TOP10的国家与地区 -->
                    <div class="sec_title top_40" style="margin-bottom: 8px;">
                        <h2>访问次数TOP10的国家与地区</h2>
                    </div>
                    <div class="explain_title">
                        <h3>
                            在此期间，访问次数最多的国家与地区是中国，为1127，可以发布更多的更吸引访问次数较多的国家喜欢的产品</h3>
                    </div>
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>序号</td>
                                <td>国家与地区</td>
                                <td>
                                    <div class="tips_hint"><span>访问次数</span><i
                                            lay-tips="visit，访客访问网站的次数。访客第一次访问您网站或者距离上次访问时间超过30分钟，会被统计为新的访问。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>
                                    <div class="tips_hint"><span>访问次数占比</span><i
                                            lay-tips="统计周期内，某国家的访问次数占总访问次数的百分比。" lay-offset="5"
                                            class="layui-icon layui-icon-tips"></i></div>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>中国</td>
                                <td>1127</td>
                                <td>34.81%</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>美国</td>
                                <td>641</td>
                                <td>19.8%</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>俄罗斯</td>
                                <td>245</td>
                                <td>7.57%</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>法国</td>
                                <td>245</td>
                                <td>4.05%</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>澳大利亚</td>
                                <td>245</td>
                                <td>2.1%</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>加拿大</td>
                                <td>245</td>
                                <td>2.01%</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>德国</td>
                                <td>245</td>
                                <td>1.79%</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>马达加斯加</td>
                                <td>245</td>
                                <td>1.73%</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>日本</td>
                                <td>245</td>
                                <td>1.58%</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>韩国</td>
                                <td>245</td>
                                <td>1.39%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 跳出率TOP10的页面 -->
                    <div class="sec_title top_40" style="margin-bottom: 8px;">
                        <h2>跳出率TOP10的页面</h2>
                    </div>
                    <div class="explain_title">
                        <h3>在此期间，跳出率最高的是<a href="#" target="_blank">https://dyyseo.com</a>。可以分析该页面存在的问题，减少跳出率
                        </h3>
                    </div>
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>序号</td>
                                <td>页面链接</td>
                                <td>
                                    <div class="tips_hint"><span>进入</span><i lay-tips="visit，统计周期内，从这个页面开始的访问次数。"
                                                                               lay-offset="5"
                                                                               class="layui-icon layui-icon-tips"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="tips_hint"><span>跳出次数</span><i
                                            lay-tips="统计周期内，从这个页面开始并结束的访问次数。说明访客只查看该页面后就离开网站。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                                <td>
                                    <div class="tips_hint"><span>跳出率</span><i
                                            lay-tips="统计周期内，从这个页面开始并结束的访问次数占从这个页面开始的访问次数的百分比。"
                                            lay-offset="5" class="layui-icon layui-icon-tips"></i></div>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><a href="#" target="_blank">/portable-reader/60310436.html</a></td>
                                <td>17</td>
                                <td>17</td>
                                <td>100%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 运营指数 -->
                <div class="box_20 top_20" style="padding-bottom: 0;" id="section4">
                    <div class="big_title">运营指数</div>
                    <div class="explain_title">
                        <h3>最新网站运营指数分数为64分，更新时间：2023-08-11 22:41:31。建议网站运营指数达到90分</h3>
                    </div>
                    <div class="wrapper" id="sheet7">
                        <div class="sheet_canvas" id="sheet_canvas7"></div>
                    </div>
                </div>

                <!-- 内容数量 -->
                <div class="box_20 top_20" style="padding-bottom: 0;" id="section5">
                    <div class="big_title">内容数量1111</div>
                    <div class="wrapper" id="sheet8">
                        <div class="inner">
                            <ul class="tab_uldiv">
                                <li class="testli active" render-dom="plot1" render-option="0">
                                    <h2>有效产品</h2>
                                    <h3><strong>317</strong>
                                        <div class="up_down">
                                            <div class="img img_up"><img src="{{ asset('admin/images/svg/up.svg') }}"/>
                                            </div>
                                            <span class="num red">8</span><span class="compared">较上月</span></div>
                                    </h3>
                                </li>
                                <li class="testli" render-dom="plot2" render-option="1">
                                    <h2>产品分类</h2>
                                    <h3><strong>27</strong>
                                        <div class="up_down">
                                            <div class="img img_down"><img
                                                    src="{{ asset('admin/images/svg/down.svg') }}"/></div>
                                            <span class="num green">9</span><span class="compared">较上月</span></div>
                                    </h3>
                                </li>
                                <li class="testli" render-dom="plot3" render-option="2">
                                    <h2>产品关键词</h2>
                                    <h3><strong>948</strong></h3>
                                </li>
                                <li class="testli" render-dom="plot4" render-option="3">
                                    <h2>视频</h2>
                                    <h3><strong>576</strong></h3>
                                </li>
                                <li class="testli" render-dom="plot5" render-option="4">
                                    <h2>新闻资讯</h2>
                                    <h3><strong>13</strong></h3>
                                </li>
                            </ul>
                            <div class="plot_content">
                                <div class="item active">
                                    <div class="mall_title">
                                        <h4>有效产品</h4>
                                        <p>截至2023-08-15 00:00:00，有效产品数量为317个，建议发布不少于250个有效产品 </p>
                                        <p>近30天新增产品0个，更新产品1个，建议每周上传和更新不少于5个产品，有利于提高搜索引擎蜘蛛索引率和快照时间</p>
                                    </div>
                                    <div id="plot1" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item">
                                    <div class="mall_title">
                                        <h4>产品分类</h4>
                                        <p>
                                            截至2023-08-15 00:00:00，有产品的产品分类数量为27个，建议发布不少于30个有效产品分类
                                        </p>
                                    </div>
                                    <div id="plot2" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item">
                                    <div class="mall_title">
                                        <h4>产品关键词</h4>
                                        <p>截至2023-08-15 00:00:00，产品关键词数量为949个 </p>
                                        <p>每个产品都有3个关键词分配比例，建议发布不少于750个产品关键词</p>
                                    </div>
                                    <div id="plot3" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item">
                                    <div class="mall_title">
                                        <h4>视频</h4>
                                        <p>截至2023-08-15 00:00:00，视频数量为576个</p>
                                        <p>良好的视频宣传不仅仅可以提高搜索排名，更能提高询盘咨询的转化率</p>
                                    </div>
                                    <div id="plot4" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item">
                                    <div class="mall_title">
                                        <h4>新闻资讯</h4>
                                        <p>截至2023-08-15 00:00:00，新闻资讯数量为13篇，建议每周发布不少于5篇新闻资讯 </p>
                                        <p>
                                            定期更新新闻有利于保持网站的活跃度，对提高搜索引擎蜘蛛索引率和缩短快照频率大有裨益 </p>
                                    </div>
                                    <div id="plot5" class="plot_singal" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 内容质量 -->
                <div class="box_20 top_20" style="padding-bottom:0;">
                    <div class="big_title">内容质量</div>
                    <div class="wrapper">
                        <div class="inner">
                            <ul class="tab_uldiv tab_uldiv_thr">
                                <li class="testli active" render-dom="plot6" render-option="5">
                                    <h2>产品综合得分</h2>
                                    <h3><strong>88</strong>
                                        <div class="up_down">
                                            <div class="img img_up"><img src="{{ asset('admin/images/svg/up.svg') }}"/>
                                            </div>
                                            <span class="num red">18</span><span class="compared">较上月</span></div>
                                    </h3>
                                </li>
                                <li class="testli" render-dom="plot7" render-option="6">
                                    <h2>产品分类综合得分</h2>
                                    <h3><strong>36</strong>
                                        <div class="up_down">
                                            <div class="img img_down"><img
                                                    src="{{ asset('admin/images/svg/down.svg') }}"/></div>
                                            <span class="num green">9</span><span class="compared">较上月</span></div>
                                    </h3>
                                </li>
                                <li class="testli" render-dom="plot8" render-option="7">
                                    <h2>产品关键词比例</h2>
                                    <h3><strong>3.0</strong></h3>
                                </li>
                            </ul>
                            <div class="plot_content">
                                <div class="item active">
                                    <div class="mall_title">
                                        <h4>产品综合得分</h4>
                                        <p>
                                            产品综合得分是您优化通营销网站产品内容质量分数的综合评定，100分为最高分</p>
                                    </div>
                                    <div id="plot6" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item">
                                    <div class="mall_title">
                                        <h4>产品分类综合得分</h4>
                                        <p>
                                            产品分类综合得分是您优化通营销网站产品分类质量分数的综合评定，100分为最高分
                                        </p>
                                    </div>
                                    <div id="plot7" class="plot_singal" style="width: 100%"></div>
                                </div>
                                <div class="item">
                                    <div class="mall_title">
                                        <h4>产品关键词比例</h4>
                                        <p>截至2023-08-15 00:00:00，关键词比例为3.0</p>
                                        <p>每个产品都有3个关键词分配比例，如果数值是3则说明关键词没有重复</p>
                                        <p>如果数值为2到3，则关键词比例分配还有改进的空间</p>
                                        <p>如果关键词数值在0到2之间，则关键词重复率很高，必须进行修改</p>
                                    </div>
                                    <div id="plot8" class="plot_singal" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 产品内容质量 -->
                    <div class="sec_title" style="margin-bottom: 8px;">
                        <h2>产品内容质量</h2>
                    </div>
                    <div class="explain_title">
                        <h3><p>产品内容质量是您优化通营销网站产品的分数评定，100分为最高分，低于60分建议进行修改</p>
                            <p>截至2023-03-13 00:00:00，待修改产品数量：0个</p></h3>
                    </div>
                    <div class="wrapper" id="sheet8">
                        <div class="sheet_canvas" id="sheet_canvas8"></div>
                    </div>


                    <!-- 产品名称待修改数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>产品名称待修改数量</h2>
                    </div>
                    <div class="wrapper" id="sheet9">
                        <div class="sheet_canvas" id="sheet_canvas9" style="height: 300px;"></div>
                    </div>


                    <!-- 产品关键词待修改数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>产品关键词待修改数量</h2>
                    </div>
                    <div class="wrapper" id="sheet10">
                        <div class="sheet_canvas" id="sheet_canvas10" style="height: 300px;"></div>
                    </div>


                    <!-- 产品内链待修改数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>产品内链待修改数量</h2>
                    </div>
                    <div class="wrapper" id="sheet11">
                        <div class="sheet_canvas" id="sheet_canvas11" style="height: 300px;"></div>
                    </div>

                    <!-- 产品图片重复超过3次的图片数量 -->
                    <div class="sec_title top_30" style="margin-bottom: 8px;">
                        <h2>产品图片重复超过3次的图片数量</h2>
                    </div>
                    <div class="wrapper" id="sheet12">
                        <div class="sheet_canvas" id="sheet_canvas12" style="height: 300px;"></div>
                    </div>
                </div>

                <!-- 工具使用 -->
                <div class="box_20 top_20" id="section6">
                    <div class="big_title">工具使用<span
                            style="padding-left: 10px;color: #999;font-weight: normal;font-size: 13px;">截至2023-03-14 00:00:00</span>
                    </div>
                    <div class="toolbox">
                        <dl>
                            <dd>
                                <div class="tool_title">
                                    <h4>邮件营销</h4>
                                    <div class="onoffdiv"></div>
                                </div>
                                <div class="txt_p">
                                    <p>本月<span>0</span>条&nbsp;&nbsp;累计<span>74</span>条</p>
                                </div>
                                <h6>许可式EDM邮件营销服务，进行主动营销，建议定期使用</h6>
                            </dd>
                            <dd>
                                <div class="tool_title">
                                    <h4>平台广告</h4>
                                    <div class="onoffdiv"></div>
                                </div>
                                <div class="txt_p">
                                    <p>TopRankA<span>0</span>个&nbsp;&nbsp;TopRankB<span>0</span>个</p>
                                    <p>TopRankC<span>0</span>个&nbsp;&nbsp;搜索精准展位<span>0</span>个</p>
                                </div>
                                <h6>在平台内投放广告将为您带来高质量的精准客户流量，提高营销效果</h6>
                            </dd>
                            <dd>
                                <div class="tool_title">
                                    <h4>买家数据库</h4>
                                    <div class="onoffdiv"></div>
                                </div>
                                <div class="txt_p">
                                    <p>本月查看<span>0</span>条&nbsp;&nbsp;本月发送<span>0</span> 条</p>
                                    <p>累计查看<span>161</span>条&nbsp;&nbsp;累计发送<span>110</span>条</p>
                                </div>
                                <h6>买家数据库是主动营销工具，建议定期使用</h6>
                            </dd>
                            <dd class="ondd">
                                <div class="tool_title">
                                    <h4>全球站链</h4>
                                    <div class="onoffdiv"><i class="icon-smile"></i>已开通</div>
                                </div>
                                <div class="txt_p"></div>
                                <h6>全球站链助你霸占谷歌首屏排名，建议开通</h6>
                            </dd>
                            <dd class="ondd">
                                <div class="tool_title">
                                    <h4>推荐商机</h4>
                                    <div class="onoffdiv"><i class="icon-smile"></i>已开通</div>
                                </div>
                                <div class="txt_p"></div>
                                <h6>推荐商机精准推送采购需求，海外订单不用愁，建议定期使用</h6>
                            </dd>
                            <dd class="offdd">
                                <div class="tool_title">
                                    <h4>海关数据</h4>
                                    <div class="onoffdiv"><i class="icon-frown"></i>未开通</div>
                                </div>
                                <div class="txt_p"></div>
                                <h6>
                                    34个国家和地区进出口海关提单数据、关单数据，快速开发新客户、分析老客户、监控竞争对手提供强有力的数据支撑，建议开通并定期使用</h6>
                            </dd>
                            <dd class="offdd">
                                <div class="tool_title">
                                    <h4>Google广告</h4>
                                    <div class="onoffdiv"><i class="icon-frown"></i>未开通</div>
                                </div>
                                <div class="txt_p">

                                </div>
                                <h6>Google广告为您精准链接全球商机，开启您的网络推广。建议开通并定期使用</h6>
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- 财务状况 -->
                <div class="box_20 top_20" id="section7">
                    <div class="big_title">财务状况</div>
                    <div class="table_div">
                        <table>
                            <thead>
                            <tr>
                                <td>账号</td>
                                <td>有效产品 <span style="color: #999;">(共计 | 3月新增 | 3月更新)</span></td>
                                <td>邮件营销 <span style="color: #999;">(共计 | 3月新增)</span></td>
                                <td>询盘 <span style="color: #999;">(共计 | 3月新增)</span></td>
                                <td>登录次数</td>
                                <td>上次登录时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>fofiatag</td>
                                <td>198丨0丨0</td>
                                <td>74丨0</td>
                                <td>47丨1</td>
                                <td>47丨1</td>
                                <td>2023-03-14 14:14:32</td>
                            </tr>
                            <tr>
                                <td>Alva</td>
                                <td>198丨0丨0</td>
                                <td>74丨0</td>
                                <td>47丨1</td>
                                <td>47丨1</td>
                                <td>2023-03-14 14:14:32</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if(in_array('OperationalScore',app('myAddons')))
            <div class="home_fr">
                <div class="fix_stiky">
                    <div class="box_20">
                        <div class="module_08">
                            <div class="mian_title">
                                <h2 style="text-align: center; width: 100%">
                                    网站运营指数
                                </h2>
                            </div>
                            <div id="round-box"></div>
                            <div class="detail_btn ">
                                <a href="javascript:void(0)" class="flash_white redirect_btn" data-value="operational/score">查看详情</a>
                            </div>
                            <h5>
                                关键词等检查是检测优化通营销网站关键词等分布的合理性，匹配度和个数等，有助于提高网站排名
                            </h5>
                        </div>
                    </div>
                    <!-- <div class="submit_order">
                        <a href="#" class="flash_white">网站SEO自检</a>
                    </div> -->
                </div>
            </div>
        @endif
    </div>
    @section('css')
        <link rel="stylesheet" href="{{ asset('/report/css/versiontwo.css') }}"/>
    @endsection
    @section('scripts')
        <script type="text/javascript" src="{{ asset('report/js/jquery-1.10.2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('report/js/versiontwo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('report/js/circleChart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('report/js/echarts.js') }}"></script>
        <script>


      //sheet_canvas2
      $(function () {
        var dom = document.getElementById("sheet_canvas2");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          tooltip: {
            trigger: "axis",
            axisPointer: {
              type: "shadow",
            },
          },

          xAxis: [
            {
              type: "category",
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: [
            {
              type: "value",
              name: "累计询盘数量",
              nameGap: 30,
              splitLine: {
                show: true,
                lineStyle: {
                  color: "#ECEEF6",
                },
              },
              nameTextStyle: {
                color: "#444", // 设置Y轴标题颜色
                fontSize: 13, // 更改Y轴轴标题文字大小
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          series: [
            {
              name: "累计询盘数量",
              type: "bar",
              data: [20, 32, 18, 25, 30, 20, 36, 80, 99, 86, 56, 75],
              barGap: "40%",
              barCategoryGap: "40%",
             barMaxWidth: 20,// 设置柱状图最大宽度
              itemStyle: {
                barBorderRadius: [2, 2, 2, 2],
                color: new echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1, // 渐变方向
                  [
                    { offset: 0, color: "#656EE5" }, // 渐变起始颜色
                    { offset: 1, color: "#757EF3" }, // 渐变结束颜色
                  ]
                ),
                label: {
                  show: true, //开启显示
                  position: "top", //在上方显示
                  textStyle: {
                    //数值样式
                    color: "#333",
                  },
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas3
      $(function () {
        var dom = document.getElementById("sheet_canvas3");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
            // formatter: '{b0}<br/><i class="ele-chart-dot" style="width:10px;height:10px;background: #ccc;"></i>网站运营指数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {c0}',
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            name: "每月询盘数量",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "每月询盘数量",
              type: "line",
              data: [
                820, 932, 901, 934, 1290, 1330, 1320, 820, 932, 901, 934, 1290,
              ],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#33D0BD",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas4
      $(function () {
        var dom = document.getElementById("sheet_canvas4");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });

        var app = {};

        var option;

        option = {
          title: {
            left: "center",
          },
          tooltip: {
            trigger: "item",
            formatter: "{a} <br/>{b} : {c} ({d}%)",
          },

          legend: {
            type: "scroll",
            orient: "horizontal",
            show: true,
            bottom: "0",
            pageIconSize: 10,
            pageTextStyle: {
              fontSize: 10, // 滚动箭头文字的字号
            },
            itemWidth: 10,
            itemHeight: 8,
            textStyle: {
              color: "#777",
              fontSize: 12, // 图例文字的字号
            },
            padding: 0, // 内边距，增加上下空间
            formatter: function (name) {
              // 自定义图例的显示方式，避免文字截断
              return echarts.format.truncateText(name, 100, "14px Arial"); // 最大显示100个字符
            },
          },
          grid: {
            top: 10, // 调整图例与饼状图之间的距离
            bottom: 200, // 预留底部空间
          },
          series: [
            {
              type: "pie",
              radius: ["40%", "70%"],
              label: {
                normal: {
                  // formatter: '{d}%',
                  show: true,
                  formatter: "{b} : {d}%",
                  shadowColor: "rgba(0, 0, 0, 0.5)",
                  rich: {
                    //设置标识内容样式
                    per: {
                      color: "rgba(133, 138, 155, 1)", //设置变量per的颜色，即设置{d}%的颜色
                      padding: [2, 4],
                      borderRadius: 2,
                    },
                    ng: {
                      color: "rgba(92, 164, 252, 1)",
                    },
                  },

                  textStyle: {
                    fontSize: "15",
                    color: "#444",
                  },
                },
              },
              itemStyle: {
                borderColor: "#fff",
                borderWidth: 1,
                color: function (params) {
                  var colorList = [
                  '#656EE5', '#65B0E5', '#0CD6BE', '#29D4E1', '#6CD9B3', '#2FC25A', '#87C554', '#FACC14', '#E6965C', '#FE706E', '#D66BB2', '#8E4FE1','#656EE5', '#65B0E5', '#0CD6BE', '#29D4E1', '#6CD9B3', '#2FC25A', '#87C554', '#FACC14', '#E6965C', '#FE706E', '#D66BB2', '#8E4FE1','#656EE5', '#65B0E5', '#0CD6BE', '#29D4E1', '#6CD9B3', '#2FC25A', '#87C554', '#FACC14', '#E6965C', '#FE706E', '#D66BB2', '#8E4FE1','#656EE5', '#65B0E5', '#0CD6BE', '#29D4E1', '#6CD9B3', '#2FC25A', '#87C554', '#FACC14', '#E6965C', '#FE706E', '#D66BB2', '#8E4FE1','#656EE5', '#65B0E5', '#0CD6BE', '#29D4E1', '#6CD9B3', '#2FC25A', '#87C554', '#FACC14', '#E6965C', '#FE706E', '#D66BB2', '#8E4FE1','#656EE5', '#65B0E5', '#0CD6BE', '#29D4E1', '#6CD9B3', '#2FC25A', '#87C554', '#FACC14', '#E6965C', '#FE706E', '#D66BB2', '#8E4FE1',
                  ]; // 自定义颜色列表
                  return colorList[params.dataIndex];
                },
              },
              labelLine: {
                normal: {
                  show: true,
                },
              },
              data: [
                {
                  value: 500,
                  name: "美国",
                },
                {
                  value: 400,
                  name: "巴西",
                },
                {
                  value: 300,
                  name: "委内瑞拉",
                },
                {
                  value: 700,
                  name: "巴基斯坦",
                },
                {
                  value: 700,
                  name: "印度尼西亚",
                },
                {
                  value: 300,
                  name: "尼泊尔",
                },
                {
                  value: 300,
                  name: "加拿大",
                },
                {
                  value: 1000,
                  name: "埃及",
                },
                {
                  value: 300,
                  name: "泰国",
                },
                {
                  value: 100,
                  name: "印度",
                },
                {
                  value: 300,
                  name: "法国",
                },
                {
                  value: 300,
                  name: "博茨瓦纳",
                },
                {
                  value: 300,
                  name: "博茨瓦纳",
                },
                {
                  value: 300,
                  name: "俄罗斯",
                },
                {
                  value: 300,
                  name: "南非",
                },
                {
                  value: 300,
                  name: "南非",
                },
                {
                  value: 300,
                  name: "韩国",
                },
                {
                  value: 300,
                  name: "越南",
                },
                {
                  value: 300,
                  name: "西班牙",
                },
                {
                  value: 300,
                  name: "荷兰",
                },
                {
                  value: 300,
                  name: "瑞典",
                },
                {
                  value: 300,
                  name: "智利",
                },
                {
                  value: 300,
                  name: "捷克共和国",
                },
              ],
              emphasis: {
                shadowColor: "rgba(0, 0, 0, 0)", // 阴影颜色
                shadowBlur: 30, // 阴影模糊度
                itemStyle: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: "rgba(0, 0, 0, 0.5)",
                },
              },
            },
          ],
        };
        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas6
      $(function () {
        var dom = document.getElementById("sheet_canvas6");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          tooltip: {
            trigger: "axis",
            axisPointer: {
              type: "shadow",
            },
          },

          xAxis: [
            {
              type: "category",
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: [
            {
              type: "value",
              name: "产品收录率(%)",
              nameGap: 30,
              splitLine: {
                show: true,
                lineStyle: {
                  color: "#ECEEF6",
                },
              },
              nameTextStyle: {
                color: "#444", // 设置Y轴标题颜色
                fontSize: 13, // 更改Y轴轴标题文字大小
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          series: [
            {
              name: "产品收录率(%)",
              type: "bar",
              data: [20, 32, 18, 25, 30, 20, 36, 80, 99, 86, 56, 75],
              barGap: "40%",
              barCategoryGap: "40%",
             barMaxWidth: 20,// 设置柱状图最大宽度
              itemStyle: {
                barBorderRadius: [2, 2, 2, 2],
                color: new echarts.graphic.LinearGradient(
                  0,
                  0,
                  0,
                  1, // 渐变方向
                  [
                    { offset: 0, color: "#656EE5" }, // 渐变起始颜色
                    { offset: 1, color: "#757EF3" }, // 渐变结束颜色
                  ]
                ),
                label: {
                  show: true, //开启显示
                  position: "top", //在上方显示
                  textStyle: {
                    //数值样式
                    color: "#333",
                  },
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas7
      $(function () {
        var dom = document.getElementById("sheet_canvas7");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
            // formatter: '{b0}<br/><i class="ele-chart-dot" style="width:10px;height:10px;background: #ccc;"></i>网站运营指数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {c0}',
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "运营指数",
              type: "line",
              data: [82, 92, 85, 88, 87, 86, 90, 88, 85, 83, 86, 92],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //内容数量
      var myChart = null; // 定义全局变量来接收echarts实例
      var options = [
        //折线图
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "有效产品",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [
                311, 317, 317, 317, 317, 317, 317, 317, 317, 317, 317, 317,
              ],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品分类",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [26, 26, 27, 26, 26, 27, 26, 27, 26, 27, 26, 27],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品关键词",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [
                948, 948, 948, 948, 948, 948, 948, 948, 948, 948, 948, 948,
              ],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "视频",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [
                576, 576, 576, 576, 576, 576, 576, 576, 576, 576, 576, 576,
              ],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "新闻资讯",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [12, 12, 13, 12, 13, 12, 13, 12, 13, 12, 13, 13],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品综合得分",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [88, 88, 88, 88, 88, 88, 88, 88, 88, 88, 88, 88],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品分类综合得分",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [88, 36, 36, 36, 36, 36, 36, 36, 36, 36, 36, 36],
            },
          ],
        },
        {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品关键词比例",
              type: "line",
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },

              data: [3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3],
            },
          ],
        },
      ];

      var myCharts = [];
      function render(dom, optionIndex) {
        //  销毁渲染
        if (myCharts[optionIndex] != null) {
          myCharts[optionIndex].dispose();
        }

        //  初始化渲染
        myCharts[optionIndex] = echarts.init(document.getElementById(dom));

        //  执行渲染
        var option = options[optionIndex];
        if (option == null || option == undefined) {
          return false;
        }
        myCharts[optionIndex].setOption(option);
        myCharts[optionIndex].on("click", function (params) {
          window.open(params.data.url);
        });

        //  响应屏幕
        $(window).on("resize", function () {
          myCharts[optionIndex].resize();
        });
      }

      //初始化图表
      $(".tab_uldiv").each(function (i, n) {
        var FirstElement = $(n).find("li").eq(0);
        var ElementID = FirstElement.attr("render-dom");
        console.log(ElementID);
        var ElementIndex = FirstElement.attr("render-option");
        render(ElementID, ElementIndex);
      });

      //tab栏切换
      $(".tab_uldiv li").on("click", function () {
        //  销毁所有实例
        var renderDomName = $(this).attr("render-dom");
        var renderDomType = $(this).attr("render-option");
        //  显示
        var index = $(this).index();
        $(this)
          .parent()
          .next()
          .find(".item")
          .each(function (i, n) {
            if (index == i) {
              $(n).addClass("active");
            } else {
              $(n).removeClass("active");
            }
          });
        $(this)
          .parent()
          .find("li")
          .each(function (i, n) {
            if (index == i) {
              $(n).addClass("active");
            } else {
              $(n).removeClass("active");
            }
          });
        // $(this).addClass("active").siblings("li").removeClass("active");
        // $(".plot_content .item:eq(" + index + ")")
        //     .addClass("active")
        //     .siblings(".item")
        //     .removeClass("active");
        //  渲染
        render(renderDomName, renderDomType);
      });


      //sheet_canvas8
      $(function () {
        var dom = document.getElementById("sheet_canvas8");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品内容质量",
              type: "line",
              data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas9
      $(function () {
        var dom = document.getElementById("sheet_canvas9");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品名称待修改数量",
              type: "line",
              data: [2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas10
      $(function () {
        var dom = document.getElementById("sheet_canvas10");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品关键词待修改数量",
              type: "line",
              data: [2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas11
      $(function () {
        var dom = document.getElementById("sheet_canvas11");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品内链待修改数量",
              type: "line",
              data: [2, 2, 2, 2, 2, 2, 12, 13, 13, 13, 13, 13],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

      //sheet_canvas12
      $(function () {
        var dom = document.getElementById("sheet_canvas12");
        var myChart = echarts.init(dom, null, {
          renderer: "canvas",
          useDirtyRect: false,
        });
        var app = {};
        var option;
        option = {
          tooltip: {
            trigger: "axis",
          },
          grid: {
            // 控制四周有空白
            x: 50,
            y: 50,
            x2: 5,
            y2: 70,
          },
          animation: true,
          xAxis: [
            {
              type: "category",
              axisTick: { show: false },
              data: [
                "2022.03",
                "2022.04",
                "2022.05",
                "2022.06",
                "2022.07",
                "2022.08",
                "2022.09",
                "2022.10",
                "2022.11",
                "2022.12",
                "2023.01",
                "2023.02",
              ],
              axisTick: {
                show: true, // 显示刻度线
              },
              axisLine: {
                lineStyle: {
                  color: "#898989", // 更改刻度线颜色
                },
              },
              axisLabel: {
                color: "#4A4D55", // 更改刻度文字颜色
              },
            },
          ],
          yAxis: {
            type: "value",
            axisLabel: {
              formatter: function (value, index) {
                return Math.floor(value); // 只显示整数部分
              },
            },
            nameGap: 30,
            splitLine: {
              show: true,
              lineStyle: {
                color: "#ECEEF6",
              },
            },
            nameTextStyle: {
              color: "#444", // 设置Y轴标题颜色
              fontSize: 13, // 更改Y轴轴标题文字大小
            },
            axisLabel: {
              color: "#4A4D55", // 更改刻度文字颜色
            },
          },
          series: [
            {
              name: "产品图片重复超过3次的图片数量",
              type: "line",
              data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
              label: {
                show: true, // 显示标签
                position: "insideBottom", // 标签位置：顶部
                color: "#333", // 标签文字颜色
                distance: 15, // 设置标签与Y轴的距离
              },
              emphasis: {
                lineStyle: {
                  width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                },
              },
              itemStyle: {
                normal: {
                  color: "#656EE5",
                },
              },
            },
          ],
        };

        if (option && typeof option === "object") {
          myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
      });

        @if(in_array('OperationalScore',app('myAddons')))
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
        @endif

        //内容信息导航吸顶
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
        })
        //内容信息导航锚点
        $('#nav-wrap').navScroll({
            mobileDropdown: true,
            mobileBreakpoint: 768,
            scrollSpy: true
        });

        //tab_uldiv


        </script>
        <script src="{{ mix('/js/admin/admin.dataManager.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
