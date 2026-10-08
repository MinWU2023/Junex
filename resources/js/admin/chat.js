layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index','table', 'form', 'jquery'], function () {
    var $ = layui.jquery,
    admin = layui.admin;
    Pusher.logToConsole = true;
    // if(){

    // }
    var pusher = new Pusher(chatAppKey, { cluster: 'mt1', encrypted: true });
    var userChannel = pusher.subscribe(userChannel);
    userChannel.bind('talk-send-message', function (data) {
        console.log('这是接受的信息');
        console.log(data);
    });

    pusher.connection.bind('error', function (status) {
        console.log(66666)
        console.log(status)
    });
    // var conversationChannel = pusher.subscribe(data.talk__conversationChannel_name);
    // conversationChannel.bind('talk-send-message', function (data) {

    // });

    $('.btn').on('click', function (e) {
        e.stopPropagation();
        var $text = $('.text').val();
        console.log(admin)
        console.log(3333)
        console.log(layui)
        admin.req({
            url: layui.setter.prefix + 'api/live_chat_session/send_message'
            , type: 'post'
            , data: { user_id: '', message: $text }
            , done: function (res) {
                // layer.msg('批量恢复产品成功', {
                //     offset: '15px'
                //     , icon: 1
                //     , time: 1000
                // }, function () {
                //     window.canAjax = true
                //     layui.table.reload('LAY-app-content-trash-list');
                //     layer.close(loading);
                // });
            }
        });
    });
});
