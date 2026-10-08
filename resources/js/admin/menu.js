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
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'menu',
        tree: {
            iconIndex: 1,           // 折叠图标显示在第几列
            isPidData: true,        // 是否是id、pid形式数据
            idName: 'id',  // id字段名称
            openName: 'name',
            pidName: 'parent_id'     // pid字段名称
        },
        cols: [[
            // {
            //     field: "id",
            //     width: 100,
            //     title: "菜单ID",
            //     // sort: !0
            // },
            {
                field: "name",
                title: "菜单名"
            },
            {
                field: "route",
                title: "路由"
            },
            {
                field: "icon",
                title: '图标',
                align: 'center',
                templet: '#icon'
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
    });
    active = {
        add: function () {
            layer.open({
                type: 2
                ,closeBtn: 2
                , title: '添加菜单'
                , content: '/' + window.admin_prefix + '/menu/create'
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
        }
    };

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    table.on("tool(LAY-app-content-list)",
        function(t) {
            var e = t.data;
            "remove" === t.event ? layer.confirm("确定删除此菜单？",
                function(index) {
                    admin.req({
                        url: layui.setter.prefix + 'menu/' + e.id
                        , data: {'_token': token}
                        , type: 'delete'
                        , done: function (res) {
                            layer.msg('菜单删除成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layui.treeTable.reload('LAY-app-content-list');
                                layer.close(index)
                            });
                        }
                    });
                }) : "edit" === t.event && layer.open({
                type: 2,
                title: "编辑菜单",
                content: layui.setter.prefix + 'menu/' + e.id + '/edit',
                maxmin: !0,
                area: window.layerArea,
                btn: ["确定", "取消"],
                yes: function(index, layero) {
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                    submit.click();
                }
            })
        })
    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'menu'
                ,type: 'post'
                ,data: data.field
                ,done: function(res){
                    layer.msg('添加成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.treeTable.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
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
                url: layui.setter.prefix + 'menu/' + id
                ,type: 'put'
                ,data: data.field
                ,done: function(res){
                    layer.msg('修改成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
                        layer.close(loading);
                        parent.layui.treeTable.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

});
