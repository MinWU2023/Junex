<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $data->title }}</title>
    <meta name="keywords" content="{{ $data->keywords }}">
    <meta name="description" content="{{ $data->description }}">

    <link type="text/css" rel="stylesheet" href="/pages/{{ $data->area_name }}/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/pages/{{ $data->area_name }}/css/animate.css"/>
    <link type="text/css" rel="stylesheet" href="/pages/{{ $data->area_name }}/css/style.css">

    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/swiper.min.js"></script>
    <script type="text/javascript">
        $(document).on("scroll", function () {
            if ($(document).scrollTop() > 20) {
                $("header").removeClass("large").addClass("small");
            } else {
                $("header").removeClass("small").addClass("large");
            }
        });
    </script>

    <!--[if ie9]
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    -->

    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<header class="large">

    <div class="nav_section clearfix">
        <div class="container">
            <h1><a href="/" id="logo"><img src="{{ asset($data->plate_content_1['imgs'][0]) }}"></a></h1>

            <div class="header-navigation">
                <nav class="main-navigation">
                    <div class="main-navigation-inner">
                        <ul id="menu-main-menu" class="main-menu clearfix">
                            <li class="active"><a
                                    href="{{ $data->plate_content_1['urls'][0] }}">{{ $data->plate_content_1['names'][0] }}</a>
                            </li>
                            <li class="menu-children"><a
                                    href="{{ $data->plate_content_1['urls'][1] }}">{{ $data->plate_content_1['names'][1] }}</a>
                                <ul class="sub-menu">
                                    <li class="menu-children"><a href="{{ $data->plate_content_1['urls'][2] }}"
                                                                 title="#">{{ $data->plate_content_1['names'][2] }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ $data->plate_content_1['urls'][3] }}"
                                                   title="#">{{ $data->plate_content_1['names'][3] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][4] }}"
                                                   title="#">{{ $data->plate_content_1['names'][4] }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-children"><a href="{{ $data->plate_content_1['urls'][5] }}"
                                                                 title="#">{{ $data->plate_content_1['names'][5] }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ $data->plate_content_1['urls'][6] }}"
                                                   title="#">{{ $data->plate_content_1['names'][6] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][7] }}"
                                                   title="#">{{ $data->plate_content_1['names'][7] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][8] }}"
                                                   title="#">{{ $data->plate_content_1['names'][8] }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-children"><a href="{{ $data->plate_content_1['urls'][9] }}"
                                                                 title="#">{{ $data->plate_content_1['names'][9] }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ $data->plate_content_1['urls'][10] }}"
                                                   title="#">{{ $data->plate_content_1['names'][10] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][11] }}"
                                                   title="#">{{ $data->plate_content_1['names'][11] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][12] }}"
                                                   title="#">{{ $data->plate_content_1['names'][12] }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-children"><a href="{{ $data->plate_content_1['urls'][13] }}"
                                                                 title="#">{{ $data->plate_content_1['names'][13] }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ $data->plate_content_1['urls'][14] }}"
                                                   title="#">{{ $data->plate_content_1['names'][14] }}</a></li>

                                        </ul>
                                    </li>
                                    <li class="menu-children"><a href="{{ $data->plate_content_1['urls'][15] }}"
                                                                 title="#">{{ $data->plate_content_1['names'][15] }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ $data->plate_content_1['urls'][16] }}"
                                                   title="#">{{ $data->plate_content_1['names'][16] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][17] }}"
                                                   title="#">{{ $data->plate_content_1['names'][17] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][18] }}"
                                                   title="#">{{ $data->plate_content_1['names'][18] }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-children"><a href="{{ $data->plate_content_1['urls'][19] }}"
                                                                 title="#">{{ $data->plate_content_1['names'][19] }}</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ $data->plate_content_1['urls'][20] }}"
                                                   title="#">{{ $data->plate_content_1['names'][20] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][21] }}"
                                                   title="#">{{ $data->plate_content_1['names'][21] }}</a></li>
                                            <li><a href="{{ $data->plate_content_1['urls'][22] }}"
                                                   title="#">{{ $data->plate_content_1['names'][22] }}</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ $data->plate_content_1['urls'][23] }}">{{ $data->plate_content_1['names'][23] }}</a>
                            </li>
                            <li>
                                <a href="{{ $data->plate_content_1['urls'][24] }}">{{ $data->plate_content_1['names'][24] }}</a>
                            </li>

                            <li>
                                <a href="{{ $data->plate_content_1['urls'][25] }}">{{ $data->plate_content_1['names'][25] }}</a>
                            </li>
                        </ul>

                    </div>
                </nav>
                <div class="nav_overly"></div>
            </div>
            <div id="menu-mobile"><span class="btn-nav-mobile open-menu"><i></i><span></span></span></div>
        </div>
    </div>
