layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'laydate'], function () {
    var table = layui.table
    admin = layui.admin, form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    var laydate = layui.laydate;
    // 年月范围
    laydate.render({
        elem: "#laydate-shortcut-month",
        type: "month",
        shortcuts: [
            {
                text: "上个月",
                value: function(){
                    var now = new Date();
                    now.setMonth(now.getMonth() - 1);
                    return now;
                }()
            },
            {
                text: "下个月",
                value: function(){
                    var now = new Date();
                    now.setMonth(now.getMonth() + 1);
                    return now;
                }()
            },
            {
                text: "去年12月",
                value: function(){
                    var now = new Date();
                    now.setMonth(11);
                    now.setFullYear(now.getFullYear() - 1);
                    return now;
                }()
            }
        ],
        format:"yyyyMM"
    });

    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'keywordRank',
        cols: [[
            {
                field: "id",
                title: "Id",
            },
            {
                field: "name",
                title: "关键词",
            },
            {
                templet: '<div><a target="_blank" href="{{d.discrepancy.catch_url}}">{{ d.discrepancy.catch_url }}</a></div>',
                width: 400,
                title: "排名url"
            },
            {field: 'current_rank', width: 160, title: '谷歌排名', templet: '#table-rank'},
            {
                field: "check_date",
                title: "更新时间"
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
        text: "对不起，加载出现异常！",
    });


    active = {
        reload:function (){
            var name =  $("#name").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    name: name,
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
                    layer.open({
                        type: 2,
                        title: "查看历史排名详情",
                        content: layui.setter.prefix + 'product/tagRank/' + e.id,
                        maxmin: !0,
                        area: window.layerArea
                    })
                    break;
            }
        })
});
