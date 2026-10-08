layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index',
    excel: 'layui_exts/excel'
}).use(['index', 'table', 'form', 'excel'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    var id = $('#LAY-app-products-content-list').attr('data-id')
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'product/tag',
        cols: [[
            {
                type: 'checkbox',
            },
            // {
            //     field: "id",
            //     width: 100,
            //     title: "tagID",
            //     // sort: !0
            // },
            {
                field: "name",
                width: 400,
                title: "tag名"
            },
            {
                field: 'product_count',
                title: '关联产品数',
                templet: "#show_product"
            },
            {
                field: "sort",
                title: "排序",
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
                edit: 'number'
            },
            {
                field: "is_hot",
                title: "is_hot",
                templet: "#is_hot"
            },

            {
                title: "操作",
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        where: {
            name: $('#name').val(),
        },
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
        sendData._token = token;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'product/tag/' + obj.data.id
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
    table.render({
        elem: "#LAY-app-products-content-list",
        url: layui.setter.prefix + 'product/tag/' + id,
        cols: [[
            {
                field: "name",
                title: "产品名",
                templet: '#click_product'
            },
            {
                field: "tag_name",
                title: "关联tag名"
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
    active = {
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: '添加tag'
                , content: '/' + window.admin_prefix + '/product/tag/create'
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
        export: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            var message = "确定导出选中关键词吗？";
            if (!ids.length) {
                message = "确定导出所有关键词吗？";
            }
            var export_locale = $('#export_locale[name=export_locale]').val()

            layer.confirm(message, function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'product/tag/export'
                        , type: 'post'
                        , data: { ids: ids, _token: token, locale: export_locale }
                        , done: function (res) {
                            layer.msg('导出成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                var myDate = new Date();
                                layui.excel.exportExcel(res.data, '关键词' + myDate.getTime() + '导出.xlsx', 'xlsx')
                                window.canAjax = true
                                layer.close(loading);
                            });

                        }
                    });
                }
            })
        },
        removes: function () { //获取选中数据
            layer.confirm("确定删除未关联产品的关键词？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'product/tag/removes'
                        , type: 'post'
                        , data: { _token: token }
                        , error: function (e) {
                            layer.close(loading)
                            window.canAjax = true
                        }
                        , success: function (res) {
                            layer.msg('清除成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                window.canAjax = true
                                layui.table.reload('LAY-app-content-list');
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

        reload: function () {
            var name = $("#name").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: name,
                }
            });
        },

        filterHot: function () {
            var name = $("#name").val()
            //执行重载，筛选热门关键词
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: name,
                    is_hot: 1  // 筛选热门关键词
                }
            });
            // 切换按钮显示
            $('#filterHotBtn').hide();
            $('#cancelFilterBtn').show();
        },

        cancelFilter: function () {
            var name = $("#name").val()
            //执行重载，取消筛选，显示所有关键词
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: name,
                    is_hot: 0,
                }
            });
            // 切换按钮显示
            $('#cancelFilterBtn').hide();
            $('#filterHotBtn').show();
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
                case 'showProducts':
                    layer.open({
                        type: 2,
                        title: "显示关联产品",
                        content: layui.setter.prefix + 'product/tag/' + e.id,
                        maxmin: !0,
                        area: window.layerArea
                    })
                    break;
                case 'del':
                    layer.confirm("确定删除此tag？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/tag/' + e.id
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
                        title: "编辑tag",
                        content: layui.setter.prefix + 'product/tag/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    })
                    break;

                case "edit_hot":
                    admin.req({
                        url: layui.setter.prefix + 'product/tag/change_property/' + e.id
                        , type: 'put'
                        , data: { '_token': token, 'type': t.event }
                        , done: function (res) {
                            layer.msg('操作成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layui.table.reload('LAY-app-content-list');
                            });
                        }
                    });
                    break;

            }
        })

    table.on("tool(LAY-app-products-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case 'del':
                    layer.confirm("确定要解除关联？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/tag/detach'
                                , data: { '_token': token, 'product': e.id, 'tag': e.tag_id }
                                , type: 'put'
                                , done: function (res) {
                                    layer.msg('解除关联成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-products-content-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑tag",
                        content: layui.setter.prefix + 'product/tag/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    })
                    break;
                case 'clickProduct':
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index);
                    top.layui.index.openTabsPage(layui.setter.prefix + 'product?name=' + e.name, '产品列表');
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
                url: layui.setter.prefix + 'product/tag'
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
                url: layui.setter.prefix + 'product/tag/' + id
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
