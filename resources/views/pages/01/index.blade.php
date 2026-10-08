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

    <link type="text/css" rel="stylesheet" href="/pages/{{ $data->area_name }}/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="/pages/{{ $data->area_name }}/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="/pages/{{ $data->area_name }}/css/style.css"/>
    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/demo.js"></script>
    <script type="text/javascript" src="/pages/{{ $data->area_name }}/js/jquery.velocity.min.js"></script>

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


<div class="header clearfix">
    <div class="container">
        <div class="header_box">
            <em>{{ $data->plate_content_1['names'][0] }}</em>
        </div>
    </div>
</div>


<div class="head-slide clearfix">

    <a href="javascript:void(0);" target="_blank" rel="nofollow"><img alt="Business online"
                                                                      src="{{ asset($data->plate_content_1['imgs'][0]) }}"></a>
    <!--   <p class="banner_font">AGGRESSIVELY PROTECTING  YOUR RICHTS</p>-->
    <div class="messageBox">
        <div class="container">
            <div class="messageBox_m">
                <div class="message">
                    <em>{{ $data->plate_content_1['names'][1] }}</em>
                    <p>{{ $data->plate_content_1['names'][2] }}</p>
                    @include('shared._message')
                    <x-inquiry>
                        @section('content')
                            <ul>
                            <li>
                                <input type="text" name="msg_email" required="required" class="meInput"
                                       placeholder="Email">
                            </li>
                            <li>
                                <input type="text" name="msg_title" required="required" class="meInput"
                                       placeholder="Subject">
                            </li>
                            <li>
                                <textarea id="meText" placeholder="Content" required="required" name="msg_content"
                                          style="color:#808080;" class="meText"></textarea>
                            </li>
                            <div class="clearfix"></div>
                            </ul>
                        @overwrite
                        <x-slot name="formId">
                            email_form_common
                        </x-slot>

                        <x-slot name="spanClass">
                            send
                        </x-slot>
                        <x-slot name="inputValue">
                            FREE SAMPLE!
                        </x-slot>
                        <x-slot name="inputClass">

                        </x-slot>
                    </x-inquiry>
                    <p>{{ $data->plate_content_1['names'][3] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="landing-page01">
    <div class="container">
        <div class="in_title">
            <h4>{{ $data->plate_content_2['names'][0] }}</h4>
            <div class="text">{{ $data->plate_content_2['names'][1] }}</div>
        </div>
        <ul class="list clearfix">
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <a href="{{ $data->plate_content_2['urls'][0] }}" class="images"><img
                            src="{{ asset($data->plate_content_2['imgs'][0]) }}" alt="#"></a>
                    <div class="wrap">
                        <a href="{{ $data->plate_content_2['urls'][0] }}"
                           class="title">{{ $data->plate_content_2['names'][2] }}</a>
                        <div class="line"></div>
                        <div class="text">
                            {{ $data->plate_content_2['names'][3] }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <a href="{{ $data->plate_content_2['urls'][1] }}" class="images"><img
                            src="{{ asset($data->plate_content_2['imgs'][1]) }}" alt="#"></a>
                    <div class="wrap">
                        <a href="{{ $data->plate_content_2['urls'][1] }}"
                           class="title">{{ $data->plate_content_2['names'][4] }}</a>
                        <div class="line"></div>
                        <div class="text">
                            {{ $data->plate_content_2['names'][5] }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <a href="{{ $data->plate_content_2['urls'][2] }}" class="images"><img
                            src="{{ asset($data->plate_content_2['imgs'][2]) }}" alt="#"></a>
                    <div class="wrap">
                        <a href="{{ $data->plate_content_2['urls'][2] }}"
                           class="title">{{ $data->plate_content_2['names'][6] }}</a>
                        <div class="line"></div>
                        <div class="text">
                            {{ $data->plate_content_2['names'][7] }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <a href="{{ $data->plate_content_2['urls'][3] }}" class="images"><img
                            src="{{ asset($data->plate_content_2['imgs'][3]) }}" alt="#"></a>
                    <div class="wrap">
                        <a href="{{ $data->plate_content_2['urls'][3] }}"
                           class="title">{{ $data->plate_content_2['names'][8] }}</a>
                        <div class="line"></div>
                        <div class="text">
                            {{ $data->plate_content_2['names'][9] }}
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="landing-page02">
    <div class="container">
        <div class="in_title">
            <h4>{{ $data->plate_content_3['names'][0] }}</h4>
            <div class="text"> {{ $data->plate_content_3['names'][1] }}</div>
        </div>
        <div class="slider autoplay5">
            @for($i=0;$i<6;$i++)
                <div>
                    <div class="li">
                        <div class="column" style="background-image: url({{ $data->plate_content_3['imgs'][$i] }})">
                            <div class="wrap">
                                <p class="title">{{ $data->plate_content_3['names'][$i+2] }}</p>
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
</div>

<div class="landing-page03">
    <div class="container">
        <div class="in_title">
            <h4>{{ $data->plate_content_4['names'][0] }}</h4>
            <div class="text">{{ $data->plate_content_4['names'][1] }}</div>
        </div>
        <ul class="list clearfix">
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="image"><img src="{{ asset($data->plate_content_4['imgs'][0]) }}" alt="#"></div>
                    <div class="wrap">
                        <p class="title">{{ $data->plate_content_4['names'][2] }}</p>
                        <div class="text">
                            {{ $data->plate_content_4['names'][3] }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="image"><img src="{{ asset($data->plate_content_4['imgs'][1]) }}" alt="#"></div>
                    <div class="wrap">
                        <p class="title">{{ $data->plate_content_4['names'][4] }}</p>
                        <div class="text">
                            {{ $data->plate_content_4['names'][5] }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="image"><img src="{{ asset($data->plate_content_4['imgs'][2]) }}" alt="#"></div>
                    <div class="wrap">
                        <p class="title">{{ $data->plate_content_4['names'][6] }}</p>
                        <div class="text">
                            {{ $data->plate_content_4['names'][7] }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="image"><img src="{{ asset($data->plate_content_4['imgs'][3]) }}" alt="#"></div>
                    <div class="wrap">
                        <p class="title">{{ $data->plate_content_4['names'][8] }}</p>
                        <div class="text">
                            {{ $data->plate_content_4['names'][9] }}
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="quote_content">
    <div class="container clearfix">
        <div class="text">
            <div class="title">{{ $data->plate_content_5['names'][0] }}</div>
            <div class="text_box">{{ $data->plate_content_5['names'][1] }} </div>
        </div>
        <div class="select">
            <a href="javascript:void(0)" class="select-trigger" data-modal="modal-lan">
                <p>{{ $data->plate_content_5['names'][2] }}<i></i></p>
            </a>
        </div>
    </div>
</div>
<div class="select-modal" id="modal-lan">
    <div class="select-content">
        <div class="select_title">
            <em>{{ $data->plate_content_5['names'][3] }}</em>
            <div class="text">{{ $data->plate_content_5['names'][4] }}</div>
        </div>
        <div class="main">
            <div class="send_column">
                <x-inquiry>
                    @section('content')
                        <ul>
                            <li class=" col-sm-6 col-xs-12">
                            <span class="ms_e"><input type="text" name="msg_email"  class="meInput"
                                                      placeholder="Your Email"></span>
                            </li>
                            <li class=" col-sm-6 col-xs-12">
                            <span class="ms_p"><input type="text" name="msg_phone"  class="meInput"
                                                      placeholder="Subject"></span>
                            </li>
                            <li class=" meText col-xs-12">
                            <span class="ms_m"><textarea placeholder="Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote."
                                                         maxlength="3000" name="msg_content"></textarea></span>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
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
        <button class="select-close"><i></i></button>
    </div>
</div>
<div class="select-overlay"></div>


<div class="landing-page04">
    <div class="container">
        <div class="in_title">
            <h4>{{ $data->plate_content_6['names'][0] }}</h4>
            <div class="text">{{ $data->plate_content_6['names'][1] }}</div>
        </div>
        <ul class="list clearfix">
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][2] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][3] }}
                        </div>
                    </div>
                    <div class="number_icon">01.</div>
                </div>
            </li>

            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][4] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][5] }}
                        </div>
                    </div>
                    <div class="number_icon">02.</div>
                </div>
            </li>
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][6] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][7] }}
                        </div>
                    </div>
                    <div class="number_icon">03.</div>
                </div>
            </li>
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][8] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][9] }}
                        </div>
                    </div>
                    <div class="number_icon">04.</div>
                </div>
            </li>
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][10] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][11] }}
                        </div>
                    </div>
                    <div class="number_icon">05.</div>
                </div>
            </li>
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][12] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][13] }}
                        </div>
                    </div>
                    <div class="number_icon">06.</div>
                </div>
            </li>
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][14] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][15] }}
                        </div>
                    </div>
                    <div class="number_icon">07.</div>
                </div>
            </li>
            <li class=" col-sm-3 col-xs-6">
                <div class="column">
                    <div class="wrap">
                        <div class="title">{{ $data->plate_content_6['names'][16] }}</div>
                        <div class="text">
                            {{ $data->plate_content_6['names'][17] }}
                        </div>
                    </div>
                    <div class="number_icon">08.</div>
                </div>
            </li>
        </ul>
    </div>
