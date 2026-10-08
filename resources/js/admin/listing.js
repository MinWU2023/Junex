layui.config({
    base: '/ui/',
}).extend({
    index: 'lib/index',
    excel: 'layui_exts/excel'
}).use(['index', 'table', 'form', 'laydate', 'excel'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    var laydate = layui.laydate;

    laydate.render({
        elem: '#start_time' //指定元素
        // ,range:true
        // ,format:'yyyyMMdd'
    });
    laydate.render({
        elem: '#end_time' //指定元素
    });
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'listing',

        cols: [[
            // {
            //     field: "id",
            //     width: 100,
            //     title: "询盘ID",
            //     // sort: !0
            // },
            {
                field: "title",
                width: 200,
                title: "标题"
            },
            {
                templet: '<div>{{ d.ip }}（{{ d.location }}）</div>',
                align: 'left',
                width: 200,
                title: 'ip'
            },
            {
                field: "client",
                width: 100,
                title: "客户端"
            },
            {
                field: 'email',
                width: 200,
                title: "邮箱"
            },
            {
                field: 'msg_country',
                title: "国家"
            },

            {
                field: "created_at",
                title: "时间"
            },
            {
                templet: '#is_read',
                align: 'left',
                width: 100,
                title: '查看状态'
            },
            {
                field: "send_emails",
                title: "已通知邮箱"
            },
            {
                title: "操作",
                minWidth: 300,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！",
    });



    $('.layui-layer-btn0').on('click', function () {
        $('#form1').submit()
    })
    $('.layui-layer-btn1').on('click', function () {
        $('#content').val('')
    })

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });


    active = {
        reload: function () {
            var inquiry_cate = $("#inquiry_cate option:selected").val()
            var search_q = $("#search_q").val()
            var start_time = $("#start_time").val()
            var end_time = $("#end_time").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    cate: inquiry_cate,
                    search_q: search_q,
                    start_time: start_time,
                    end_time: end_time
                }
            });
        },
    };

    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "del":
                    layer.confirm("确定将此询盘放入回收站？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'inquiry/remove'
                                , data: {'_token': token, 'id': e.id}
                                , type: 'post'
                                , done: function (res) {
                                    layer.msg('放入回收站成功', {
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
                case "edit":
                    layer.open({
                        type: 2,
                        title: "绑定管理员",
                        content: layui.setter.prefix + 'inquiry/editUser/' + e.id,
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    });
                    break;
                case "show":
                    layer.open({
                        type: 2,
                        title: "询盘详细信息",
                        content: layui.setter.prefix + 'inquiry/' + e.id,
                        maxmin: !0,
                        area: window.layerArea,
                        success: function () {
                            $('.layui-layer').addClass('myInquiry');
                        }
                    });
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
                url: layui.setter.prefix + 'inquiry/updateUser/' + id
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
