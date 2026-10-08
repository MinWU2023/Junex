layui.define(["index", "layim"], function (e) {
    var $ = layui.$
    var layim = layui.layim
    var socket;
    var ping;
    var imIndex = null;
    wsInit();
    layim.config({
        isgroup: false,
        copyright: true,
        title: '联络我们',
        min: true,
        notice: true,
        init: {
            url: layui.setter.prefix + "chat/list", // 接口地址（返回的数据格式见下文）
            type: 'get', // 默认get，一般可不填
            data: {} // 额外参数

        },
        // 获取群员接口（返回的数据格式见下文）
        members: {
            url: '/group_members', // 接口地址（返回的数据格式见下文）
            type: 'get', // 默认get，一般可不填
            data: {} // 额外参数
        },
        // 上传图片接口（返回的数据格式见下文），若不开启图片上传，剔除该项即可
        uploadImage: {
            // url: 'http://dyyseo_cloud.mu/api/chat/upload', // 接口地址
            url: window.api_cloud_url + 'api/chat/upload', // 接口地址
            type: 'post' // 默认post
        },
        // 上传文件接口（返回的数据格式见下文），若不开启文件上传，剔除该项即可
        // uploadFile: {
        //     url: '/upload?type=im_file&path=file', // 接口地址
        //     type: 'post' // 默认post
        // },
        // 扩展工具栏，下文会做进一步介绍（如果无需扩展，剔除该项即可）
        msgbox: '/message_box', // 消息盒子页面地址，若不开启，剔除该项即可
        chatLog: layui.setter.prefix + 'chat/record' // 聊天记录页面地址，若不开启，剔除该项即可
    });
    layim.on('sendMessage', function (res) {
        res.mine.token = chat_token;
        setTimeout(function () {
            if ($('.' + res.mine.chat_id).hasClass('layui-icon-loading')) {
                $('.' + res.mine.chat_id).html('失败').addClass('fail').removeClass('isbold layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop');
                $('.' + res.mine.chat_id).parents('.layim-msg.repeat').attr({ 'layim-event': 'repeatSend', 'isclick': true });

                /* 判断如果发送失败不应在本地缓存中，防止发送失败的数据还出现在聊天记录中 */
                var zkey = 'friend' + res.to.id;
                if (layui.data("layim")[res.mine.id].chatlog[zkey]) {
                    var chatlog = layui.data("layim")[res.mine.id].chatlog[zkey];
                    layui.each(chatlog, function (i, a) {
                        if (a.chat_id == res.mine.chat_id) {
                            a.isRead = 0;
                            chatlog.splice(i, 1);
                            var layimKey = layui.data("layim")[res.mine.id] || {};
                            layimKey.chatlog = layimKey.chatlog || {};
                            layimKey.chatlog[zkey] = chatlog;
                            layui.data("layim", {
                                key: res.mine.id,
                                value: layimKey
                            });
                        }
                    });
                }
            }
        }, 1000 * 4);
        sendMessage(socket,JSON.stringify({
            type: 'chatMessage',
            data: res
        }))
    });

    // layim初始化完成
    layim.on('ready', function (res) {
        if (res.friend && res.friend.length) {
            for (var i = 0; i < res.friend.length; i++) {
                var item = res.friend[i];
                if (item.list && item.list.length > 0) {
                    for (var j = 0; j < item.list.length; j++) {
                        if (item.list[j].unRead && item.list[j].unRead > 0) {
                            $('#layui-layim-close > img').addClass('shake');
                            if (item.list[j].id) {
                                setDom(item.list[j].id, item.list[j].unRead);
                            }
                        }
                    }
                }
            }
        }
    });

    // 监听聊天窗口的切换
    layim.on('chatChange', function (res) {
        if (res.data.unRead && res.data.unRead > 0 || $('.layim-list-friend').find('.parnet-node.shake').length) {
            setTimeout(function () {
                //发送接口告诉后台当前用户消息标记为已读
                var cuCid = $('.layim-chat-friend.layui-show').find('li.layim-chat-other:last').attr('data-cid');
                getHash(cuCid,setDom(res.data.id, '', true));
            }, 50);
        }
    });


    function setDom(i, read, isInit) {
        //isInit值为 false: 未读抖动、聊天记录展示未读条目 true: 取消未读抖动、聊天记录清空未读条目
        var iDom = $('.layim-list-friend li[data-zindex="' + i + '"]'),
            hDom = $('.layim-list-history li[data-zindex="' + i + '"]'),
            num = read > 99 ? '99+' : read;

        if (!isInit) {
            //设置分组
            iDom.find('.friend-icon').addClass('shake');
            iDom.parents('li').find('.parnet-node').addClass('shake');

            //设置历史聊天记录
            hDom.find('.no-read').html(num).removeClass('layui-hide');

            if (num) {
                var zDom = hDom.clone(true);
                hDom.remove();
                $('.layim-list-history').prepend(zDom);
            }
        } else {
            //设置分组
            iDom.find('.friend-icon').removeClass('shake');
            iDom.parents('li').find('.parnet-node').removeClass('shake');

            //设置历史聊天记录
            hDom.find('.no-read').html('').addClass('layui-hide');
        }
    }

    function wsInit(fn) {
        window.wsstatus = socket = new WebSocket('wss://api.dyycloud.com/chat?token=' + chat_token);
        socket.onopen = function () {
            console.log('websocket is connected')

            //这是如果断网状态后 再次建立websocket时,需重发
            if (fn && typeof fn == 'function') {
                fn();
            }
            ping = setInterval(function () {
                sendMessage(socket, '{"type":"ping"}');
            }, 1000 * 10);

            handleImg();
        };
        socket.onclose = function () {
            reconnectDialog();
            console.log('websocket is closed')
            clearInterval(ping)
        };
        socket.onerror = function(event) {
            reconnectDialog();
            console.log('websocket服务出错了');
            clearInterval(ping)
        };
        socket.onmessage = function (res) {
            const data = JSON.parse(res.data)
            switch (data.type) {
                case 'token expire':
                    layer.msg(data.msg);
                    break
                case 'permission forbid':
                    layer.msg(data.msg);
                    break
                case 'friend':
                    layim.getMessage(data);

                    /* 聊天窗口关闭如果有新消息抖动效果展示 */
                    if ($('#layui-layim-close').length && !$('.has-msg').hasClass('shake')) {
                        $('.has-msg').addClass('shake');
                    }
                    /* 未读提示展示 */
                    if ($(".layim-list-history li[data-zindex='" + data.id + "']").find('.no-read').html()) {
                        var staticNum = parseInt($(".layim-list-history li[data-zindex='" + data.id + "']").find('.no-read').html());
                        $(".layim-list-history li[data-zindex='" + data.id + "']").find('.no-read').html(staticNum + 1).removeClass('layui-hide');
                    } else {
                        $(".layim-list-history li[data-zindex='" + data.id + "']").find('.no-read').html('1').removeClass('layui-hide');
                    }

                    /* 好友列表抖动效果展示 */
                    var $currentDom = $(".layim-list-friend li[data-zindex='" + data.id + "']");
                    if (!$currentDom.parents('li').find('.parnet-node').hasClass('shake')) {
                        $currentDom.parents('li').find('.parnet-node').addClass('shake');
                    }

                    /* 好友列表头像抖动效果展示 */
                    if (!$currentDom.find('.friend-icon').hasClass('shake')) {
                        $currentDom.find('.friend-icon').addClass('shake');
                    }

                    /* 聊天窗口刚好是对方窗口 */
                    var layimFriendObj = $(".layui-layim-chat .layui-show .layim-chat-other img[data-zindex=" + data.id + "]");

                    /* 若有新消息时保存cid 方便后面切换聊天窗口时标记当前消息状态为已读 */
                    if (layimFriendObj.length) {
                        getHash(data.cid,setDom(data.id, '', true));
                    }
                    break
                case 'friendStatus':
                    console.log(data.status)
                    if (layim.setFriendStatus && typeof layim.setFriendStatus == 'function') {
                        layim.setFriendStatus(data.uid, data.status);
                    }
                    break
                case 'preread':
                    if (data.data.chat_id && $('.' + data.data.chat_id).length) {
                        $('.' + data.data.chat_id).attr({ 'data-cid': data.data.cid, 'data-isread': 0 }).html('未读').removeClass('fail isbold layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop');
                        $('.' + data.data.chat_id).parents('.layim-msg.repeat').attr('layim-event', '');

                        /* 判断如果收到websocket的preread状态，应重置本地缓存中聊天记录 isRead状态为0*/
                        setLog(data,0);
                    }
                    break
                case 'is_read':
                    data.data.chat_id = $('.read-status[data-cid="'+ data.data.cid +'"]').parents('.layim-msg').attr('data-chatid');
                    if (data.data.cid && $('.read-status[data-cid="' + data.data.cid + '"]').length) {
                        $('.read-status[data-cid="' + data.data.cid + '"]').attr({ 'data-isread': 1 }).html('已读').removeClass('fail isbold layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop');
                        $('.read-status[data-cid="' + data.data.cid + '"]').parents('.layim-msg.repeat').attr('layim-event', '');
                        setLog(data, 1);
                    }
                    break
            }
        };
    }

    function sendMessage(socket, data){
        var readyState = socket.readyState;
        socket.send(data)
    }

    function getHash(id,fn){
        $.ajax({
            url:layui.setter.prefix + 'chat/message/' + id,
            dataType:"json",
            type:"get",
            success:function(res){
                if(fn && typeof fn == 'function'){
                    fn();
                }
            },
            error:function(){
                layer.msg('网络未连接!', { icon: 5, time: 1500 });
            }
        });
    }

    function setLog(data, status) {
        var skey = 'friend' + data.data.chat_user_id;
        var send_user_id = data.data.send_user_id;
        if (layui.data("layim")[send_user_id].chatlog[skey]) {
            var schatlog = layui.data("layim")[send_user_id].chatlog[skey];
            layui.each(schatlog, function (i, a) {
                if (a.chat_id == data.data.chat_id) {
                    a.isRead = status || 0;
                    schatlog[i] = a;
                    var layimKey = layui.data("layim")[send_user_id] || {};
                    layimKey.chatlog = layimKey.chatlog || {};
                    layimKey.chatlog[skey] = schatlog;
                    layui.data("layim", {
                        key: send_user_id,
                        value: layimKey
                    });
                }
            });
        }
    }

    window.primatewsInit = wsInit;
    function reconnectDialog(){
        var netMsg = '聊天系统已断开!';
        imIndex = layer.open({
            title: false,
            shade: 0,
            closeBtn: 0,
            type: 1,
            offset: '15px',
            area: ['320px','40px'],
            content: '<span><i class="tip">'+ netMsg +'</i><i class="reconnect">重新连接</i></span>', //这里content是一个普通的String
            success: function(layero){
                $(layero).addClass('layim-dialog-box');
                $('.layim-dialog-box').on('click','.reconnect',function(){
                    reconnectws();
                });
            }
        });
    }

    function reconnectws(){
        if(!window.navigator.onLine){
            $('.layim-dialog-box .tip').html('网络未连接!');
        }else{
            if(socket.readyState != 1){
                $('.layim-dialog-box .tip').html('聊天系统连接中...!');
                if($('.layim-dialog-box .reconnect').attr('isGet') == 'true'){
                    return;
                }
                $('.layim-dialog-box .reconnect').attr('isGet',true);
                wsInit(getNewMsg);
            }
        }
    }

    function getNewMsg(){
        var userId = $('.layim-chat-friend.layui-show .layim-chat-other img').attr('data-zindex');
        if(userId && userId != '' && Object.prototype.toString.call(userId) != 'Null'){
            $.ajax({
                type: "get",
                url: layui.setter.prefix + 'chat/unread/' + userId,
                success: function (res) {
                    if(res.data){ //表示有未读消息，重新获取一下当前用户的未读消息即可
                        layim.primattabchat(userId);
                        layer.close(imIndex);
                    }else{
                        layer.close(imIndex);
                    }
                },
                error: function () {
                    layer.msg('网络未连接!', { icon: 5, time: 1500 });
                }
            });
        }else{
            layer.close(imIndex);
        }
    }

    function handleImg(){
        if($('#layui-layim-close .shake').length && $('#layui-layim-close .shake').attr('src')){
            var $imgSrc = $('#layui-layim-close .shake').attr('src');
            $('#layui-layim-close .shake').attr('src',$imgSrc);
        }
    }

    e("im", {});
});
