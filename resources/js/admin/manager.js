layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'manager',
        cols: [[
            // {
            //     field: "id",
            //     width: 100,
            //     title: "ID",
            //     // sort: !0
            // },
            {
                field: "name",
                title: __("名称")
            },
            {
                field: "email",
                title: __("邮箱")
            },
            {
                templet: "<div>{{ d.roles.length ? d.roles[0].name : '游客' }}</div>",
                align: 'left',
                title: __('身份')
            },
            {
                field: "created_at",
                title: __("创建时间")
            },
            {
                title: __("操作"),
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: __("对不起，加载出现异常！！"),
    });
    active = {
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: __('添加用户')
                , content: '/' + window.admin_prefix + '/manager/create'
                , maxmin: true
                , area: window.layerArea
                , btn: [__('确定'), __('取消')]
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
            "del" === t.event ? layer.confirm(__("确定删除此用户？"),
                function (index) {
                    admin.req({
                        url: layui.setter.prefix + 'manager/' + e.id
                        , data: {'_token': token}
                        , type: 'delete'
                        , done: function (res) {
                            layer.msg(__('删除成功'), {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layui.table.reload('LAY-app-content-list');
                                layer.close(index)
                            });
                        }
                    });

                }) : "edit" === t.event && layer.open({
                type: 2,
                title: __("编辑用户"),
                content: layui.setter.prefix + 'manager/' + e.id + '/edit',
                maxmin: !0,
                area: window.layerArea,
                btn: [__("确定"), __("取消")],
                yes: function (index, layero) {
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                    submit.click();
                }
            })
        })

    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'manager'
                , type: 'post'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg(__('添加成功'), {
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
                url: layui.setter.prefix + 'manager/' + id
                , type: 'put'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg(__('修改成功'), {
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