</header>


@php($banners =$data->plate_content_2['images']['首页轮播图'] )
<div class="height"></div>
<div class="swiper-banner index_banner">
    <div class="swiper-wrapper">
        @foreach($banners as $k=>$banner)
            <div class="swiper-slide">
                <div class="slide-inner"><a href="{{ $data->plate_content_2['urls'][$k] }}" rel="nofollow"><img
                            src="{{ asset($banner['path']) }}" alt="{{ $banner['alt'] }}"></a></div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<div class="app_section">
    <div class="container">
        <div class="i_title">
            <div class="h4">{{ $data->plate_content_3['names'][0] }}</div>
            <p>{{ $data->plate_content_3['names'][1] }}</p>
        </div>
        @php($products=array_values($data->plate_content_3['images']))
        @foreach($products as $k=>$product_images)
            <div class="swi_position">
                <div class="swiper-container swi_overflow pro_scrollbar">
                    <ul class="swiper-wrapper">
                        @foreach($product_images as $product_image)
                            <li class="swiper-slide">
                                <a href="#"><img src="{{ asset($product_image['path']) }}" alt=""/></a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="index_cete_con clearfix">
                    <p>{{ $data->plate_content_3['names'][$k+2] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="search_btn container">
    <a class="search-info" id="pro_inq_c"
       href="javascript:void(0)">{{ $data->plate_content_4['names'][0] }}</a>
</div>

<div class="fixed-search">
    <div class="theme-popover">
        <div class="theme-popbod">
            <div class="theme-poptit">
                <a href="{{ $data->plate_content_4['urls'][0] }}" class="close">×</a>
            </div>
            <div class="top-search clearfix">
                <p>{{ $data->plate_content_4['names'][1] }}</p>
                <div class="header_search clearfix">
                    <input name="search_keyword" type="text" class="form-control" placeholder="Email(required)">
                    <span class="search_btn"><input type="submit" class="btn_search5" value="Download Now!"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="theme-popover-mask"></div>
</div>


<!--case_section-->

<!--about_section-->


<!--footer-->


<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewbox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
    </svg>
</div>
<div id="online_qq_layer">
    <div id="online_qq_tab">
        <a id="floatShow" rel="nofollow" href="javascript:void(0);">{{ $data->plate_content_5['names'][0] }}</a>
        <a id="floatHide" rel="nofollow" href="javascript:void(0);"><i></i></a>
    </div>
    <div id="onlineService">
        <div class="online_form">
            <div class="i_message_inquiry">
                <em class="title">{{ $data->plate_content_5['names'][1] }}</em>
                <div class="text">{{ $data->plate_content_5['names'][2] }}</div>
                <div class="inquiry">
                    <x-inquiry>
                        @section('content')
                            <input type="hidden" name="msg_title" value="无title填写">
                            <div class="input-group">
                            <span class="ms_e"><input class="form-control" name="msg_email" id="email" tabindex="10" required="required"
                                                      type="text" placeholder="* Your Email :"></span>
                            </div>
                            <div class="input-group">
                            <span class="ms_p"><input class="form-control" name="msg_phone" id="phone"
                                                      tabindex="10" type="text" placeholder="Tel/WhatsApp :"></span>
                            </div>
                            <div class="input-group">
                            <span class="ms_m"><textarea name="msg_content" class="form-control" id="message" required="required"
                                                         tabindex="13"
                                                         placeholder="* Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote."></textarea></span>
                            </div>
                        @overwrite
                        <x-slot name="formId">
                            email_form
                        </x-slot>

                        <x-slot name="spanClass">
                            main_more
                        </x-slot>

                        <x-slot name="inputValue">
                            Submit
                        </x-slot>
                        <x-slot name="inputClass">

                        </x-slot>
                    </x-inquiry>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="masterpage clearfix">
    <div class="container">
        <div class="masterpage_left clearfix">
            <div class="masterpage_left_title">{{ $data->plate_content_6['names'][0] }}</div>
            <div class="masterpage_left_content">
                @for($i=0;$i<5;$i++)
                    <div class="masterpage_left_content01">
                        <img src="{{ $data->plate_content_6['imgs'][$i] }}"/>
                        {{ $data->plate_content_6['names'][$i+1] }}
                    </div>
                @endfor
            </div>

        </div>
        <div class="masterpage_right clearfix">
            <div class="pro_inq" id="pro_inq_c">
                <div class="title">{{ $data->plate_content_6['names'][6] }}</div>
                <div class="inquiry">
                    <x-inquiry>
                        @section('content')
                            <input type="hidden" name="msg_title" value="无title填写">
                            <ul class="row clearfix">
                                <li class=" col-sm-12 col-xs-12">
                                <span class="ms_e"><input class="form-control" name="msg_email" required="required"
                                                          tabindex="10" type="text" placeholder="* Your Email"></span>
                                </li>
                                <li class=" col-sm-12 col-xs-12">
                                <span class="ms_p"><input class="form-control" name="msg_phone" tabindex="10"
                                                          type="text" placeholder="Tel/WhatsApp"></span>
                                </li>
                                <li class="meText col-xs-12">
                                <span class="ms_m"><textarea name="msg_content" class="form-control" required="required"
                                                             tabindex="13"
                                                             placeholder="* Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote."></textarea></span>
                                </li>

                            </ul>
                        @overwrite
                        <x-slot name="formId">
                            email_form_common
                        </x-slot>
                        <x-slot name="spanClass">
                            ms_btn
                        </x-slot>
                        <x-slot name="inputValue">
                            Submit
                        </x-slot>
                        <x-slot name="inputClass">
                            google_genzong
                        </x-slot>
                    </x-inquiry>
                    {{--                    <form id="email_form" name="email_form" method="post" action="/inquiryStore">--}}
                    {{--                        @include('shared._message')--}}
                    {{--                        @csrf--}}
                    {{--                        <x-honeypot/>--}}
                    {{--                        <input type="hidden" name="msg_title" value="无title填写">--}}
                    {{--                        <ul class="row clearfix">--}}
                    {{--                            <li class=" col-sm-12 col-xs-12">--}}
                    {{--                                <span class="ms_e"><input class="form-control" name="msg_email" id="msg_email"--}}
                    {{--                                                          tabindex="10" type="text" placeholder="* Your Email"></span>--}}
                    {{--                            </li>--}}
                    {{--                            <li class=" col-sm-12 col-xs-12">--}}
                    {{--                                <span class="ms_p"><input class="form-control" name="msg_phone" id="phone" tabindex="10"--}}
                    {{--                                                          type="text" placeholder="Tel/WhatsApp"></span>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="meText col-xs-12">--}}
                    {{--                                <span class="ms_m"><textarea name="msg_content" class="form-control" id="message"--}}
                    {{--                                                             tabindex="13"--}}
                    {{--                                                             placeholder="* Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote."></textarea></span>--}}
                    {{--                            </li>--}}

                    {{--                        </ul>--}}
                    {{--                        <span class="ms_btn"><input type="submit" id="btnOk" value="Submit"--}}
                    {{--                                                    class="google_genzong"></span>--}}
                    {{--                    </form>--}}

                </div>
            </div>

        </div>
    </div>
</div>

<div class="medical_applications clearfix">
    <div class="container">

        <div class="i_title">
            <div class="h4">{{ $data->plate_content_7['names'][0] }}</div>

        </div>
        <div class="row">
            <ul>
                @for($i=0;$i<4;$i++)
                    <li>
                        <img src="{{ asset($data->plate_content_7['imgs'][$i]) }}"/>
                        <p>{{ $data->plate_content_7['names'][$i+1] }}</p>
                    </li>
                @endfor
            </ul>
        </div>
    </div>

</div>

<div class="lfc_caster clearfix">
    <div class="container">
        <div class="i_title">
            <div class="h4">{{ $data->plate_content_8['names'][0] }}</div>
            <div class="lfc_caster_left">
                <img src="{{ $data->plate_content_8['imgs'][0] }}" alt=""/>
            </div>
            <div class="lfc_caster_right">
                {!! $data->plate_content_8['contents'][0] !!}
            </div>

        </div>

    </div>

</div>

<div class="index_choose_us clearfix">
    <div class="index_choose_us_2">

        <div class="container">
            <div class="i_title">
                <div class="h4" style="color:#fff">{{ $data->plate_content_9['names'][0] }}</div>
            </div>
            <div class="index_choose_us_2_con">
                {{ $data->plate_content_9['names'][1] }}
            </div>
            <ul class="clearfix">
                <li>
                    <span>{{ $data->plate_content_9['names'][2] }}</span>
                    <span class="line"></span>
                    <span><em>{{ $data->plate_content_9['names'][3] }}</em></span>
                </li>
                <li>
                    <span>{{ $data->plate_content_9['names'][4] }}</span>
                    <span class="line"></span>
                    <span><em>{{ $data->plate_content_9['names'][5] }}</em></span>
                </li>
                <li>
                    <span>{{ $data->plate_content_9['names'][6] }}<strong style="line-height:30px">{{ $data->plate_content_9['names'][7] }}<sup>{{ $data->plate_content_9['names'][8] }}</sup></strong></span>
                    <span class="line"></span>
                    <span><em>{{ $data->plate_content_9['names'][9] }}</em></span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="index_oem clearfix">
    <div class="container">
        <div class="row">
            <ul>
                @for($i=0;$i<6;$i++)
                    <li>
                        <img src="{{ asset($data->plate_content_10['imgs'][$i]) }}"/>
                        <p><span>{{ $data->plate_content_10['names'][$i] }}</span></p>
                        {!! $data->plate_content_10['contents'][$i] !!}
                    </li>
                @endfor
            </ul>
        </div>
    </div>
</div>

<div class="certifiction clearfix">
    <div class="container">
        {!! $data->plate_content_10['contents'][6] !!}
    </div>

</div>

<!--service-->
<div class="fixed-contact">

    <ul class="item-list clearfix">
        <li class="online_p">
            <div class="column">
                <i class="icon"></i>
                <a rel="nofollow" target="_blank" href="#">{{ $data->plate_content_10['names'][6] }}</a>
            </div>
        </li>
        <li class="online_e">
            <div class="column">
                <i class="icon"></i>
                <a rel="nofollow" target="_blank" href="#">{{ $data->plate_content_10['names'][7] }}</a>
            </div>
        </li>
        <li class="online_w">
            <div class="column">
                <i class="icon"></i>
                <a rel="nofollow" target="_blank" href="#">{{ $data->plate_content_10['names'][8] }}</a>
            </div>
        </li>
        <li class="online_s">
            <div class="column">
                <i class="icon"></i>
                <a rel="nofollow" target="_blank" href="#">{{ $data->plate_content_10['names'][9] }}</a>
            </div>
        </li>
        <li class="online_code">
            <div class="column">
                <i class="icon"></i>
                <a>
                    <p>Scan to wechat :</p><img src="pages/02/images/right-wx.png" alt=""/>
                </a>
            </div>
        </li>
    </ul>
</div>

<div class="mobile_nav clearfix">
    <a href="index.html"><i style="background-position: -323px -160px"></i>
        <p>home</p></a>
    <a href="products.html"><i style="background-position: -366px -160px"></i>
        <p>products</p></a>
    <a href="about.html"><i style="background-position: -242px -160px"></i>
        <p>whatsApp</p></a>
    <a href="contact.html"><i style="background-position: -283px -160px"></i>
        <p>skype</p></a>
</div>

<script type="text/javascript" src="/pages/{{ $data->area_name }}/js/main.js"></script>
<script type="text/javascript" src="/pages/{{ $data->area_name }}/js/demo.js"></script>

</body>
</html>
