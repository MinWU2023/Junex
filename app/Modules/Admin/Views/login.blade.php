<x-layui-layout>
    <style>
        html,
        body,
        .login-box {
            height: 100%;
            width: 100%;
        }

        body {
            background: url("{{ asset('/images/bg.jpg') }}") no-repeat;
            background-size: cover;
        }

        .login-box {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box .box {
            width: 1200px;
            display: flex;
            box-shadow: 0px 0px 46px 0px rgba(56, 118, 227, 0.36);
        }

        .login-box .left-box,
        .login-box .right-box {
            height: 682px;
            flex: 1;
        }

        .login-box .left-box {
            background: url("{{ asset('/images/pic.jpg') }}") no-repeat;
            background-size: cover;
        }

        .login-box .right-box {
            position: relative;
            line-height: 1;
            background: #fff;
        }

        .login-box .logo {
            position: absolute;
            right: 0;
            top: 0;
        }

        .login-box .title {
            color: #000000;
            font-size: 26px;
            font-weight: normal;
            text-align: center;
            margin: 144px 0 46px;
        }

        .login-box .title span {
            color: #3e7be6;
        }

        .login-box .main-box {
            margin: 0 60px;
            border: solid 3px #f2f2f2;
            border-top: none;
            box-sizing: border-box;
        }

        .login-box .tab-btn {
            display: flex;
        }

        .login-box .tab-btn .btn {
            flex: 1;
            background: #f2f2f2;
            text-align: center;
            height: 48px;
            line-height: 48px;
            border-top: 3px solid transparent;
            box-sizing: border-box;
            cursor: pointer;
            font-size: 16px;
        }

        .login-box .tab-btn .btn.active {
            background: #fff;
            border-top: 3px solid #3e7be6;
        }

        .login-box .name {
            font-size: 22px;
            color: #333333;
            font-weight: normal;
            text-align: center;
            margin-bottom: 33px;
        }

        .login-box .w-name {
            margin-bottom: 0;
        }

        .login-box .content {
            padding: 33px 18px 5px;
            display: none;
        }

        .login-box .content .wei-box {
            height: 319px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box .content .wei-box .i-box {
            display: flex;
            max-width: 218px;
            background-color: #ffffff;
            border: solid 6px #c8d5ef;
            align-items: center;
            justify-content: center;
        }

        .login-box .content .wei-box #qrcode {
            width: 200px;
            height: 200px;
        }

        .login-box .content.active {
            display: block;
        }

        .login-box .content input {
            display: block;
            width: 100%;
            margin-bottom: 35px;
            height: 48px;
            line-height: 48px;
            padding: 0 10px 0 37px;
            box-sizing: border-box;
            border: solid 1px #dedede;
            font-size: 16px;
            color: #333333;
            outline: none;
        }

        .login-box .content input:focus {
            border: solid 1px #3e7be6 !important;
        }

        .login-box .content .user-name {
            background: url("{{ asset('/images/user.png') }}") no-repeat 12px 14px;
            background-size: 18px 18px;
        }

        .login-box .content .user-pwd {
            background: url("{{ asset('/images/pwd.png') }}") no-repeat 12px 14px;
            background-size: 18px 18px;
        }

        .login-box .content .btn {
            display: block;
            width: 100%;
            height: 48px;
            line-height: 48px;
            background-color: #3e7be6;
            color: #fefefe;
            font-size: 16px;
            text-align: center;
            margin-bottom: 35px;
            border: none;
            outline: none;
            cursor: pointer;
        }
        @media screen and (max-width: 768px) {
            body{background-size: auto;background-position: center;}
            .login-box .main-box{margin: 0 5%;}
            /* .login-box .box{box-shadow: none;} */
            .login-box .left-box {
               display: none;
            }
            .login-box .right-box {
                width: 100%;
            }
            .layadmin-user-login{padding-top: 0;align-items: flex-start;}
        }
    </style>

    <body>
    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">
        <div class="login-box">
            <div class="box">
                <div class="left-box"></div>
                <input type="hidden" id="login_pwd_encrypt" value="{{ (isset(app('settings')['setting']) && is_object(app('settings')['setting'])) ? app('settings')['setting']->login_pwd_encrypt : 0 }}">
                <div class="right-box">
                    <img src="{{ asset('/images/login-logo.png') }}" class="logo"/>
                    <h3 class="title"><span>DIYIYE</span>{{ __('后台管理系统') }}</h3>
                    <div class="main-box">
                        <div class="tab-box">
                            <ul class="tab-btn">
                                <li class="btn active">{{ __('微信二维码登录') }}</li>
                                <li class="btn">{{ __('账号密码登录') }}</li>
                            </ul>
                            <div class="tab-content">
                                <div class="content active">
                                    <h3 class="name w-name">{{ __('微信二维码登录') }}</h3>
                                    <div class="wei-box">
                                            <span class="i-box">
                                                <div id="qrcode"></div>
                                                <!-- <img src="{{ asset('/images/weixin.png') }}"> -->
                                            </span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3 class="name">{{ __('账号密码登录') }}</h3>
                                    <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                                        @csrf
                                        <div class="layui-form-item">
                                            <label for="LAY-user-login-email"></label>
                                            <input type="text" name="email" value=""
                                                   id="LAY-user-login-email" lay-verify="required" placeholder="{{ __('邮箱') }}"
                                                   class="layui-input user-name">
                                        </div>
                                        <div class="layui-form-item">
                                            <label for="LAY-user-login-password"></label>
                                            <input type="password" name="password" value=""
                                                   id="LAY-user-login-password" lay-verify="required" placeholder="{{ __('密码') }}"
                                                   class="layui-input user-pwd">
                                        </div>
                                        <div class="layui-form-item">
                                            <button class="layui-btn layui-btn-fluid btn" lay-submit
                                                    lay-filter="LAY-user-login-submit">{{ __('登 入') }}
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>var websiteId = '<?= (isset(app('settings')['setting']) && is_object(app('settings')['setting'])) ? app('settings')['setting']->website_id : 0 ?>'</script>
        <script src="{{ asset('/js/admin/admin.newjquery.min.js') }}"></script>
        <script src="{{ asset('/js/admin/admin.socket.io.js')}}"></script>
        <script src="{{ asset('/js/admin/admin.echo.iife.js') }}"></script>
        <script src="{{ asset('/js/admin/admin.qrcode.js') }}"></script>
        <script src="{{ asset('/js/admin/admin.login.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin/admin.login.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
