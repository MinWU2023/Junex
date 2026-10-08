layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'uploadLaravel', 'fileUploadOne'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val();
    var id = $('#id').val();
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'download',
        cols: [[
            {
                templet: '<div><a target="_blank" href="/{{d.filepath}}">{{ d.name }}</a></div>',
                title: "下载标题"
            },
            {
                templet: '<div>{{ d.download_category.name }}</div>',
                align: 'left',
                title: '所属分类'
            },
            {
                field: "total_download_count",
                title: "总下载次数",
                align: "center",
                templet: '<div>{{ d.total_download_count || 0 }}</div>',
            },
            {
                field: "sort",
                title: "排序",
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
                edit: 'number',
            },
            {
                title: "操作",
                align: "center",
                toolbar: "#table-content-list",
                width: 300,
            }]],
        page: !0,
        where: {
            name: $('#name').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
    });

    table.render({
        elem: "#LAY-app-content-record-list",
        url: layui.setter.prefix + 'download/' + id + '/download_record',
        cols: [[
            {
                field: "ip",
                width: 400,
                title: "ip"
            },
            {
                field: "ip_address",
                align: 'left',
                width: 400,
                title: 'ip地址'
            },
            {
                field: "download_count",
                align: 'left',
                width: 400,
                title: '下载次数'
            },
            {
                title: "操作",
                width: 200,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        where: {
            ip: $('#ip').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
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
        sendData.download_category_id = obj.data.download_category_id;
        sendData._token = token;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'download/' + obj.data.id
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
        record_reload: function () {
            var search_ip = $("#ip").val()
            //执行重载
            table.reload('LAY-app-content-record-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    ip: search_ip,
                }
            });
        },
        reload: function () {
            var search_name = $("#search_name").val()
            var category = $("[name='download_category_id']")
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: search_name,
                    category_id: category.val(),
                }
            });
        },
        reset_download_key: function () {

            layer.confirm("确定重置下载key？",
                function (index) {
                    admin.req({
                        url: '/' + window.admin_prefix + '/download/reset_download_key'
                        , data: { '_token': token }
                        , type: 'post'
                        , done: function (res) {
                            layer.msg('重置下载key成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layer.close(index)
                            });
                        }
                    });

                })
        },
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: '添加下载'
                , content: '/' + window.admin_prefix + '/download/create'
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
        }
    };

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case 'download_show':
                case 'download_menu':
                    admin.req({
                        url: layui.setter.prefix + 'download/change_property/' + e.id
                        , type: 'put'
                        , data: { '_token': token, 'type': t.event }
                        , done: function (res) {
                            layer.msg('操作成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layui.table.reload('LAY-app-content-list');
                                layer.close(index)
                            });
                        }
                    });
                    break;
                case 'download_record':
                    layer.open({
                        type: 2,
                        title: "下载记录",
                        content: layui.setter.prefix + 'download/' + e.id + '/download_record',
                        maxmin: !0,
                        area: window.layerArea,
                    });
                    break;
                case 'remove':
                    layer.confirm("确定删除此下载？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'download/' + e.id
                                , data: { '_token': token }
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

                        })
                    break;
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑下载",
                        content: layui.setter.prefix + 'download/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    })
                    break;
            }
        })

    table.on("tool(LAY-app-content-trash-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "del":
                    layer.confirm("永久删除此下载？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'download/' + e.id
                                , data: { '_token': token }
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg('下载删除成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-trash-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
                case "restore":
                    layer.confirm("确定恢复此下载？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'download/restore/' + e.id
                                , type: 'get'
                                , done: function (res) {
                                    layer.msg('恢复下载成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-trash-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
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
                url: layui.setter.prefix + 'download'
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
                        parent.layui.table.reload('LAY-app-content-list'); //重载表格
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
                url: layui.setter.prefix + 'download/' + id
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

});
