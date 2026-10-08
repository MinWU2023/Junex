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

    // 表格渲染，带初始筛选参数
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'admin/log',
        cols: [[
            {
                field: "path",
                title: "path"
            },
            {
                field: "name",
                title: "操作名"
            },
            {
                field: "ip",
                title: "ip"
            },
            {
                templet: '<div>{{ d.user.name }}</div>',
                title: "操作人"
            },
            {
                field: "created_at",
                title: "创建时间"
            },
            {
                title: "操作",
                minWidth: 150,
                align: "center",
                toolbar: "#table-content-list"
            }
        ]],
        page: !0,
        where: {
            path: $('#path').val(),
            user_id: $('#user_id').val(),
            ip: $('#ip').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
    });

    // 工具条事件
    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "show":
                    layer.open({
                        type: 1,
                        title: "request详细信息",
                        content: e.content,
                        maxmin: !0,
                        area: window.layerArea,
                    });
                    break;
            }
        })

    // 搜索按钮事件
    var active = {
        reload: function () {
            var path = $('#path').val()
            var user_id = $('#user_id').val()
            var ip = $('#ip').val()
            table.reload('LAY-app-content-list', {
                page: {curr: 1},
                where: {
                    path: path,
                    user_id: user_id,
                    ip: ip
                }
            })
        }
    }

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type')
        active[type] && active[type].call(this)
    })

});
