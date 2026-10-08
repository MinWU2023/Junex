layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'treeTable', 'form', 'uploadLaravel', 'productFileUpload'], function () {
    // var table = layui.table
    var table = layui.treeTable
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    let  is_admin = $("#is_admin").val();
    let table_cols = [[
        {
            templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
            width: 400,
            title: __("单页面名")
        },
        {
            field: "sort",
            title: __("排序"),
            templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
            edit: 'number'
        },
        {
            title: __("操作"),
            minWidth: 150,
            align: "center",
            toolbar: "#table-content-list"
        }]];
    if (is_admin){
        table_cols = [[
            {
                field: "id",
                width: 100,
                title: __("单页面ID"),
            },
            {
                templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
                width: 400,
                title: __("单页面名")
            },
            {
                field: "sort",
                title: __("排序"),
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
                edit: 'number'
            },
            {
                title: __("操作"),
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }]];
    }
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'page',
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
        text: __("对不起，加载出现异常！"),
    });
    table.on('edit(LAY-app-content-list)', function (obj) {
        var value = ~~obj.value.replace(/^(0*)|\D/g, '') //得到修改后的值
        , sendData = {};
    sendData.sort = value;
    sendData.type = 'page_sort';
    sendData._token = token;
    obj.data.sort = value;
    var loading = layer.load();
        admin.req({
               url: layui.setter.prefix + 'page/change_property/' + obj.data.id
            , type: 'put'
            , data: sendData
            , done: function (res) {
                layer.msg(__('修改成功'), {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    layer.close(loading);
                    // layui.treeTable.reload('LAY-app-content-list'); //重载表格
                });
            }
        });

    })
    table.render({
        elem: "#LAY-app-content-trash-list",
        url: layui.setter.prefix + 'page/trash',
        tree: {
            iconIndex: 0,           // 折叠图标显示在第几列
            isPidData: true,        // 是否是id、pid形式数据
            idName: 'id',  // id字段名称
            openName: 'name',
            pidName: 'parent_id'     // pid字段名称
        },
        cols: [[
            // {
            //     field: "id",
            //     width: 100,
            //     title: "单页面ID",
            //     // sort: !0
            // },
            {
                field: "name",
                title: __("单页面名")
            },
            {
                field: "sort",
                title: __("排序")
            },
            {
                title: __("操作"),
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
        text: __("对不起，加载出现异常！"),
    });
    active = {
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: __('添加单页面')
                , content: '/' + window.admin_prefix + '/page/create'
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
                ,btn2: function (index,layero) {
                    let body = layer.getChildFrame('body', index);
                    let temp_model_id =  body.find("#temp_model_id").val()
                    admin.req({
                        url: layui.setter.prefix + 'tempPage/' + temp_model_id + '/delete'
                        , data: {'_token': token}
                        , type: 'delete'
                    });
                }
                ,cancel: function (index,layero) {
                    let body = layer.getChildFrame('body', index);
                    let temp_model_id =  body.find("#temp_model_id").val()
                    admin.req({
                        url: layui.setter.prefix + 'tempPage/' + temp_model_id + '/delete'
                        , data: {'_token': token}
                        , type: 'delete'
                    });
                }
            });
        },

        reload_trash: function () {
            var search_name = $("#search_name").val()
            //执行重载
            table.reload('LAY-app-content-trash-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: search_name,
                }
            });
        },

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
    };


    $(document).on('visibilitychange', function() {
        if (document.visibilityState !== 'visible') {
            let temp_model_id  = $("#temp_model_id").val();
            let switch_editor = $("#switch_editor").val()
            if (switch_editor == 1){
                var moreUedit = $('.tinymce_content');
                moreUedit.each(function () {
                    let id = $(this).attr('id');
                    document.getElementById(id).value = tinymce.get(id).getContent();
                })
            }
            let data = form.val("layuiadmin-form-tags");
            if (temp_model_id > 0){
                $.ajax({
                    type: "post",
                    url: '/' + window.admin_prefix + '/tempPage/'+temp_model_id+'/preview',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    dataType:'json',
                    data:data,
                })
            }
        }
    });

    $("#preview_model").click(function (){
        if (window.canAjax) {
            window.canAjax = false
            var loading = layer.load();
            let temp_model_id  = $("#temp_model_id").val();
            let switch_editor = $("#switch_editor").val()
            if (switch_editor == 1){
                var moreUedit = $('.tinymce_content');
                moreUedit.each(function () {
                    let id = $(this).attr('id');
                    document.getElementById(id).value = tinymce.get(id).getContent();
                })
            }
            let data = form.val("layuiadmin-form-tags");
            $.ajax({
                type: "post",
                url: '/' + window.admin_prefix + '/tempPage/'+temp_model_id+'/preview',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                dataType:'json',
                data:data,
                success: function (res) {
                    layer.close(loading);
                    window.canAjax = true
                    $("#temp_model_id").val(res.data.temp_model_id)
                    event.preventDefault(); // 阻止默认行为
                    window.open(res.data.url_key, '_blank'); // 在新标签页中打开链接
                }
            })
        }

    })

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });


    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            "remove" === t.event ? layer.confirm(__("确定把此单页面放入回收站？"),
                function (index) {
                    admin.req({
                        url: layui.setter.prefix + 'page/remove'
                        , data: {'_token': token, 'id': e.id}
                        , type: 'post'
                        , done: function (res) {
                            layer.msg(__('放入回收站成功'), {
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
                title: __("编辑单页面"),
                content: layui.setter.prefix + 'page/' + e.id + '/edit',
                maxmin: !0,
                area: window.layerArea,
                btn: [__("确定"), __("取消")],
                yes: function (index, layero) {
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                    submit.click();
                }
            })
        })

    table.on("tool(LAY-app-content-trash-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "del":
                    layer.confirm(__("永久删除此单页面？"),
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'page/' + e.id
                                , data: {'_token': token}
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg(__('单页面删除成功'), {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.treeTable.reload('LAY-app-content-trash-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
                case "restore":
                    layer.confirm(__("确定恢复此单页面？"),
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'page/restore/' + e.id
                                , type: 'get'
                                , done: function (res) {
                                    layer.msg(__('恢复单页面成功'), {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.treeTable.reload('LAY-app-content-trash-list');
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
                url: layui.setter.prefix + 'page'
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
                url: layui.setter.prefix + 'page/' + id
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
                        parent.layui.treeTable.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

});
