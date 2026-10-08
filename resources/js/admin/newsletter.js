layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index',
    excel: 'layui_exts/excel'
}).use(['index', 'table', 'form','excel','laydate'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$;
    var laydate = layui.laydate;
    laydate.render({
        elem: '#start_time' //指定元素
        ,format:'yyyy-MM-dd 00:00:00'
        // ,range:true
        // ,format:'yyyyMMdd'
    });
    laydate.render({
        elem: '#end_time' //指定元素
        ,format:'yyyy-MM-dd 23:59:59'
    });
    var token = $('#token').val();
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'newsletter',
        cols: [[
            {
                type: 'checkbox',
            },
            // {
            //     field: "id",
            //     width: 100,
            //     title:'ID'
            // },
            {
                field: "email",
                title: "email"
            },
            {
                field: "created_at",
                title: "订阅时间"
            },
            {
                title: "操作",
                align: "center",
                toolbar: "#table-content-list"
            }
            ]],
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
    });


    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });


    active = {
        exportSelected: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定导出选中邮箱？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'newsletter/export'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('导出成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                var myDate = new Date();
                                layui.excel.exportExcel(res.data, '订阅' + myDate.getTime() + '导出.xlsx', 'xlsx')
                                window.canAjax = true
                                layer.close(loading);
                            });

                        }
                    });
                }
            })
        },

        exportAll: function () { //获取选中数据
            layer.confirm("确定导出所有邮箱？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'newsletter/export'
                        , type: 'post'
                        , data: {ids: null, _token: token}
                        , done: function (res) {
                            layer.msg('导出成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                var myDate = new Date();
                                layui.excel.exportExcel(res.data, '订阅' + myDate.getTime() + '导出.xlsx', 'xlsx')
                                window.canAjax = true
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

        reload: function () {
            var search_q = $("#search_q").val()
            var start_time = $("#start_time").val()
            var end_time = $("#end_time").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    email: search_q,
                    start_time: start_time,
                    end_time: end_time
                }
            });
        },
    };



    table.on("tool(LAY-app-content-list)",
        function(t) {
            var e = t.data;
            switch (t.event) {
                case 'del':
                    layer.confirm("确定删除此news letter？",
                        function(index) {
                            admin.req({
                                url: layui.setter.prefix + 'newsletter/' + e.id
                                ,data: { '_token': token}
                                ,type: 'delete'
                                ,done: function(res){
                                    layer.msg('删除成功', {
                                        offset: '15px'
                                        ,icon: 1
                                        ,time: 1000
                                    }, function(){
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