</div>


<div class="landing-page05">
    <div class="container">
        <div class="in_title">
            <h4>{{ $data->plate_content_7['names'][0] }}</h4>
            <div class="text">{{ $data->plate_content_7['names'][1] }}</div>
        </div>
        <ul class="list clearfix">
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="title">{{ $data->plate_content_7['names'][2] }}</div>
                    <div class="text">
                        {{ $data->plate_content_7['names'][3] }}
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="title">{{ $data->plate_content_7['names'][4] }}</div>
                    <div class="text">
                        {{ $data->plate_content_7['names'][5] }}
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="title">{{ $data->plate_content_7['names'][6] }}</div>
                    <div class="text">
                        {{ $data->plate_content_7['names'][7] }}
                    </div>
                </div>
            </li>
            <li class="col-sm-3 col-xs-6">
                <div class="column">
                    <div class="title">{{ $data->plate_content_7['names'][8] }}</div>
                    <div class="text">
                        {{ $data->plate_content_7['names'][9] }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="landing-page06">
    <div class="container">
        <div class="in_title">
            <h4>{{ $data->plate_content_8['names'][0] }}</h4>
            <div class="text">
                {{ $data->plate_content_8['names'][1] }}
            </div>
        </div>
        <div class="faq_column clearfix">
            <ul class="page_faq_l col-sm-6">
                <li class="question ">
                    <div class="column"><i></i><em class="title"> {{ $data->plate_content_8['names'][2] }}</em></div>
                </li>
                <li class="answer">
                    <div class="text">
                        {{ $data->plate_content_8['names'][3] }}
                    </div>
                </li>
                <div class="clearfix"></div>
                <li class="question">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][4] }}</em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][5] }}</div>
                </li>
                <div class="clearfix"></div>
                <li class="question">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][6] }} </em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][7] }}</div>
                </li>
                <div class="clearfix"></div>
                <li class="question">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][8] }} </em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][9] }}</div>
                </li>
                <div class="clearfix"></div>

            </ul>
            <ul class="page_faq_l col-sm-6">
                <li class="question ">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][10] }}</em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][11] }}</div>
                </li>
                <div class="clearfix"></div>
                <li class="question">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][12] }}</em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][13] }}</div>
                </li>
                <div class="clearfix"></div>
                <li class="question">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][14] }}</em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][15] }}</div>
                </li>
                <div class="clearfix"></div>
                <li class="question">
                    <div class="column"><i></i><em class="title">{{ $data->plate_content_8['names'][16] }}</em></div>
                </li>
                <li class="answer">
                    <div class="text">{{ $data->plate_content_8['names'][17] }}</div>
                </li>
                <div class="clearfix"></div>

            </ul>
        </div>
    </div>
