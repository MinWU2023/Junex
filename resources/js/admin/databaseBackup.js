layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form'], function () {
    var table = layui.table
    var admin = layui.admin
    var form = layui.form
    var $ = layui.$
    var token = $('#token').val()

    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'databaseBackup',
        cols: [[
            {field: "id", title: "ID", width: 80},
            {field: "filename", title: "文件名", minWidth: 220},
            {field: "file_size_human", title: "大小", width: 110},
            {
                field: "type",
                title: "类型",
                width: 90,
                templet: function (d) {
                    return d.type === 'manual' ? '手动' : '自动'
                }
            },
            {
                field: "status",
                title: "状态",
                width: 90,
                templet: function (d) {
                    if (d.status === 'success') {
                        return '<span class="layui-badge layui-bg-green">成功</span>'
                    }
                    return '<span class="layui-badge">失败</span>'
                }
            },
            {field: "message", title: "备注", minWidth: 160},
            {field: "created_at", title: "备份时间", width: 170},
            {
                title: "操作",
                minWidth: 180,
                align: "center",
                toolbar: "#table-content-list"
            }
        ]],
        page: true,
        where: {
            status: $('#status').val(),
            type: $('#type').val()
        },
        limit: 15,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！"
    })

    table.on("tool(LAY-app-content-list)", function (obj) {
        var data = obj.data
        switch (obj.event) {
            case "download":
                window.location.href = layui.setter.prefix + 'databaseBackup/' + data.id + '/download'
                break
            case "del":
                layer.confirm('确定删除该备份记录及文件吗？', function (index) {
                    var loading = layer.load()
                    admin.req({
                        url: layui.setter.prefix + 'databaseBackup/' + data.id,
                        type: 'delete',
                        data: {_token: token},
                        done: function () {
                            layer.close(loading)
                            layer.msg('删除成功', {icon: 1, time: 1000}, function () {
                                table.reload('LAY-app-content-list')
                            })
                        },
                        error: function () {
                            layer.close(loading)
                        }
                    })
                    layer.close(index)
                })
                break
        }
    })

    var active = {
        reload: function () {
            table.reload('LAY-app-content-list', {
                page: {curr: 1},
                where: {
                    status: $('#status').val(),
                    type: $('#type').val()
                }
            })
        },
        backup: function () {
            layer.confirm('确定立即执行一次全量数据库备份吗？', function (index) {
                var loading = layer.load(1, {shade: 0.2})
                admin.req({
                    url: layui.setter.prefix + 'databaseBackup',
                    type: 'post',
                    data: {_token: token},
                    done: function (res) {
                        layer.close(loading)
                        layer.msg(res.message || '备份成功', {icon: 1, time: 1200}, function () {
                            table.reload('LAY-app-content-list')
                        })
                    },
                    error: function () {
                        layer.close(loading)
                    }
                })
                layer.close(index)
            })
        }
    }

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type')
        active[type] && active[type].call(this)
    })

    form.render('select')
})
