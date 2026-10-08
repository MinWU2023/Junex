layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table'], function () {
    var table = layui.table
    admin = layui.admin;
    var $ = layui.$
    var token = $('#token').val()
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'url',
        cols: [[
            {
                templet: '<div><a target="_blank" href="/{{d.url}}">{{ d.id }}</a></div>',
                width: 100,
                title: "ID",
            },
            {
                // templet: '<div><a target="_blank" href="/{{d.url}}">{{ d.url }}</a></div>',
                field: "url",
                width: 400,
                title: "url"
            },

            {
                templet: '<div>{{ d.type }}({{ d.urlable_id }})</div>',
                width: 200,
                title: "类型(id)"
            },
            {
                templet: '#is_main',
                align: 'left',
                title: "是否301链接"
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
            url: $('#url').val(),
            urlable_type: $('#urlable_type').val(),
            urlable_id:$("#urlable_id").val()
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！",
    });


    active = {
        reload: function () {
            let url = $("#url").val()
            let urlable_type = $("#urlable_type").val()
            let urlable_id = $("#urlable_id").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    url: url,
                    urlable_type: urlable_type,
                    urlable_id:urlable_id
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
                case 'del':
                    layer.confirm("确定删除该301链接？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'url/' + e.id
                                , data: {'_token': token}
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
            }
        })
});
