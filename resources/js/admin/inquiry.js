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
    let is_admin = $("#is_admin").val();
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
    // 构建列配置
    var cols = [[
        {
            type: 'checkbox',
        },

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
            width: 200,
            title: "时间"
        },
        {
            templet: '#is_read',
            align: 'left',
            width: 80,
            title: '查看状态'
        },
        {
            field: "send_emails",
            title: "已通知邮箱"
        }]];

    // 只有管理员才显示垃圾指数分列
    if (parseInt(is_admin) === 1) {
        cols[0].push({
            field: "gibberish_score",
            width: 120,
            title: "垃圾指数分",
            templet: '#gibberish_score',
        });
    }

    cols[0].push({
        title: "操作",
        minWidth: 300,
        align: "center",
        toolbar: "#table-content-list"
    });

    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'inquiry',
        cols: cols,
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！",
    });

    table.render({
        elem: "#LAY-app-content-trash-list",
        url: layui.setter.prefix + 'inquiry/trash',

        cols: [[
            {
                type: 'checkbox',
            },
            {
                field: "title",
                title: "标题"
            },
            {
                templet: '<div>{{ d.ip }}（{{ d.location }}）</div>',
                align: 'left',
                width: 300,
                title: 'ip'
            },
            {
                field: "client",
                title: "客户端"
            },
            {
                field: 'email',
                width: 300,
                title: "邮箱"
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
                title: "操作",
                minWidth: 300,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
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
        multipleRemove: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定删除所选询盘？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/multipleRemove'
                        , type: 'delete'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('批量删除成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                window.canAjax = true
                                layui.table.reload('LAY-app-content-list');
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

        exportSelected: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定导出选中询盘？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/export'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('导出成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                var myDate = new Date();
                                layui.excel.exportExcel(res.data, '询盘' + myDate.getTime() + '导出.xlsx', 'xlsx')
                                window.canAjax = true
                                layer.close(loading);
                            });

                        }
                    });
                }
            })
        },

        exportAll: function () { //获取选中数据
            layer.confirm("确定导出所有询盘？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/export'
                        , type: 'post'
                        , data: {ids: null, _token: token}
                        , done: function (res) {
                            layer.msg('导出成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                var myDate = new Date();
                                layui.excel.exportExcel(res.data, '询盘' + myDate.getTime() + '导出.xlsx', 'xlsx')
                                window.canAjax = true
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

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

        showHighRisk: function () {
            //执行重载，显示超过阈值的垃圾询盘
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    show_high_risk: 1
                }
            });
            // 切换按钮显示
            $('#showHighRiskBtn').hide();
            $('#showNormalBtn').show();
        },

        showNormal: function () {
            //执行重载，返回正常视图
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    show_high_risk: 0
                }
            });
            // 切换按钮显示
            $('#showHighRiskBtn').show();
            $('#showNormalBtn').hide();
        },

        multipleRestore: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-trash-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定把选中的询盘进行恢复操作吗？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/multipleRestore'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('批量恢复询盘成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                window.canAjax = true
                                layui.table.reload('LAY-app-content-trash-list');
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

        multipleDestroy: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-trash-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定把选中的询盘彻底删除吗？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/multipleDestroy'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('批量删除询盘成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                window.canAjax = true
                                layui.table.reload('LAY-app-content-trash-list');
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

        setValidInquiry: function () { //批量设置为有效询盘
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定将选中的询盘设置为有效询盘吗？（垃圾指数分将设为0）", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/setValidInquiry'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('批量设置为有效询盘成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                window.canAjax = true
                                layui.table.reload('LAY-app-content-list');
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

        setSpamInquiry: function () { //批量设置为垃圾询盘
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定将选中的询盘设置为垃圾询盘吗？（垃圾指数分将设为100）", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'inquiry/setSpamInquiry'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('批量设置为垃圾询盘成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                window.canAjax = true
                                layui.table.reload('LAY-app-content-list');
                                layer.close(loading);
                            });
                        }
                    });
                }
            })
        },

    };


    table.on("tool(LAY-app-content-trash-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {

                case "restore":
                    layer.confirm("确定恢复此询盘？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'inquiry/restore/' + e.id
                                , type: 'get'
                                , done: function (res) {
                                    layer.msg('恢复询盘成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-trash-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;

                case "remove":
                    layer.confirm("永久删除此询盘？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'inquiry/' + e.id
                                , data: {'_token': token}
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg('询盘删除成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-trash-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
            }
        })

    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "gibberish_score":
                    // 只有管理员才能查看垃圾检测详情
                    if (parseInt(is_admin) === 1) {
                        showGibberishDetails(e.gibberish_score || 0, e.gibberish_details || []);
                    }
                    break;
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

// 显示垃圾检测详情的函数
function showGibberishDetails(score, details) {
    // 如果评分为0分，显示有效询盘提示
    if (score === 0) {
        var layer = layui.layer;
        try {
            layer.open({
                type: 1,
                title: '垃圾检测详情 - 有效询盘',
                area: ['400px', '200px'],
                content: '<div style="padding: 20px; text-align: center; color: #5FB878;"><i class="layui-icon layui-icon-ok" style="font-size: 24px; margin-right: 10px;"></i><span style="font-size: 16px;">此询盘内容安全，无垃圾信息风险</span></div>',
                btn: ['关闭'],
                yes: function(index, layero) {
                    layer.close(index);
                }
            });
        } catch (e) {
            alert('此询盘内容安全，无垃圾信息风险');
        }
        return;
    }

    var layer = layui.layer;

    // 构建详情内容
    var detailsHtml = '';
    if (details && details.length > 0) {
        detailsHtml = '<div style="padding: 15px; line-height: 1.6;"><h3 style="margin-bottom: 15px; color: #333;">垃圾检测详情：</h3><ul style="margin: 0; padding-left: 20px;">';
        details.forEach(function(detail) {
            detailsHtml += '<li style="margin: 8px 0; color: #666;">' + detail + '</li>';
        });
        detailsHtml += '</ul></div>';
    } else {
        detailsHtml = '<div style="padding: 15px; text-align: center; color: #999;"><p>暂无检测详情</p></div>';
    }

    try {
        layer.open({
            type: 1,
            title: '垃圾检测详情 - 评分: ' + score,
            area: ['500px', '400px'],
            content: detailsHtml,
            btn: ['关闭'],
            yes: function(index, layero) {
                layer.close(index);
            }
        });
    } catch (e) {
        // 如果 layer.open 失败，使用 alert 作为备选方案
        var message = '评分: ' + score + '\n\n检测详情:\n';
        if (details && details.length > 0) {
            message += details.join('\n');
        } else {
            message += '暂无检测详情';
        }
        alert(message);
    }
}