</div>

<div class="landing-page07 clearfix">
    <div class="container">
        <div class="online_box">
            <h4>{{ $data->plate_content_9['names'][0] }}</h4>
            <p>{{ $data->plate_content_9['names'][1] }}</p>
            <!--<a href="#" class="lpage06-more">get started</a>-->
        </div>
    </div>
</div>
<div class="copy clearfix">
    <div class="container">
        <div class="row">
            {!! $data->plate_content_9['contents'][0] !!}
        </div>
    </div>
</div>

<a href="javascript:;" class="back_top"></a>

<script type="text/javascript">
    $('#bootstrap-touch-slider').bsTouchSlider();
</script>
<script type="text/javascript" src="/pages/{{ $data->area_name }}/js/slick.js"></script>
<script type="text/javascript" src="/pages/{{ $data->area_name }}/js/wow.min.js"></script>
<script type="text/javascript" src="/pages/{{ $data->area_name }}/js/owl.carousel.min.js"></script>

<script>
    /*select*/
    (function (window) {

        'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

        function classReg(className) {
            return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
        }

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
        var hasClass, addClass, removeClass;

        if ('classList' in document.documentElement) {
            hasClass = function (elem, c) {
                return elem.classList.contains(c);
            };
            addClass = function (elem, c) {
                elem.classList.add(c);
            };
            removeClass = function (elem, c) {
                elem.classList.remove(c);
            };
        } else {
            hasClass = function (elem, c) {
                return classReg(c).test(elem.className);
            };
            addClass = function (elem, c) {
                if (!hasClass(elem, c)) {
                    elem.className = elem.className + ' ' + c;
                }
            };
            removeClass = function (elem, c) {
                elem.className = elem.className.replace(classReg(c), ' ');
            };
        }

        function toggleClass(elem, c) {
            var fn = hasClass(elem, c) ? removeClass : addClass;
            fn(elem, c);
        }

        var classie = {
            // full names
            hasClass: hasClass,
            addClass: addClass,
            removeClass: removeClass,
            toggleClass: toggleClass,
            // short names
            has: hasClass,
            add: addClass,
            remove: removeClass,
            toggle: toggleClass
        };

// transport
        if (typeof define === 'function' && define.amd) {
            // AMD
            define(classie);
        } else {
            // browser global
            window.classie = classie;
        }

    })(window);

    var ModalEffects = (function () {

        function init() {

            var overlay = document.querySelector('.select-overlay');

            [].slice.call(document.querySelectorAll('.select-trigger')).forEach(function (el, i) {

                var modal = document.querySelector('#' + el.getAttribute('data-modal')),
                    close = modal.querySelector('.select-close');

                function removeModal(hasPerspective) {
                    classie.remove(modal, 'select-show');

                    if (hasPerspective) {
                        classie.remove(document.documentElement, 'select-perspective');
                    }
                }

                function removeModalHandler() {
                    removeModal(classie.has(el, 'select-setperspective'));
                }

                el.addEventListener('click', function (ev) {
                    classie.add(modal, 'select-show');
                    overlay.removeEventListener('click', removeModalHandler);
                    overlay.addEventListener('click', removeModalHandler);

                    if (classie.has(el, 'select-setperspective')) {
                        setTimeout(function () {
                            classie.add(document.documentElement, 'select-perspective');
                        }, 25);
                    }
                });

                close.addEventListener('click', function (ev) {
                    ev.stopPropagation();
                    removeModalHandler();
                });

            });

        }

        init();
    })();


