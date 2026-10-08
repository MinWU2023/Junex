layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'user'], function () {
    var $ = layui.$
        , setter = layui.setter
        , admin = layui.admin
        , form = layui.form
        , router = layui.router()
        , search = router.search;

    form.render();
    /* 微信和账号密码登录切换 */
    $('.tab-btn .btn').on('click', function (e) {
        e.stopPropagation();
        var $index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.tab-content .content').eq($index).addClass('active').siblings().removeClass('active');
    });

    function randomText($len) {
        var len = $len || 10,
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
            maxPos = $chars.length,
            pwd = '';
        for (let i = 0; i < len; i++) {
            pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    }

    var buildToken = randomText(64),
        buildSocket = randomText(64);

    $('#qrcode').qrcode({
        render: "canvas",//设置渲染方式 （有两种方式 table和canvas，默认是canvas）
        width: 200,//宽度
        height: 200,//高度
        correctLevel: 0,//纠错等级
        text: 'http://api.crm.dyyseo.com/wxClientLogin/' + buildToken+ '/' + buildSocket + '/' + websiteId,//生成二维码的文本
        background: "#ffffff",//背景色
        foreground: "#000000",//前景色
    });
    window.io = io;
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: 'https://api.crm.dyyseo.com:2096'
    });
    window.Echo.channel('login-wechat').listen('LoginWechatEvent', function (data) {
        if (data.data.status && data.socket && data.socket == buildSocket) {
            let postData = {
                token: buildToken,
                _token: $("input[name=_token]").val()
            }
            weixinLogin(postData);
        }
    });

    /* 新增逻辑, 如果登录状态过期 直接顶层回到登录页面 */
    if (window != top) {
        top.location.href = location.href;
    };
    form.on('submit(LAY-user-login-submit)', function (obj) {
        if ($('#login_pwd_encrypt').val() == 1) {
            let encoded = btoa(unescape(encodeURIComponent(obj.field.password)));
            obj.field.password = encoded;
        }
        admin.req({
            url: layui.setter.prefix + 'login'
            , type: 'post'
            , data: obj.field
            , done: function (res) {
                layer.msg('登入成功', {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    location.href = layui.setter.prefix + 'dashboard'
                });
            }
        });
    });

    function weixinLogin($token){
        admin.req({
            url: layui.setter.prefix + 'wechatLogin'
            , type: 'post'
            , data: $token
            , done: function (res) {
                if (res['status']) {
                    layer.msg('登入成功', {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        location.href = layui.setter.prefix + 'dashboard'
                    });
                } else {
                    layer.msg(res.error_msg, {
                        offset: '15px'
                        , icon: 5
                        , time: 1000
                    });
                }

            }
        });
    }
});
