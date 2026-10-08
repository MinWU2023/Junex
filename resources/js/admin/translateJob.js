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
        url: layui.setter.prefix + 'translateJob',
        cols: [[
            {
                field: "id",
                width: 100,
                title: "Id"
            },
            {
                field: "model",
                width: 400,
                title: "模型"
            },
            {
                field: "source_id",
                width: 100,
                title: "模型id"
            },
            {
                field: "field",
                width: 100,
                title: "翻译字段"
            },
            {
                field: "translate_locales",
                width: 200,
                title: "翻译语种"
            },
            {
                title: "翻译状态",
                templet: "#status"
            },
            {
                field: "error_at",
                width: 150,
                title: "翻译异常时间"
            },
            {
                field: "created_at",
                width: 200,
                title: "创建时间"
            },
            // {
            //     title: "操作",
            //     minWidth: 150,
            //     align: "center",
            //     // toolbar: "#table-content-list"
            // }
        ]],
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！",
    });
    active = {
        reload: function () {
            var source_id = $("#source_id").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    source_id: source_id
                }
            });
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
                case 'show':
                    if (e.status === 1){
                        layer.open({
                            title:'翻译内容',
                            type: 1,
                            content: e.result_content, //这里content是一个普通的String
                            area: '500px'
                        });
                    }else{
                        layer.open({
                            title:'翻译内容',
                            type: 1,
                            content: e.error_msg, //这里content是一个普通的String
                            area: '500px'
                        });
                    }

                    break;
            }
        })
});
