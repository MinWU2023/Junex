layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var guest = $('#guest').val()
    var token = $('#token').val()
    if (guest) {
        layer.open({
            type: 2
            ,closeBtn: 0
            , title: '请先登陆到CRM系统'
            , content: '/' + window.admin_prefix + '/extension-market/login'
            , maxmin: true
            , area: window.layerArea
            , btn: ['确定', '取消']
            , success: function(layero) {
                layero.find('.layui-layer-min').remove(); //去掉最小化按钮
                layero.find('.layui-layer-max').remove(); //去掉最大化按钮
            }
            , yes: function (index, layero) {
                //点击确认触发 iframe 内容中的按钮提交
                var submit = layero.find('iframe').contents().find("#layuiadmin-app-login-form-submit");
                submit.click();
            }
            , end: function(){
                window.canAjax = true
            }
        });
        return false;
    }
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'extension-market/index',
        cols: [[
            // {
            //     field: "id",
            //     width: 100,
            //     title: "ID",
            //     // sort: !0
            // },
            {
                field: "img",
                width: 200,
                title: '图片',
                align: 'center',
                templet: '#bannerThumb'
            },
            {
                field: "name",
                title: "插件名称"
            },
            {
                field: "info",
                title: "描述"
            },
            {
                field: "version",
                title: "版本号",
                templet: "#version"
            },
            {
                templet:'<div>{{ parseInt(d.size / 1024)  }}KB</div>',
                title: "大小"
            },
            {
                title: "操作",
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
    });

    table.on("tool(LAY-app-content-list)",
        function(t) {
            var e = t.data;
            e._token = token
            switch (t.event) {
                case "layui-img":
                    layer.open({
                        type: 2,
                        shade: 0.8,
                        offset: 'auto',
                        area:  window.layerArea,
                        shadeClose: true,
                        maxmin: true,
                        scrollbar: false,
                        title: "图片预览",
                        content: e.img,
                        cancel: function () {
                            //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                        }
                    });
                    break;
                case "uninstall":
                    layer.confirm("确定要卸载此插件？",
                        function (index) {
                            var loading = layer.load();
                            admin.req({
                                url: layui.setter.prefix + 'extension-market/uninstall'
                                , type: 'post'
                                , data: e
                                , done: function (res) {
                                    layer.msg('插件卸载成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-list');
                                        layer.close(index);
                                        layer.close(loading);
                                    });
                                }
                                , error: function (err) {
                                    layer.close(index);
                                    layer.close(loading);
                                }
                            });
                        })
                    break;
                case "upgrade":
                    layer.confirm("确定要升级此插件？升级会覆盖原有的插件，请做好备份工作。",
                        function (index) {
                            var loading = layer.load();
                            admin.req({
                                url: layui.setter.prefix + 'extension-market/upgrade'
                                , type: 'post'
                                , data: e
                                , done: function (res) {
                                    layer.msg('插件升级成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-list');
                                        layer.close(index);
                                        layer.close(loading);
                                    });
                                }
                                , error: function (err) {
                                    layer.close(index);
                                    layer.close(loading);
                                }
                            });
                        })
                    break;
                case "install":
                    layer.confirm("确定要安装此插件？",
                        function (index) {
                            var loading = layer.load();
                            admin.req({
                                url: layui.setter.prefix + 'extension-market/install'
                                , type: 'post'
                                , data: e
                                , done: function (res) {
                                    layer.msg('插件安装成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-list');
                                        layer.close(index);
                                        layer.close(loading);
                                    });
                                }
                                , error: function (err) {
                                    layer.close(index);
                                    layer.close(loading);
                                }
                            });
                        })
                    break;
                case "edit":
                    layer.open({
                        type: 2,
                        title: "编辑配置",
                        content: layui.setter.prefix + 'extension-market/' + e.inject.id + '/edit',
                        maxmin: !0,
                        area:  window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    })
                    break;
            }
        })



    form.on('submit(layuiadmin-app-edit-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'extension-market/' + id
                , type: 'put'
                , data: data.field
                , done: function (res) {
                    layer.msg('修改成功', {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });


    //监听提交
    form.on('submit(layuiadmin-app-login-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'extension-market/doLogin'
                ,type: 'post'
                ,data: data.field
                ,done: function(res){
                    layer.msg('添加成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layer.close(index); //再执行关闭
                        parent.window.location.reload()
                    });
                }
                ,error: function (res) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });
});
