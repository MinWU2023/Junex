layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'user'], function(){
    var $ = layui.$
        ,setter = layui.setter
        ,admin = layui.admin
        ,form = layui.form
        ,router = layui.router();

    form.render();

    //提交
    form.on('submit(LAY-user-reg-submit)', function(obj){
        var field = obj.field;

        //确认密码
        if(field.password !== field.password_confirmation){
            return layer.msg('两次密码输入不一致');
        }
        //请求接口
        admin.req({
            url: layui.setter.prefix + 'register'
            ,data: field
            ,type: 'post'
            ,done: function(res){
                layer.msg('注册成功', {
                    offset: '15px'
                    ,icon: 1
                    ,time: 1000
                }, function(){
                    location.href = layui.setter.prefix + 'dashboard'
                });
            }
        });

        return false;
    });
});
