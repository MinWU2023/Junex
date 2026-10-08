layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'uploadLaravel', 'productFileUpload', 'laydate'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var laydate = layui.laydate;
    laydate.render({
        elem: '#customer_at', //指定元素
        type: "datetime"
    });
    let is_admin = $("#is_admin").val();
    let table_cols = [[
        {
            type: 'checkbox',
        },
        {
            templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
            // field: "name",
            width: 400,
            title: "文章标题"
        },
        {
            templet: '<div>{{ d.article_category.name }}</div>',
            align: 'left',
            width: 400,
            title: '所属分类'
        },
        {
            field: "sort",
            title: "排序",
            templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
            edit: 'number'
        },
        {
            field: "is_show",
            title: "是否显示",
            templet: "#is_show"
        },
        {
            field: "is_menu",
            title: "是否导航",
            templet: "#is_menu"
        },
        {
            title: "操作",
            width: 200,
            align: "center",
            toolbar: "#table-content-list"
        }]]
    if (is_admin) {
        table_cols = [[
            {
                type: 'checkbox',
            },
            {
                templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.id }}</a></div>',
                align: 'left',
                width: 100,
                title: '文章ID'
            },
            {
                templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
                // field: "name",
                width: 400,
                title: "文章标题"
            },
            {
                templet: '<div>{{ d.article_category.name }}</div>',
                align: 'left',
                width: 400,
                title: '所属分类'
            },
            {
                field: "sort",
                title: "排序",
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
                edit: 'number'
            },
            {
                field: "is_show",
                title: "是否显示",
                templet: "#is_show"
            },
            {
                field: "is_menu",
                title: "是否导航",
                templet: "#is_menu"
            },
            {
                title: "操作",
                width: 230,
                align: "center",
                toolbar: "#table-content-list"
            }]]
    }
    var token = $('#token').val()
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'article',
        cols: table_cols,
        page: !0,
        where: {
            name: $('#name').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！！",
    });

    table.render({
        elem: "#LAY-app-content-draft-list",
        url: layui.setter.prefix + 'article/draft',
        cols: [[
            {
                field: "id",
                align: 'left',
                width: 100,
                title: '文章ID'
            },
            {
                field: "name",
                width: 400,
                title: "文章标题"
            },
            {
                field: "is_show",
                title: "是否显示",
                templet: "#is_show"
            },
            {
                field: "is_menu",
                title: "是否导航",
                templet: "#is_menu"
            },
            {
                field: "scheduled_publish_at",
                title: "自动发布",
                width: 180,
                templet: "#scheduled_publish"
            },
            {
                title: "操作",
                width: 230,
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

    // 监听页面可见性变化，当页面重新获得焦点时检查是否需要刷新
    if (document.getElementById('LAY-app-content-draft-list')) {
        $(window).on('focus', function () {
            if (localStorage.getItem('needReloadArticleDraftList') === 'true') {
                localStorage.removeItem('needReloadArticleDraftList');
                layui.table.reload('LAY-app-content-draft-list');
            }
        });

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden && localStorage.getItem('needReloadArticleDraftList') === 'true') {
                localStorage.removeItem('needReloadArticleDraftList');
                layui.table.reload('LAY-app-content-draft-list');
            }
        });
    }


    table.on('edit(LAY-app-content-list)', function (obj) {
        var value = ~~obj.value.replace(/^(0*)|\D/g, '') //得到修改后的值
            , sendData = {};
        sendData.sort = value;
        sendData.type = 'article_sort';
        sendData._token = token;
        obj.data.sort = value;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'article/change_property/' + obj.data.id
            , type: 'put'
            , data: sendData
            , done: function (res) {
                layer.msg('修改成功', {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    layer.close(loading);
                    // layui.table.reload('LAY-app-content-list');
                });
            }
        });
    });

    table.render({
        elem: "#LAY-app-content-trash-list",
        url: layui.setter.prefix + 'article/trash',
        cols: [[
            // {
            //     field: "id",
            //     width: 100,
            //     title: "文章ID",
            //     // sort: !0
            // },
            {
                type: 'checkbox',
            },
            {
                field: "name",
                title: "文章标题"
            },
            {
                templet: '<div>{{ d.article_category.name }}</div>',
                align: 'left',
                title: '所属分类'
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
        where: {
            name: $('#name').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！",
    });
    active = {
        reload: function () {
            var category = $("[name='article_category_id']")
            var search_name = $("#search_name").val()
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    category_id: category.val(),
                    name: search_name
                }
            });
        },
        reload_draft: function () {
            var category = $("[name='article_category_id']")
            var search_name = $("#search_name").val()
            //执行重载
            table.reload('LAY-app-content-draft-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    category_id: category.val(),
                    name: search_name
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
        multipleRestore: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-trash-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定把选中的文章进行恢复操作吗？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'article/multipleRestore'
                        , type: 'post'
                        , data: { ids: ids, _token: token }
                        , error: function (e) {
                            layer.close(loading)
                            window.canAjax = true
                        }
                        , done: function (res) {
                            layer.msg('批量恢复文章成功', {
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
            layer.confirm("确定把选中的文章彻底删除吗？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'article/multipleDestroy'
                        , type: 'post'
                        , data: { ids: ids, _token: token }
                        , error: function (e) {
                            layer.close(loading)
                            window.canAjax = true
                        }
                        , done: function (res) {
                            layer.msg('批量删除文章成功', {
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
        multipleMoveTrash: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定把选中的文章放入回收站吗？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'article/multipleMoveTrash'
                        , type: 'post'
                        , data: { ids: ids, _token: token }
                        , error: function (e) {
                            layer.close(loading)
                            window.canAjax = true
                        }
                        , done: function (res) {
                            layer.msg('放入回收站成功', {
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
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: '添加文章'
                , content: '/' + window.admin_prefix + '/article/create'
                , maxmin: true
                , area: window.layerArea
                , btn: ['发布', '保存草稿', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var form = layero.find('iframe').contents().find("form");
                    form.find('input[name="action"]').val('publish');
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
                , btn2: function (index, layero) {
                    // 保存草稿
                    var form = layero.find('iframe').contents().find("form");
                    form.find('input[name="action"]').val('draft');
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                    submit.click();
                    return false;
                }
                , btn3: function (index, layero) {
                    let body = layer.getChildFrame('body', index);
                    let temp_model_id = body.find("#temp_model_id").val()
                    admin.req({
                        url: layui.setter.prefix + 'tempArticle/' + temp_model_id + '/delete'
                        , data: { '_token': token }
                        , type: 'delete'
                    });
                }
                , cancel: function (index, layero) {
                    let body = layer.getChildFrame('body', index);
                    let temp_model_id = body.find("#temp_model_id").val()
                    admin.req({
                        url: layui.setter.prefix + 'tempArticle/' + temp_model_id + '/delete'
                        , data: { '_token': token }
                        , type: 'delete'
                    });
                }
            });
        }
    };


    $(document).on('visibilitychange', function () {
        if (document.visibilityState !== 'visible') {
            let temp_model_id = $("#temp_model_id").val();
            let switch_editor = $("#switch_editor").val()
            if (switch_editor == 1) {
                var moreUedit = $('.tinymce_content');
                moreUedit.each(function () {
                    let id = $(this).attr('id');
                    document.getElementById(id).value = tinymce.get(id).getContent();
                })
            }
            let data = form.val("layuiadmin-form-tags");
            if (temp_model_id > 0) {
                $.ajax({
                    type: "post",
                    url: '/' + window.admin_prefix + '/tempArticle/' + temp_model_id + '/preview',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    dataType: 'json',
                    data: data,
                })
            }
        }
    });

    $("#preview_model").click(function () {
        if (window.canAjax) {
            window.canAjax = false
            var loading = layer.load();
            let temp_model_id = $("#temp_model_id").val();
            let switch_editor = $("#switch_editor").val()
            if (switch_editor == 1) {
                var moreUedit = $('.tinymce_content');
                moreUedit.each(function () {
                    let id = $(this).attr('id');
                    document.getElementById(id).value = tinymce.get(id).getContent();
                })
            }
            let data = form.val("layuiadmin-form-tags");
            $.ajax({
                type: "post",
                url: '/' + window.admin_prefix + '/tempArticle/' + temp_model_id + '/preview',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                dataType: 'json',
                data: data,
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
            switch (t.event) {
                case 'article_show':
                case 'article_menu':
                    admin.req({
                        url: layui.setter.prefix + 'article/change_property/' + e.id
                        , type: 'put'
                        , data: { '_token': token, 'type': t.event }
                        , done: function (res) {
                            layer.msg('操作成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            }, function () {
                                layui.table.reload('LAY-app-content-list');
                                layer.close(index)
                            });
                        }
                    });
                    break;
                case 'remove':
                    layer.confirm("确定把此文章放入回收站？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'article/remove'
                                , data: { '_token': token, 'id': e.id }
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
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑文章",
                        content: layui.setter.prefix + 'article/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["确定", "取消"],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                        }
                    })
                    break;
            }
        })

    table.on("tool(LAY-app-content-draft-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case 'article_show':
                case 'article_menu':
                    admin.req({
                        url: layui.setter.prefix + 'article/change_property/' + e.id
                        , type: 'put'
                        , data: { '_token': token, 'type': t.event }
                        , done: function (res) {
                            switch (t.event) {
                                case 'article_show':
                                    t.update({
                                        is_show: !e.is_show
                                    });
                                    break;
                                case 'article_menu':
                                    t.update({
                                        is_menu: !e.is_menu
                                    });
                                    break;
                            }
                            layer.msg('操作成功', {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            });
                        }
                    });
                    break;
                case "del":
                    layer.confirm("确定要删除此草稿，删除后将无法恢复！",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'article/draft/destroy/' + e.id
                                , data: { '_token': token, 'id': e.id }
                                , type: 'post'
                                , done: function (res) {
                                    layer.msg('删除成功', {
                                        offset: '15px'
                                        , icon: 1
                                        , time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-draft-list');
                                        layer.close(index)
                                    });
                                }
                            });
                        })
                    break;
                case "edit":
                    layer.open({
                        type: 2,
                        title: "编辑草稿文章",
                        content: layui.setter.prefix + 'article/draft/' + e.id + '/edit',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: ["保存", "发布"],
                        yes: function (index, layero) {
                            //点击确认触发 iframe 内容中的按钮提交
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                            submit.click();
                            return false;
                        }
                        , btn2: function (index, layero) {
                            // 保存草稿
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-publish-form-submit");
                            submit.click();
                            return false;
                        },
                    })
                    break;
                case "set_schedule":
                    // 显示日期时间选择器
                    layer.open({
                        type: 1,
                        title: __('设置自动发布时间'),
                        area: ['500px', '350px'],
                        content: '<div style="padding: 20px;">' +
                            '<div class="layui-form-item">' +
                            '<label class="layui-form-label">' + __('发布时间') + '</label>' +
                            '<div class="layui-input-block">' +
                            '<input type="text" id="scheduled_datetime" class="layui-input" placeholder="' + __('格式：2026-02-06 15:30:00') + '">' +
                            '</div></div>' +
                            '<hr />' +
                            '<div style="background: #fff3f3; border: 1px solid #ffccc7; padding: 15px; margin-bottom: 20px; border-radius: 4px;">' +
                            '<div style="color: #ff4d4f; font-size: 14px; line-height: 24px;">' +
                            '<strong style="font-size: 15px;">⚠️ 设置定时发布前，请确保以下必填项已完成：</strong><br>' +
                            '• 文章分类<br>' +
                            '• 文章标题<br>' +
                            '• 文章内容' +
                            '</div></div>' +
                            '</div>',
                        success: function (layero, index) {
                            var now = new Date();
                            var minDate = now.getFullYear() + '-'
                                + String(now.getMonth() + 1).padStart(2, '0') + '-'
                                + String(now.getDate()).padStart(2, '0') + ' '
                                + String(now.getHours()).padStart(2, '0') + ':'
                                + String(now.getMinutes()).padStart(2, '0') + ':'
                                + String(now.getSeconds()).padStart(2, '0');
                            // 初始化日期时间选择器
                            laydate.render({
                                elem: '#scheduled_datetime',
                                type: 'datetime',
                                format: 'yyyy-MM-dd HH:mm:ss',
                                min: minDate,
                                value: e.scheduled_publish_at || '',
                                trigger: 'click', // 点击图标触发
                                done: function (value, date) {
                                    // 选择完成后的回调
                                }
                            });
                        },
                        btn: [__('保存'), __('清除'), __('取消')],
                        btn2: function (index, layero) {
                            // 清除定时
                            admin.req({
                                url: layui.setter.prefix + 'article/draft/schedule/' + e.id,
                                type: 'delete',
                                data: { '_token': token },
                                done: function (res) {
                                    layer.msg(__('已清除定时发布'), {
                                        offset: '15px',
                                        icon: 1,
                                        time: 1000
                                    }, function () {
                                        layui.table.reload('LAY-app-content-draft-list');
                                        layer.close(index);
                                    });
                                }
                            });
                            return false;
                        },
                        yes: function (index, layero) {
                            var datetime = $('#scheduled_datetime').val();
                            if (!datetime) {
                                layer.msg(__('请选择日期时间'));
                                return false;
                            }

                            // 使用原生Ajax来完全控制响应处理
                            $.ajax({
                                url: layui.setter.prefix + 'article/draft/schedule/' + e.id,
                                type: 'POST',
                                data: {
                                    '_token': token,
                                    'publish_at': datetime
                                },
                                dataType: 'json',
                                success: function (res) {
                                    if (res.code === 0) {
                                        layer.msg(__('设置成功'), {
                                            offset: '15px',
                                            icon: 1,
                                            time: 1000
                                        }, function () {
                                            layui.table.reload('LAY-app-content-draft-list');
                                            layer.close(index);
                                        });
                                    } else {
                                        // 处理验证错误
                                        var errorMsg = '<div style="font-size: 15px; margin-bottom: 10px; font-weight: 500;">' + (res.msg || __('设置失败')) + '</div>';
                                        if (res.errors && res.errors.length > 0) {
                                            errorMsg += '<div style="color: #ff4d4f; line-height: 28px; margin-top: 15px; font-size: 14px;">';
                                            errorMsg += '• ' + res.errors.join('<br>• ');
                                            errorMsg += '</div>';
                                        }
                                        layer.open({
                                            type: 1,
                                            title: __('提示'),
                                            area: ['450px', 'auto'],
                                            content: '<div style="padding: 20px;">' + errorMsg + '</div>',
                                            btn: [__('去完善'), __('关闭')],
                                            yes: function (alertIndex) {
                                                // 跳转到编辑页面
                                                layer.close(alertIndex);
                                                layer.close(index);
                                                layer.open({
                                                    type: 2,
                                                    title: "编辑草稿文章",
                                                    content: layui.setter.prefix + 'article/draft/' + e.id + '/edit',
                                                    maxmin: !0,
                                                    area: window.layerArea,
                                                    btn: ["保存", "发布"],
                                                    yes: function (index, layero) {
                                                        //点击确认触发 iframe 内容中的按钮提交
                                                        var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                                                        submit.click();
                                                        return false;
                                                    }
                                                    , btn2: function (index, layero) {
                                                        // 保存草稿
                                                        var submit = layero.find('iframe').contents().find("#layuiadmin-app-publish-form-submit");
                                                        submit.click();
                                                        return false;
                                                    },
                                                })
                                            },
                                            btn2: function (alertIndex) {
                                                layer.close(alertIndex);
                                            }
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    // 处理HTTP错误（包括422验证错误）
                                    try {
                                        var res = JSON.parse(xhr.responseText);
                                        if (res.code === 1 && res.errors) {
                                            var errorMsg = '<div style="font-size: 15px; margin-bottom: 10px; font-weight: 500;">' + (res.msg || __('设置失败')) + '</div>';
                                            errorMsg += '<div style="color: #ff4d4f; line-height: 28px; margin-top: 15px; font-size: 14px;">';
                                            errorMsg += '• ' + res.errors.join('<br>• ');
                                            errorMsg += '</div>';
                                            layer.open({
                                                type: 1,
                                                title: __('提示'),
                                                area: ['450px', 'auto'],
                                                content: '<div style="padding: 20px;">' + errorMsg + '</div>',
                                                btn: [__('去完善'), __('关闭')],
                                                yes: function (alertIndex) {
                                                    layer.close(alertIndex);
                                                    layer.close(index);

                                                    layer.open({
                                                        type: 2,
                                                        title: "编辑草稿文章",
                                                        content: layui.setter.prefix + 'article/draft/' + e.id + '/edit',
                                                        maxmin: !0,
                                                        area: window.layerArea,
                                                        btn: ["保存", "发布"],
                                                        yes: function (index, layero) {
                                                            //点击确认触发 iframe 内容中的按钮提交
                                                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                                                            submit.click();
                                                            return false;
                                                        }
                                                        , btn2: function (index, layero) {
                                                            // 保存草稿
                                                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-publish-form-submit");
                                                            submit.click();
                                                            return false;
                                                        },
                                                    })
                                                },
                                                btn2: function (alertIndex) {
                                                    layer.close(alertIndex);
                                                }
                                            });
                                        } else {
                                            layer.msg(res.msg || __('设置失败'), { icon: 2 });
                                        }
                                    } catch (e) {
                                        console.error('解析错误响应失败:', e, xhr.responseText);
                                        layer.msg(__('设置失败，请检查网络连接'), { icon: 2 });
                                    }
                                }
                            });
                        }
                    });
                    break;
            }
        })

    table.on("tool(LAY-app-content-trash-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "del":
                    layer.confirm("永久删除此文章？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'article/' + e.id
                                , data: { '_token': token }
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg('文章删除成功', {
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
                case "restore":
                    layer.confirm("确定恢复此文章？",
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'article/restore/' + e.id
                                , type: 'get'
                                , done: function (res) {
                                    layer.msg('恢复文章成功', {
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

    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            let data_val = data.field;
            data_val['_token'] = token;
            // 检查是否是保存草稿操作
            var isDraft = data_val.action === 'draft';
            admin.req({
                url: layui.setter.prefix + 'article'
                , type: 'post'
                , data: data_val
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    var successMsg = isDraft ? '保存草稿成功' : '添加成功';
                    layer.msg(successMsg, {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        parent.layer.close(index); //关闭弹窗
                        if (isDraft) {
                            // 如果是保存草稿，打开草稿箱页面
                            top.layui.index.openTabsPage(layui.setter.prefix + 'article/draft', '文章草稿箱');
                        } else {
                            // 如果是发布，重载文章列表
                            parent.layui.table.reload('LAY-app-content-list');
                        }
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
                url: layui.setter.prefix + 'article/' + id
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
                        if (parent.$('#LAY-app-content-list').length > 0) {
                            parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        }
                        if (parent.$('#LAY-app-content-draft-list').length > 0) {
                            parent.layui.table.reload('LAY-app-content-draft-list'); //重载表格
                        }
                        // parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        // parent.layui.table.reload('LAY-app-content-draft-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

    form.on('submit(layuiadmin-app-publish-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var loading = layer.load();
            var id = $('#id').val();
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            // 添加或修改表单字段值
            data.field.action = 'publish';
            admin.req({
                url: layui.setter.prefix + 'article/draft/' + id
                , type: 'put'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg('发布成功', {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        window.canAjax = true
                        if (parent.$('#LAY-app-content-list').length > 0) {
                            parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        }
                        if (parent.$('#LAY-app-content-draft-list').length > 0) {
                            parent.layui.table.reload('LAY-app-content-draft-list'); //重载表格
                        }
                        parent.layer.close(index); //再执行关闭
                    });
                }
            });
        }
    });

});