</script>
<script>
    (function ($) {
        var $nav = $('#main-nav');
        var $toggle = $('.toggle');
        var defaultData = {
            maxWidth: false,
            customToggle: $toggle,
            levelTitles: true
        };

        // we'll store our temp stuff here
        var $clone = null;
        var data = {};

        // calling like this only for demo purposes

        const initNav = function (conf) {
            if ($clone) {
                // clear previous instance
                $clone.remove();
            }

            // remove old toggle click event
            $toggle.off('click');

            // make new copy
            $clone = $nav.clone();

            // remember data
            $.extend(data, conf)

            // call the plugin
            $clone.hcMobileNav($.extend({}, defaultData, data));
        }

        // run first demo
        initNav({});

        $('.actions').find('a').on('click', function (e) {
            e.preventDefault();

            var $this = $(this).addClass('active');
            var $siblings = $this.parent().siblings().children('a').removeClass('active');

            initNav(eval('(' + $this.data('demo') + ')'));
        });
    })(jQuery);
</script>
<script>
    /*------------------------------------------------------------------
    [Table of contents]

    - Author:  Andrey Sokoltsov
    - Profile:	http://themeforest.net/user/andreysokoltsov
    --*/

    (function () {

        "use strict";

        var Core = {

            initialized: false,

            initialize: function () {

                if (this.initialized) return;
                this.initialized = true;

                this.build();

            },

            build: function () {


                // Counter
                this.initNumberCounter();


            },


            initNumberCounter: function (options) {
                if ($('body').length) {
                    var waypointScroll = $('.percent-blocks').data('waypoint-scroll');
                    if (waypointScroll) {
                        $(window).on('scroll', function () {
                            var winH = $(window).scrollTop();
                            $('.percent-blocks').waypoint(function () {
                                $('.chart').each(function () {
                                    CharsStart();
                                });
                            }, {
                                offset: '80%'
                            });
                        });
                    }
                }

                function CharsStart() {
                    $('.chart').easyPieChart({
                        barColor: false,
                        trackColor: false,
                        scaleColor: false,
                        scaleLength: false,
                        lineCap: false,
                        lineWidth: false,
                        size: false,
                        animate: 3000,
                        onStep: function (from, to, percent) {
                            $(this.el).find('.percent').text(Math.round(percent));
                        }
                    });
                }
            },
        };
        Core.initialize();
    })();
</script>

</body>
</html>
