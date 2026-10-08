layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'treeTable', 'form', 'uploadLaravel'], function () {
    var table = layui.treeTable
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    let  is_admin = $("#is_admin").val();
    let table_cols = [[
        // {
        //     field: "id",
        //     width: 100,
        //     title: "分类ID",
        //     // sort: !0
        // },
        {
            templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
            width: 400,
            title: "分类名"
        },
        {
            templet: '#products',
            align: 'left',
            title: "商品数量"
        },
        {
            field: "sort",
            title: "排序",
            edit: 'number',
            templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
        },
        {
            field: "is_show",
            title: "是否显示",
            templet: "#is_show"
        },
        {
            field: "is_menu",
            title: "是否推荐",
            templet: "#is_menu"
        },
        {
            title: "操作",
            minWidth: 150,
            align: "center",
            toolbar: "#table-content-list"
        }]];
    if (is_admin){
        table_cols = [[
            {
                field: "id",
                width: 100,
                title: "分类ID",
                // sort: !0
            },
            {
                templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
                width: 400,
                title: "分类名"
            },
            {
                templet: '#products',
                align: 'left',
                title: "商品数量"
            },
            {
                field: "sort",
                title: "排序",
                edit: 'number',
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
            },
            {
                field: "is_show",
                title: "是否显示",
                templet: "#is_show"
            },
            {
                field: "is_menu",
                title: "是否显示导航",
                templet: "#is_menu"
            },
            {
                title: "操作",
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }]];
    }
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'product/category',
        tree: {
            iconIndex: 0,           // 折叠图标显示在第几列
            isPidData: true,        // 是否是id、pid形式数据
            idName: 'id',  // id字段名称
            openName: 'name',
            pidName: 'parent_id'     // pid字段名称
        },
        cols: table_cols,
        page: !0,
        where: {
            name: $('#name').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！"
    });
    active = {
        reload: function () {
            var search_name = $("#search_name").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: search_name
                }
            });
        },
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: '添加分类'
                , content: '/' + window.admin_prefix + '/product/category/create'
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


    table.on('edit(LAY-app-content-list)', function (obj) {
        var value = ~~obj.value.replace(/^(0*)|\D/g, '') //得到修改后的值
            , sendData = {};
        sendData.sort = value;
        sendData.type = 'category_sort';
        sendData._token = token;
        obj.data.sort = value;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'product/category/change_property/' + obj.data.id
            , type: 'put'
            , data: sendData
            , done: function (res) {
                layer.msg('修改成功', {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    layer.close(loading);
                    // layui.treeTable.reload('LAY-app-content-list');
                });
            }
        });
    });

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case 'category_show':
                case 'category_menu':
                    admin.req({
                        url: layui.setter.prefix + 'product/category/change_property/' + e.id
                        , type: 'put'
                        , data: {'_token': token, 'type': t.event}
                        , done: function (res) {
                            layer.msg('操作成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layui.treeTable.reload('LAY-app-content-list');
                                layer.close(index)
                            });
                        }
                    });
                    break;
                case 'del':
                    layer.confirm("确定删除此分类？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/category/' + e.id
                                , data: {'_token': token}
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg('删除成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.treeTable.reload('LAY-app-content-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑分类",
                        content: layui.setter.prefix + 'product/category/' + e.id + '/edit',
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

    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'product/category'
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
                        parent.layui.treeTable.reload('LAY-app-content-list'); //重载表格
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
                url: layui.setter.prefix + 'product/category/' + id
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
                        parent.layui.treeTable.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

});
