layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'uploadLaravel','fileUploadOne', 'element'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form
        , element = layui.element;
    var $ = layui.$
    var token = $('#token').val()

    var renderBanner = function() {
        if ($('#LAY-app-content-list').data('rendered')) return;
        table.render({
            elem: "#LAY-app-content-list",
            url: layui.setter.prefix + 'setting/banner',
            cols: [[
                // {
                //     field: "id",
                //     title: "ID",
                //     // sort: !0
                // },
                {
                    field: "path",
                    title: '图片',
                    align: 'center',
                    templet: '#bannerThumb'
                },
                {
                    field: "url",
                    title: "跳转链接"
                },
                {
                    field: "name",
                    title: "标题"
                },
                {
                    field: "description",
                    title: "描述"
                },
                {
                    field: "area",
                    title: "显示区域"
                },
                {
                    title: "操作",
                    align: "center",
                    toolbar: "#table-content-list"
                }]],
            page: !0,
            limit: 10,
            limits: [10, 15, 20, 25, 30],
            text: "对不起，加载出现异常！",
            done: function() { $('#LAY-app-content-list').data('rendered', true); }
        });
    };

    var renderLocale = function() {
        if ($('#LAY-app-locale-content-list').data('rendered')) return;
        table.render({
            elem: "#LAY-app-locale-content-list",
            url: layui.setter.prefix + 'setting/locale',
            cols: [[
                {
                    field: "path",
                    title: '语言图标',
                    align: 'center',
                    templet: '#productThumb'
                },
                {
                    field: "language",
                    title: "语言"
                },
                {
                    field: "language_code",
                    title: "语言代码"
                },
                {
                    field: "url",
                    title: "链接"
                },
                {
                    field: "sort",
                    title: "排序"
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
            done: function() { $('#LAY-app-locale-content-list').data('rendered', true); }
        });
    };

    var renderSlogan = function() {
        if ($('#LAY-app-slogan-content-list').data('rendered')) return;
        table.render({
            elem: "#LAY-app-slogan-content-list",
            url: layui.setter.prefix + 'setting/slogan',
            cols: [[
                // {
                //     field: "id",
                //     title: "ID",
                //     // sort: !0
                // },
                {
                    field: "type",
                    title: "类型"
                },
                {
                    field: "name",
                    title: "标语"
                },
                {
                    title: "操作",
                    width: 180,
                    align: "center",
                    toolbar: "#table-content-list"
                }]],
            page: !0,
            limit: 10,
            limits: [10, 15, 20, 25, 30],
            text: "对不起，加载出现异常！",
            done: function() { $('#LAY-app-slogan-content-list').data('rendered', true); }
        });
    };

    element.on('tab(setting-tabs)', function(data){
        var layId = $(this).attr('lay-id');
        if(layId === 'banner') renderBanner();
        if(layId === 'locale') renderLocale();
        if(layId === 'slogan') renderSlogan();
    });

    var activeId = $('.layui-tab-title .layui-this').attr('lay-id');
    if(activeId === 'banner') renderBanner();
    else if(activeId === 'locale') renderLocale();
    else if(activeId === 'slogan') renderSlogan();

    active = {
        add: function () {
            layer.open({
                type: 2
                ,closeBtn: 2
                , title: '添加banner'
                , content: '/' + window.admin_prefix + '/setting/banner/create'
                , maxmin: true
                , area: window.layerArea
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                    submit.click();
                }
                , end: function(){
                    window.canAjax = true
                }
            });
        },
        slogan_add: function () {
            layer.open({
                type: 2
                ,closeBtn: 2
                , title: '添加slogan'
                , content: '/' + window.admin_prefix + '/setting/slogan/create'
                , maxmin: true
                , area: window.layerArea
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-slogan-form-submit");
                    submit.click();
                }
                , end: function(){
                    window.canAjax = true
                }
            });
        },
        locale_add: function () {
            layer.open({
                type: 2
                ,closeBtn: 2
                , title: '添加locale'
                , content: '/' + window.admin_prefix + '/setting/locale/create'
                , maxmin: true
                , area: window.layerArea
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-locale-form-submit");
                    submit.click();
                }
                , end: function(){
                    window.canAjax = true
                }
            });
        },
        locale_sync: function () {
            if (window.canAjax) {
                window.canAjax = false
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                var loading = layer.load();
                admin.req({
                    url: layui.setter.prefix + 'syncLocale'
                    ,type: 'post'
                    ,data: { '_token': token}
                    ,success: function(res){
                        if (res.status === true){
                            layer.msg(res.msg, {
                                offset: '15px'
                                ,icon: 1
                                ,time: 1000
                            });
                        }else{
                            layer.msg(res.msg, {
                                offset: '15px'
                                ,icon: 3
                                ,time: 1000
                            });
                        }
                        layer.close(loading);
                        parent.layer.close(index); //再执行关闭
                        window.canAjax = true
                    }
                    ,error: function (err) {
                        layer.close(loading);
                        window.canAjax = true
                    }
                });
            }
        },
    };

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });


    table.on("tool(LAY-app-locale-content-list)",
        function(t) {
            var e = t.data;
            "del" === t.event ? layer.confirm("确定删除此语言？",
                function(index) {
                    admin.req({
                        url: layui.setter.prefix + 'setting/locale/' + e.id
                        ,data: { '_token': token}
                        ,type: 'delete'
                        ,done: function(res){
                            layer.msg('删除成功', {
                                offset: '15px'
                                ,icon: 1
                                ,time: 1000
                            }, function(){
                                layui.table.reload('LAY-app-locale-content-list');
                                layer.close(index)
                            });
                        }
                    });
                }) : "edit" === t.event && layer.open({
                type: 2,
                title: "编辑多语言",
                content: layui.setter.prefix + 'setting/locale/' + e.id + '/edit',
                maxmin: !0,
                area: window.layerArea,
                btn: ["确定", "取消"],
                yes: function(index, layero) {
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-locale-form-submit");
                    submit.click();
                }
            })
        })

    table.on("tool(LAY-app-content-list)",
        function(t) {
            var e = t.data;
            switch (t.event) {
                case "layui-img":
                    layer.open({
                        type: 2,
                        shade: 0.8,
                        offset: 'auto',
                        area: window.layerArea,
                        shadeClose: true,
                        maxmin: true,
                        scrollbar: false,
                        title: "图片预览",
                        content: e.true_path,
                        cancel: function () {
                            //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                        }
                    });
                    break;
                case 'del':
                    layer.confirm("确定删除此banner位？",
                        function(index) {
                            admin.req({
                                url: layui.setter.prefix + 'setting/banner/' + e.id
                                ,data: { '_token': token}
                                ,type: 'delete'
                                ,done: function(res){
                                    layer.msg('删除成功', {
                                        offset: '15px'
                                        ,icon: 1
                                        ,time: 1000
                                    }, function(){
                                        layui.table.reload('LAY-app-content-list');
                                        layer.close(index)
                            });
                        }
                    });
                })
                    break;
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑banner",
                        content: layui.setter.prefix + 'setting/banner/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function(index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    })
                    break;
            }
        })


    table.on("tool(LAY-app-slogan-content-list)",
        function(t) {
            var e = t.data;
            switch (t.event) {
                case 'del':
                    layer.confirm("确定删除此slogan？",
                        function(index) {
                            admin.req({
                                url: layui.setter.prefix + 'setting/slogan/' + e.id
                                ,data: { '_token': token}
                                ,type: 'delete'
                                ,done: function(res){
                                    layer.msg('删除成功', {
                                        offset: '15px'
                                        ,icon: 1
                                        ,time: 1000
                                    }, function(){
                                        layui.table.reload('LAY-app-slogan-content-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑slogan",
                        content: layui.setter.prefix + 'setting/slogan/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function(index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-slogan-form-submit");
                            submit.click();
                        }
                    })
                    break;
            }
        })
    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting/banner'
                ,type: 'post'
                ,data: data.field
                ,done: function(res){
                    layer.msg('添加成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });


    form.on('submit(layuiadmin-app-create-slogan-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting/slogan'
                ,type: 'post'
                ,data: data.field
                ,done: function(res){
                    layer.msg('添加成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-slogan-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });

    form.on('submit(layuiadmin-app-edit-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'setting/banner/' + id
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });

    form.on('submit(layuiadmin-app-create-locale-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting/locale'
                ,type: 'post'
                ,data: data.field
                ,done: function(res){
                    layer.msg('添加成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-locale-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });


    form.on('submit(layuiadmin-app-edit-slogan-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'setting/slogan/' + id
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-slogan-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });

    form.on('submit(layuiadmin-app-edit-locale-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'setting/locale/' + id
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-locale-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });

    form.on('submit(component-form-demo1)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting'
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        window.canAjax = true
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
        return false
    });
    form.on('submit(component-form-cache)', function(data){
        data.field.is_cache = $("[name='is_cache']:checked").val() === "on" ? 1 : 0;
        if (window.canAjax) {
            window.canAjax = false
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting'
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        window.canAjax = true
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
        return false
    });
    form.on('submit(component-form-seo-template)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting'
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        window.canAjax = true
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
        return false
    });

});
