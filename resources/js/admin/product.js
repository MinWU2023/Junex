layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index',
    excel: 'layui_exts/excel'
}).use(['index', 'table', 'form', 'upload', 'productImageUpload', 'productFileUpload', 'util', 'fileUploadOne', 'excel', 'laydate'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form
        , laydate = layui.laydate;
    var $ = layui.$
    var token = $('meta[name="csrf-token"]').attr('content');
    $('#ids').val(window.parent.ids)
    form.on('select(categorySelect)', function (data) {
        product_id = $("#id").val();
        admin.req({
            url: layui.setter.prefix + 'product/getAttribute/' + data.value
            , type: 'post'
            , data: { product_id: product_id, _token: token }
            , done: function (res) {
                $('#productAttributeEle').html(res.data)
                form.render('select');
                if (typeof window.initProductAttributeMultiSelect === 'function') {
                    window.initProductAttributeMultiSelect();
                }
            }
        });
    });
    table.render({
        elem: '#adwords'
        , url: layui.setter.prefix + 'product/keywords'
        , cols: [[ //表头
            { field: 'name', title: __('关键词'), align: 'center', width: '40%' },
            { field: 'average_search_volume', align: 'center', title: __('平均每月搜索量') },
            { field: 'average_cpc', align: 'center', title: __('平均出价') },
            { field: 'competition', align: 'center', title: __('竞争度') },
            {
                title: __('操作'),
                width: 230,
                align: "center",
                toolbar: "#adwords_toolbar"
            }
        ]],
        where: {
            keywords: $('#keywords').val(),
        },
        page: !0,
        limit: 15,
        text: __('查询数据为空'),
        done: function (res) {
            if (res.msg) {
                layer.msg(res.msg, {
                    icon: 2,
                })
            }
        },
    });
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'product',
        cols: [[
            {
                type: 'checkbox',
            },
            {
                templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.id }}</a></div>',
                align: 'left',
                width: 100,
                title: __('产品ID')
            },
            {
                field: "path",
                width: 200,
                title: __('产品封面'),
                align: 'center',
                templet: '#productThumb'
            },
            {
                templet: '<div><a target="_blank" href="{{d.url_key_view}}">{{ d.name }}</a></div>',
                // field: "name",
                width: 400,
                title: __("产品名")
            },

            {
                field: 'category_name',
                title: __('所属分类')
            },

            {
                field: "sort",
                title: __("排序"),
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
                edit: 'number'
            },
            {
                field: "is_new",
                title: __("最新产品"),
                templet: "#is_new"
            },
            {
                field: "is_hot",
                title: __("最热产品"),
                templet: "#is_hot"
            },
            {
                field: "is_recommend",
                title: __("推荐产品"),
                templet: "#is_recommend"
            },

            // {
            //     templet: '<div>{{ d.admin.email }}</div>',
            //     title: '上传账号'
            // },
            {
                title: __("操作"),
                width: 230,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        where: {
            name: $('#name').val(),
            id: $('#id').val(),
            category_id: $('#category_id').val(),
            brand_id: $('#brand_id').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: __("对不起，加载出现异常！")
    });
    table.render({
        elem: "#LAY-app-content-draft-list",
        url: layui.setter.prefix + 'product/draft',
        cols: [[
            {
                field: "id",
                align: 'left',
                width: 100,
                title: __('产品ID')
            },
            {
                field: "path",
                width: 200,
                title: __('产品封面'),
                align: 'center',
                templet: '#productThumb'
            },
            {
                field: "name",
                width: 400,
                title: __("产品名")
            },

            {
                field: 'category_name',
                title: __('所属分类')
            },

            {
                field: "sort",
                title: __("排序"),
                templet: '<div><input readonly="readonly" type="text" value="{{d.sort}}"></div>',
                edit: 'number'
            },
            {
                field: "is_new",
                title: __("最新产品"),
                templet: "#is_new"
            },
            {
                field: "is_hot",
                title: __("最热产品"),
                templet: "#is_hot"
            },
            {
                field: "is_recommend",
                title: __("推荐产品"),
                templet: "#is_recommend"
            },
            {
                field: "scheduled_publish_at",
                title: __("自动发布"),
                width: 180,
                templet: "#scheduled_publish"
            },

            // {
            //     templet: '<div>{{ d.admin.email }}</div>',
            //     title: '上传账号'
            // },
            {
                title: __("操作"),
                width: 230,
                align: "center",
                toolbar: "#table-content-list"
            }]],
        page: !0,
        where: {
            name: $('#name').val(),
            id: $('#id').val(),
            category_id: $('#category_id').val(),
            brand_id: $('#brand_id').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: __("对不起，加载出现异常！")
    });

    // 监听页面可见性变化，当页面重新获得焦点时检查是否需要刷新
    if (document.getElementById('LAY-app-content-draft-list')) {
        $(window).on('focus', function() {
            if (localStorage.getItem('needReloadDraftList') === 'true') {
                localStorage.removeItem('needReloadDraftList');
                layui.table.reload('LAY-app-content-draft-list');
            }
        });

        // 也监听 visibilitychange 事件
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && localStorage.getItem('needReloadDraftList') === 'true') {
                localStorage.removeItem('needReloadDraftList');
                layui.table.reload('LAY-app-content-draft-list');
            }
        });
    }
    table.render({
        elem: "#LAY-app-content-trash-list",
        url: layui.setter.prefix + 'product/trash',
        cols: [[
            {
                type: 'checkbox',
            },
            // {
            //     field: "id",
            //     width: 100,
            //     title: "产品ID",
            //     // sort: !0
            // },
            {
                field: "path",
                width: 200,
                title: __('产品封面'),
                align: 'center',
                templet: '#productThumb'
            },
            {
                field: "name",
                title: __("产品名")
            },
            {
                field: "sort",
                title: __("排序")
            },
            {
                title: __("操作"),
                width: 300,
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
    table.on("tool(adwords)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "adwords_copy":
                    layer.confirm(__("确定添加该关键词？"),
                        function (index) {
                            // let loading = layer.load();
                            let foundEmpty = false;
                            $('.layui-tag').each(function () {
                                $(this).find('input').each(function () {
                                    if ($(this).val() === '' && !foundEmpty) {
                                        $(this).val(e.name); // 设置默认值
                                        foundEmpty = true; // 标记已填充
                                        // break;
                                    }
                                });
                            });
                            if (foundEmpty) {
                                layer.msg(__('插入成功'), { icon: 1 });
                            } else {
                                layer.msg(__('没有可插入的输入框!'), {
                                    icon: 3
                                });
                            }
                        })
                    break;
            }
        })

    table.on('edit(LAY-app-content-list)', function (obj) {
        var value = ~~obj.value.replace(/^(0*)|\D/g, '') //得到修改后的值
            , sendData = {};
        sendData.sort = value;
        sendData.type = 'product_sort';
        sendData._token = token;
        obj.data.sort = value;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'product/change_property/' + obj.data.id
            , type: 'put'
            , data: sendData
            , done: function (res) {
                layer.msg(__('修改成功'), {
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

    $(document).on('click', '.add-tag', function () {
        let val = $(this).text();
        layer.confirm(__("确定添加该关键词？"),
            function (index) {
                // let loading = layer.load();
                let foundEmpty = false;
                $('.layui-tag').each(function () {
                    $(this).find('input').each(function () {
                        if ($(this).val() === '' && !foundEmpty) {
                            $(this).val(val); // 设置默认值
                            foundEmpty = true; // 标记已填充
                            // break;
                        }
                    });
                });
                if (foundEmpty) {
                    layer.msg(__('插入成功'), { icon: 1 });
                } else {
                    layer.msg(__('没有可插入的输入框!'), {
                        icon: 3
                    });
                }
            })

    })

    active = {
        add: function () {
            $.ajax({
                type: "post",
                url: '/' + window.admin_prefix + '/productCategory/exist',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res == 1) {
                        let index = layer.open({
                            type: 2
                            , closeBtn: 2
                            , title: __('添加产品')
                            , content: '/' + window.admin_prefix + '/product/create'
                            , maxmin: true
                            , area: window.layerArea,
                            btn: [__('发布'), __('保存草稿'), __('取消')]
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
                                let temp_product_id = body.find("#temp_product_id").val()
                                admin.req({
                                    url: layui.setter.prefix + 'tempProduct/' + temp_product_id + '/delete'
                                    , data: { '_token': token }
                                    , type: 'delete'
                                });
                            }
                            , cancel: function (index, layero) {
                                let body = layer.getChildFrame('body', index);
                                let temp_product_id = body.find("#temp_product_id").val()
                                admin.req({
                                    url: layui.setter.prefix + 'tempProduct/' + temp_product_id + '/delete'
                                    , data: { '_token': token }
                                    , type: 'delete'
                                });
                            }
                        });
                    } else {
                        layer.msg(__('请先添加产品分类'), {
                            icon: 3
                        })
                    }
                }
            })
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
        reload_draft: function () {
            var name = $('#dom-name');
            var id = $('#dom-id');
            var keywords = $('#dom-keywords');
            var attribute_value = $('#dom-attribute_value');
            var category = $("[name='category_id']")
            var brand = $("[name='brand_id']")
            var attribute = []
            var sort = $("[name='sort']")
            $.each($("input[name='attribute']:checked"), function () {
                attribute.push($(this).val())
            })
            var select_admin = $("#select_admin")
            //执行重载
            table.reload('LAY-app-content-draft-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: name.val(),
                    category_id: category.val(),
                    brand_id: brand.val(),
                    attribute: attribute.join(','),
                    sort: sort.val(),
                    keywords: keywords.val(),
                    attribute_value: attribute_value.val(),
                    select_admin: select_admin.val(),
                    id: id.val(),
                }
            });
        },
        reload: function () {
            var name = $('#dom-name');
            var id = $('#dom-id');
            var keywords = $('#dom-keywords');
            var attribute_value = $('#dom-attribute_value');
            var category = $("[name='category_id']")
            var brand = $("[name='brand_id']")
            var attribute = []
            var sort = $("[name='sort']")
            $.each($("input[name='attribute']:checked"), function () {
                attribute.push($(this).val())
            })
            var select_admin = $("#select_admin")
            //执行重载
            table.reload('LAY-app-content-list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    name: name.val(),
                    category_id: category.val(),
                    brand_id: brand.val(),
                    attribute: attribute.join(','),
                    sort: sort.val(),
                    keywords: keywords.val(),
                    attribute_value: attribute_value.val(),
                    select_admin: select_admin.val(),
                    id: id.val(),
                }
            });
        },
        reload_keywords: function () {
            let keyword = $('#keyword');
            let install_gpt = $("#install_gpt").val();
            if (install_gpt) {
                $.ajax({
                    url: layui.setter.prefix + 'gptKeyword',
                    type: "post",
                    dataType: "json",
                    data: { keyword: keyword.val(), _token: token },
                    success: function (res) {
                        $("#ai-tags").html(res.data)
                    }
                });
            }
            //执行重载
            table.reload('adwords', {
                where: {
                    keyword: keyword.val()
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
            layer.confirm(__("确定把选中的产品进行恢复操作吗？"), function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'product/multipleRestore'
                        , type: 'post'
                        , data: { ids: ids, _token: token }
                        , done: function (res) {
                            layer.msg(__('批量恢复产品成功'), {
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
            layer.confirm(__("确定把选中的产品彻底删除吗？"), function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'product/multipleDestroy'
                        , type: 'post'
                        , data: { ids: ids, _token: token }
                        , done: function (res) {
                            layer.msg(__('批量删除产品成功'), {
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
        multipleMoveBrand: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.open({
                type: 2
                , closeBtn: 2
                , title: __('添加产品')
                , content: '/' + window.admin_prefix + '/product/multipleMoveBrand'
                , maxmin: true
                , area: window.layerArea
                , data: ids
                , btn: [__('确定'), __('取消')]
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-multiple-move-brand-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        },
        multipleMoveUser: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.open({
                type: 2
                , closeBtn: 2
                , title: __('添加产品')
                , content: '/' + window.admin_prefix + '/product/multipleMoveUser'
                , maxmin: true
                , area: window.layerArea
                , data: ids
                , btn: [__('确定'), __('取消')]
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-multiple-move-user-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        },
        multipleMoveCategory: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.open({
                type: 2
                , closeBtn: 2
                , title: __('添加产品')
                , content: '/' + window.admin_prefix + '/product/multipleMoveCategory'
                , maxmin: true
                , area: window.layerArea
                , data: ids
                , btn: [__('确定'), __('取消')]
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-multiple-move-category-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        },
        multipleMoveTrash: function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm(__("确定把选中的产品放入回收站吗？"), function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'product/multipleMoveTrash'
                        , type: 'post'
                        , data: { ids: ids, _token: token }
                        , done: function (res) {
                            layer.msg(__('放入回收站成功'), {
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
        }
    };

    $(document).on('visibilitychange', function () {
        if (document.visibilityState !== 'visible') {
            let temp_product_id = $("#temp_product_id").val();
            let switch_editor = $("#switch_editor").val()
            if (switch_editor == 1) {
                var moreUedit = $('.tinymce_content');
                moreUedit.each(function () {
                    let id = $(this).attr('id');
                    document.getElementById(id).value = tinymce.get(id).getContent();
                })
            }

            //let data1 = form.val("layuiadmin-form-tags");
            if (temp_product_id > 0) {
                let formElement = document.getElementById("data_form");
                let formData = new FormData(formElement);
                let data = {};
                formData.forEach(function (value, key) {
                    // 如果是文件字段，则跳过
                    if (value instanceof File) {
                        return; // 跳过文件字段
                    }
                    // 如果该字段尚未初始化，则初始化为空数组
                    if (!data[key]) {
                        data[key] = [];
                    }
                    data[key].push(value);
                });

                // 遍历 data 对象，将单值字段还原为非数组形式
                for (let key in data) {
                    if (data[key].length === 1) {
                        data[key] = data[key][0]; // 单值字段还原为普通值
                    }
                }

                $.ajax({
                    type: "post",
                    url: '/' + window.admin_prefix + '/tempProduct/' + temp_product_id + '/preview',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    dataType: 'json',
                    data: data,
                    success: function (res) {
                        //  $("#temp_product_id").val(res.data.temp_product_id)
                        // event.preventDefault(); // 阻止默认行为
                        // window.open(res.data.url_key, '_blank'); // 在新标签页中打开链接
                    }
                })
            }
        }
    });

    $("#preview_product").click(function () {
        if (window.canAjax) {
            window.canAjax = false
            let loading = layer.load();
            let temp_product_id = $("#temp_product_id").val();
            let switch_editor = $("#switch_editor").val()
            if (switch_editor == 1) {
                let moreUedit = $('.tinymce_content');
                moreUedit.each(function () {
                    let id = $(this).attr('id');
                    document.getElementById(id).value = tinymce.get(id).getContent();
                })
            }
            // let data = form.val("layuiadmin-form-tags");
            let formElement = document.getElementById("data_form");
            let formData = new FormData(formElement);
            let data_val = {};
            formData.forEach(function (value, key) {
                // 如果是文件字段，则跳过
                if (value instanceof File) {
                    return; // 跳过文件字段
                }
                // 如果该字段尚未初始化，则初始化为空数组
                if (!data_val[key]) {
                    data_val[key] = [];
                }
                data_val[key].push(value);
            });

            // 遍历 data 对象，将单值字段还原为非数组形式
            for (let key in data_val) {
                if (data_val[key].length === 1) {
                    data_val[key] = data_val[key][0]; // 单值字段还原为普通值
                }
            }
            $.ajax({
                type: "post",
                url: '/' + window.admin_prefix + '/tempProduct/' + temp_product_id + '/preview',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                dataType: 'json',
                data: data_val,
                success: function (res) {
                    layer.close(loading);
                    window.canAjax = true
                    $("#temp_product_id").val(res.data.temp_product_id)
                    event.preventDefault(); // 阻止默认行为
                    window.open(res.data.url_key, '_blank'); // 在新标签页中打开链接
                }
            })
        }

    })

    $(".eject_photos").click(function () {
        layer.open({
            type: 2,
            area: ['80%', '80%'],
            content: '/nosay/picture/pop'
        });
    })

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    table.on("tool(LAY-app-content-trash-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "remove":
                    layer.confirm(__("永久删除此产品？"),
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/' + e.id
                                , data: { '_token': token }
                                , type: 'delete'
                                , done: function (res) {
                                    layer.msg(__('产品删除成功'), {
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
                    layer.confirm(__("确定恢复此产品？"),
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/restore/' + e.id
                                , type: 'get'
                                , done: function (res) {
                                    layer.msg(__('恢复产品成功'), {
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
                case "product_new":
                case "product_hot":
                case "product_recommend":
                    admin.req({
                        url: layui.setter.prefix + 'product/change_property/' + e.id
                        , type: 'put'
                        , data: { '_token': token, 'type': t.event }
                        , done: function (res) {
                            switch (t.event) {
                                case 'product_new':
                                    t.update(
                                        {
                                            is_new: !e.is_new
                                        }
                                    );
                                    break;
                                case 'product_hot':
                                    t.update(
                                        {
                                            is_hot: !e.is_hot
                                        }
                                    );
                                    break;
                                case 'product_recommend':
                                    t.update(
                                        {
                                            is_recommend: !e.is_recommend
                                        }
                                    );
                                    break;

                            }
                            layer.msg(__('操作成功'), {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            });
                        }
                    });
                    break;
                case "layui-img":
                    layer.open({
                        type: 2,
                        shade: 0.8,
                        offset: 'auto',
                        area: window.layerArea,
                        shadeClose: true,
                        maxmin: true,
                        scrollbar: false,
                        title: __("图片预览"),
                        content: e.true_path,
                        cancel: function () {
                            //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                        }
                    });
                    break;
                case "del":
                    layer.confirm(__("确定把此产品放入回收站？"),
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/remove'
                                , data: { '_token': token, 'id': e.id }
                                , type: 'post'
                                , done: function (res) {
                                    layer.msg(__('放入回收站成功'), {
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
                case "copy":
                    layer.open({
                        type: 2,
                        title: __("复制产品"),
                        content: layui.setter.prefix + 'product/' + e.id + '/copy',
                        maxmin: !0,
                        area: window.layerArea,
                        btn: [__("确定"), __("取消")],
                        yes: function (index, layero) {
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                            submit.click();
                        }
                    })
                    break;
                case "edit":
                    top.layui.index.openTabsPage(layui.setter.prefix + 'product/' + e.id + '/edit', '产品' + e.id)
                    // event.preventDefault(); // 阻止默认行为
                    // window.open(layui.setter.prefix + 'product/' + e.id + '/edit', '_blank'); // 在新标签页中打开链接
                    // layer.open({
                    //     type: 2,
                    //     title: "编辑产品",
                    //     content: layui.setter.prefix + 'product/' + e.id + '/edit',
                    //     maxmin: !0,
                    //     area: window.layerArea,
                    //     btn: ["确定", "取消"],
                    //     yes: function (index, layero) {
                    //         var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                    //         submit.click();
                    //     }
                    // })
                    break;

                case "video":
                    top.layui.index.openTabsPage(layui.setter.prefix + 'product/' + e.id + '/video', '产品视频' + e.id)
                    // layer.open({
                    //     type: 2,
                    //     title: "编辑产品",
                    //     content: layui.setter.prefix + 'product/' + e.id + '/edit',
                    //     maxmin: !0,
                    //     area: window.layerArea,
                    //     btn: ["确定", "取消"],
                    //     yes: function (index, layero) {
                    //         var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                    //         submit.click();
                    //     }
                    // })
                    break;
            }
        })

        table.on("tool(LAY-app-content-draft-list)",
        function (t) {
            var e = t.data;
            switch (t.event) {
                case "product_new":
                case "product_hot":
                case "product_recommend":
                    admin.req({
                        url: layui.setter.prefix + 'product/change_property/' + e.id
                        , type: 'put'
                        , data: { '_token': token, 'type': t.event }
                        , done: function (res) {
                            switch (t.event) {
                                case 'product_new':
                                    t.update(
                                        {
                                            is_new: !e.is_new
                                        }
                                    );
                                    break;
                                case 'product_hot':
                                    t.update(
                                        {
                                            is_hot: !e.is_hot
                                        }
                                    );
                                    break;
                                case 'product_recommend':
                                    t.update(
                                        {
                                            is_recommend: !e.is_recommend
                                        }
                                    );
                                    break;

                            }
                            layer.msg(__('操作成功'), {
                                offset: '15px'
                                , icon: 1
                                , time: 1000
                            });
                        }
                    });
                    break;
                case "layui-img":
                    layer.open({
                        type: 2,
                        shade: 0.8,
                        offset: 'auto',
                        area: window.layerArea,
                        shadeClose: true,
                        maxmin: true,
                        scrollbar: false,
                        title: __("图片预览"),
                        content: e.true_path,
                        cancel: function () {
                            //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                        }
                    });
                    break;
                case "del":
                    layer.confirm(__("确定要删除此草稿，删除后将无法恢复！"),
                        function (index) {
                            admin.req({
                                url: layui.setter.prefix + 'product/draft/destroy/' + e.id
                                , data: { '_token': token, 'id': e.id }
                                , type: 'post'
                                , done: function (res) {
                                    layer.msg(__('删除成功'), {
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
                    top.layui.index.openTabsPage(layui.setter.prefix + 'product/draft/' + e.id + '/edit', '草稿产品' + e.id)
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
                            '• 产品排序<br>' +
                            '• 产品分类<br>' +
                            '• 产品名称<br>' +
                            '• 产品主图<br>' +
                            '• 产品详情内容' +
                            '</div></div>' +
                            '</div>',
                        success: function(layero, index){
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
                                done: function(value, date){
                                    // 选择完成后的回调
                                }
                            });
                        },
                        btn: [__('保存'), __('清除'), __('取消')],
                        btn2: function(index, layero){
                            // 清除定时
                            admin.req({
                                url: layui.setter.prefix + 'product/draft/schedule/' + e.id,
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
                        yes: function(index, layero){
                            var datetime = $('#scheduled_datetime').val();
                            if (!datetime) {
                                layer.msg(__('请选择日期时间'));
                                return false;
                            }

                            // 使用原生Ajax来完全控制响应处理
                            $.ajax({
                                url: layui.setter.prefix + 'product/draft/schedule/' + e.id,
                                type: 'POST',
                                data: {
                                    '_token': token,
                                    'publish_at': datetime
                                },
                                dataType: 'json',
                                success: function(res) {
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
                                            yes: function(alertIndex) {
                                                // 跳转到编辑页面
                                                layer.close(alertIndex);
                                                layer.close(index);
                                                top.layui.index.openTabsPage(
                                                    layui.setter.prefix + 'product/draft/' + e.id + '/edit',
                                                    '编辑草稿产品' + e.id
                                                );
                                            },
                                            btn2: function(alertIndex) {
                                                layer.close(alertIndex);
                                            }
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
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
                                                yes: function(alertIndex) {
                                                    layer.close(alertIndex);
                                                    layer.close(index);
                                                    top.layui.index.openTabsPage(
                                                        layui.setter.prefix + 'product/draft/' + e.id + '/edit',
                                                        '编辑草稿产品' + e.id
                                                    );
                                                },
                                                btn2: function(alertIndex) {
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

    form.on('submit(layuiadmin-app-multiple-move-category-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'product/multipleMoveCategory'
                , type: 'post'
                , data: data.field
                , done: function (res) {
                    layer.msg(__('转移成功'), {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                }
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
            });
        }
    })

    form.on('submit(layuiadmin-app-multiple-move-brand-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'product/multipleMoveBrand'
                , type: 'post'
                , data: data.field
                , done: function (res) {
                    layer.msg(__('转移成功'), {
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
    })
    form.on('submit(layuiadmin-app-multiple-move-user-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'product/multipleMoveUser'
                , type: 'post'
                , data: data.field
                , done: function (res) {
                    layer.msg(__('转移成功'), {
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
                url: layui.setter.prefix + 'product'
                , type: 'post'
                , data: data_val
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    var successMsg = isDraft ? __('保存草稿成功') : __('添加成功');
                    layer.msg(successMsg, {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        parent.layer.close(index); //关闭弹窗
                        if (isDraft) {
                            // 如果是保存草稿，打开草稿箱页面
                            top.layui.index.openTabsPage(layui.setter.prefix + 'product/draft', __('产品草稿箱'));
                        } else {
                            // 如果是发布，重载产品列表
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
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'product/' + id
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
                        window.canAjax = true
                        window.location.reload()
                        // parent.layui.table.reload('LAY-app-content-list'); //重载表格
                        // parent.layer.close(index); //再执行关闭
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
            // 添加或修改表单字段值
            data.field.action = 'publish';
            admin.req({
                url: layui.setter.prefix + 'product/draft/' + id
                , type: 'put'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg(__('发布成功'), {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        window.canAjax = true

                        // 设置 localStorage 标记，通知草稿列表页面需要刷新
                        localStorage.setItem('needReloadDraftList', 'true');

                        // 查找草稿列表页面的 iframe 并刷新表格
                        try {
                            var iframes = top.document.getElementsByTagName('iframe');
                            for (var i = 0; i < iframes.length; i++) {
                                var iframe = iframes[i];
                                // 判断是否为草稿列表页面
                                if (iframe.src && iframe.src.indexOf('product/draft') > -1 && iframe.src.indexOf('product/draft/') === -1) {
                                    var iframeWindow = iframe.contentWindow;
                                    if (iframeWindow && iframeWindow.layui && iframeWindow.layui.table) {
                                        iframeWindow.layui.table.reload('LAY-app-content-draft-list');
                                        localStorage.removeItem('needReloadDraftList');
                                        break;
                                    }
                                }
                            }
                        } catch (e) {
                            console.log('刷新草稿列表失败:', e);
                        }

                        // 关闭当前标签页
                        top.layui.admin.closeThisTabs();
                        // 打开产品列表页面
                        // top.layui.index.openTabsPage(layui.setter.prefix + 'product', __('产品列表'));
                    });
                }
            });
        }
    });



    $(document).on('click','.database-delete',function (){
        let theVal = $(this).prev().val();
        $("#allPaths input").each(function () {
            if ($(this).val() === theVal) {
                $(this).remove()
            }
        })
        $(this).parent().parent().remove()
    })

    $('.upload-product-file-delete').on('click', function () {
        var theVal = $(this).prev().val();
        $("#allFilePaths input").each(function () {
            if ($(this).val() === theVal) {
                $(this).remove()
            }
        })
        $(this).parent().parent().remove()
    })

    $("body").on('click', '.upload-upload-product-delete', function () {
        var theVal = $(this).attr('data-val');
        $("input[name='imgPath[]']").each(function () {
            if ($(this).val() === theVal) {
                $(this).remove()
            }
        })
        $(this).parent().parent().remove()
    })

    $('#imglist').on('click', '.showProductImage', function () {
        var path = $(this).attr('data')
        layer.open({
            type: 2,
            shade: 0.8,
            offset: 'auto',
            area: window.layerArea,
            shadeClose: true,
            maxmin: true,
            scrollbar: false,
            title: __("图片预览"),
            content: path,
            cancel: function () {
                //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
            }
        });
    })
});
