layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'uploadLaravel', 'productFileUpload','albumImageUpload'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'photoAlbum',
        cols: [[
            {
                field: "name",
                width: 400,
                title: "相册名"
            },
            // {
            //     field: "sort",
            //     title: "排序",
            //     templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
            //     edit: 'number'
            // },
            {
                templet: '#imgCount',
                title: "图片数",
            },
            {
                title: "操作",
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        where: {
            name: $('#name').val(),
        },
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！",
    });
    table.on('edit(LAY-app-content-list)', function (obj) {
        var sort = ~~obj.value.replace(/^(0*)|\D/g, '') //得到修改后的值
            , sendData = {}
        sendData.translate = {}
        obj.data.translations.forEach((q) => {

            sendData.translate[q.locale] = {}
            sendData.translate[q.locale].name = q.name
        })
        sendData.sort = sort;
        sendData.url_key = obj.data.url_key;
        sendData._token = token;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'photoAlbum/' + obj.data.id
            , type: 'put'
            , data: sendData
            , done: function (res) {
                layer.msg('修改成功', {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    layer.close(loading);
                    // layui.table.reload('LAY-app-content-list'); //重载表格
                });
            }
        });

    })
    active = {
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: '添加相册'
                , content: '/' + window.admin_prefix + '/photoAlbum/create'
                , maxmin: true
                , area: window.layerArea
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        },
        reload: function () {
            var search_name = $("#search_name").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                photoAlbum: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: search_name
                }
            });
        },
    };

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });


    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "remove":
                    layer.confirm("确定删除改相册？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'photoAlbum/' + e.id
                                , data: {'_token': token, 'id': e.id}
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg('删除成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        });
                    break;
                case "edit":
                    layer.open({
                        type: 2,
                        title: "编辑相册",
                        content: layui.setter.prefix + 'photoAlbum/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    });
                    break;
                case "upload":
                    layer.open({
                        type: 2,
                        title: "批量上传图片",
                        content: layui.setter.prefix + 'photoAlbum/' + e.id + '/upload',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-upload-form-submit");
                            submit.click();
                        }
                    });
                    break;
                case "photo":
                    layer.open({
                        type: 2,
                        title: "查看相册",
                        content: layui.setter.prefix + 'photoAlbum/' + e.id + '/photo',
                        maxmin: !0,
                        area: window.layerArea,
                        // btn: ["确定", "取消"],
                        // yes: function (index, layero) {
                        //     var submit = layero.find('iframe').contents().find("#layuiadmin-app-upload-form-submit");
                        //     submit.click();
                        // }
                    });
                    break;
            }
        })
    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'photoAlbum'
                , type: 'post'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg('添加成功', {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        // 在图片弹窗等场景，parent 可能没有 table（避免报错导致无法关闭）
                        try {
                            if (parent && parent.layui && parent.layui.table && typeof parent.layui.table.reload === 'function') {
                                parent.layui.table.reload('LAY-app-content-list'); //重载表格
                            }
                        } catch (e) {}
                        // 给父页面一个标记，用于刷新相册分类列表
                        try { parent.__photoAlbumChanged = true } catch (e) {}
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

    form.on('submit(layuiadmin-app-edit-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'photoAlbum/' + id
                , type: 'put'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
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

    form.on('submit(layuiadmin-app-upload-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'photoAlbum/upload'
                , type: 'post'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg('上传成功', {
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

});


