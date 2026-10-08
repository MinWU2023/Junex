layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'form'],function (){
    var $ = layui.$,
        form = layui.form,
        admin = layui.admin;
    $(function () {
        setInterval(function () {
            $.ajax({
                url: '/' + window.admin_prefix + '/keeplive',
                type: "GET",
                success: function (data) {
                    console.log(data)
                }
            });
        }, 10000);
        if ( typeof forceChangePassword != "undefined"   &&   forceChangePassword === '1') {
            layer.open({
                type: 2
                , closeBtn: 0
                , title: '修改密码'
                , content: '/' + window.admin_prefix + '/changePassword'
                , maxmin: false
                , area: window.layerArea
                , btn: ['确定']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-password-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        }
        // setInterval(function()
        // {
        //     $.get('/refresh-csrf').done(function(data)
        //     {
        //         $('meta[name="csrf-token"]').attr('content', data);
        //     });
        // }, 1800000); // 30 minutes
    })

    form.on('submit(layuiadmin-app-password-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'changePassword'
                ,type: 'put'
                ,data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        // parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

    form.verify({
        pass: [
            /^[\S]{8,16}$/,
            '密码必须8到16位，且不能出现空格'
        ],
        confirmPassword: function(value, item){
            var passwordValue = $('#password').val();
            if(value !== passwordValue){
                return '两次密码输入不一致';
            }
        }
    });


});

