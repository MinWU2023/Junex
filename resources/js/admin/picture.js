layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'uploadLaravel', 'productFileUpload'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var upload = layui.upload
    var token = $('#token').val()

    function getQueryParam(name) {
        try {
            var search = window.location.search || ''
            if (search.indexOf('?') === 0) search = search.substring(1)
            var pairs = search.split('&')
            for (var i = 0; i < pairs.length; i++) {
                if (!pairs[i]) continue
                var kv = pairs[i].split('=')
                if (decodeURIComponent(kv[0] || '') === name) {
                    return decodeURIComponent(kv.slice(1).join('=') || '')
                }
            }
        } catch (e) {}
        return null
    }

    // 单选相册图片回填到 <x-admin.layui-upload> / <x-admin.image-upload>
    var singlePickField = (getQueryParam('single') === '1') ? getQueryParam('field') : null
    var auiPickId = getQueryParam('aui') || null

    function fillParentUpload(path) {
        var parentWin = window.parent
        var parentDoc = parentWin && parentWin.document ? parentWin.document : null
        if (!parentDoc || !path) return false

        // 新统一组件：优先通过 AdminImageUpload 回填
        if (auiPickId && parentWin.AdminImageUpload && typeof parentWin.AdminImageUpload.applyAlbum === 'function') {
            parentWin.AdminImageUpload.applyAlbum(auiPickId, [path])
            return true
        }

        if (!singlePickField) return false

        $('.imgVal_' + singlePickField, parentDoc).val(path)
        var wrap = $('.upload_div_' + singlePickField, parentDoc)
        if (wrap && wrap.length) {
            // 若回填目标是新组件列表，走 applyAlbum
            var auiRoot = wrap.closest('.admin-image-upload')
            if (auiRoot.length && parentWin.AdminImageUpload) {
                parentWin.AdminImageUpload.applyAlbum(auiRoot.attr('id'), [path])
                return true
            }
            wrap.find('.field_' + singlePickField).remove()
            wrap.prepend('<img class="layui-upload-img field_' + singlePickField + '" src="/' + path.replace(/^\/+/, '') + '">')
            wrap.find('.removeImg').css('display', 'flex')
        }
        return true
    }

    function closeAlbumLayer() {
        try {
            var idx = window.parent.layer.getFrameIndex(window.name)
            window.parent.layer.close(idx)
        } catch (e) {}
    }

    $('#ids').val(window.parent.ids)
    table.render({
        elem: "#LAY-app-content-list",
        url: layui.setter.prefix + 'picture',
        cols: [[
            {
                type: 'checkbox',
            },
            {
                field:'id',
                title: 'ID',
                align: 'center',
            },
            {
                templet: '<div><a target="_blank" href="/{{d.true_path}}">{{ d.file_name }}</a></div>',
                align: 'left',
                title: '图片名'
            },
            {
                title: '封面',
                width: 200,
                align: 'center',
                templet: '#imageThumb'
            },
            {
                field:'album',
                title: '所属相册',
                align: 'center',
            },
            {
                title: "操作",
                align: "center",
                toolbar: "#table-content-list"
            }]],

        page: !0,
        where: {
            album_id: $('#album_id').val(),
        },
        limit: 10,
        limits: [10, 15, 20, 25, 30],
        text: "对不起，加载出现异常！"
    });
    table.on('edit(LAY-app-content-list)', function (obj) {
        var sort = ~~obj.value.replace(/^(0*)|\D/g, '') //得到修改后的值
            , sendData = {}
        sendData.translate = {}
        obj.data.translations.forEach((q) => {

            sendData.translate[q.locale] = {}
            sendData.translate[q.locale].name = q.name
        })
        sendData.sort = sort;
        sendData.url_key = obj.data.url_key;
        sendData._token = token;
        var loading = layer.load();
        admin.req({
            url: layui.setter.prefix + 'picture/' + obj.data.id
            , type: 'put'
            , data: sendData
            , done: function (res) {
                layer.msg('修改成功', {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    layer.close(loading);
                    // layui.table.reload('LAY-app-content-list'); //重载表格
                });
            }
        });

    })
    active = {
        add: function () {
            layer.open({
                type: 2
                , closeBtn: 2
                , title: '添加图片'
                , content: '/' + window.admin_prefix + '/picture/create'
                , maxmin: true
                , area: window.layerArea
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        },
        reload: function () {
            var album_id = $("#select_album_id");
            //执行重载
            table.reload('LAY-app-content-list', {
                picture: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    album_id: album_id.val(),
                }
            });
        },
        multipleMoveAlbum: function () { //获取选中数据
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
                , title: '批量移动相册'
                , content: '/' + window.admin_prefix + '/picture/multipleMoveAlbum'
                , maxmin: true
                , area: window.layerArea
                , data: ids
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-multiple-move-album-form-submit");
                    submit.click();
                }
                , end: function () {
                    window.canAjax = true
                }
            });
        },
        multipleMoveRemove:function () { //获取选中数据
            var checkStatus = table.checkStatus('LAY-app-content-list')
                , data = checkStatus.data;
            var ids = []
            data.forEach(function (q) {
                ids.push(q.id)
            })
            if (!ids.length) return false
            layer.confirm("确定删除选中的图片？", function () {
                if (window.canAjax) {
                    window.canAjax = false
                    var loading = layer.load();
                    admin.req({
                        url: layui.setter.prefix + 'picture/multipleMoveRemove'
                        , type: 'post'
                        , data: {ids: ids, _token: token}
                        , done: function (res) {
                            layer.msg('删除成功', {
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

    $('.layui-btn.layuiadmin-btn-list').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    $(".select_image").on('click',function (){
        let data_id = $(this).attr('data-id');
        if (singlePickField || auiPickId) {
            var path = $(".radio_image_" + data_id).val()
            if (!path) return;
            if (fillParentUpload(path)) {
                closeAlbumLayer()
            }
            return;
        }
        if ($(this).hasClass('add_dd')){
            $(".radio_image_"+data_id).attr('checked',false)
            $(this).removeClass('add_dd');
        }else{
            $(".radio_image_"+data_id).attr('checked','checked')
            $(this).addClass('add_dd');
        }
    })


    $("#use_images").on('click',function (){
        // 单选 / 新组件：回填选中图片
        if (singlePickField || auiPickId) {
            var $checked = $('input[name="radio_image"]:checked');
            if ($checked.length === 0) {
                layer.msg("请先选择图片", {icon: 3});
                return;
            }
            var parentWin = window.parent;
            if (auiPickId && parentWin && parentWin.AdminImageUpload && !singlePickField) {
                var paths = [];
                $checked.each(function () { paths.push($(this).val()); });
                parentWin.AdminImageUpload.applyAlbum(auiPickId, paths);
                closeAlbumLayer();
                return;
            }
            var path = $checked.first().val();
            if (fillParentUpload(path)) {
                closeAlbumLayer();
            }
            return;
        }

        // 多图模式（老逻辑，保持不变）
        var chk_value =[];//定义一个数组
        $('input[name="radio_image"]:checked').each(function(){//遍历每一个名字为nodes的复选框，其中选中的执行函数
            chk_value.push({key:$(this).attr('data-id'),val:$(this).val()});//将选中的值添加到数组chk_value中
        });
        chk_value.forEach(function (index,value){
            let new_str = index.key+1000;
            let path = index.val;
            var demoListView = $('#upload-upload-demoList',window.parent.document);
            $('#allPaths',window.parent.document).append("<input type='hidden' name='imgPath[]' value='" + path + "' />")
            var tr = $(['<tr id="upload-' + new_str + '">'
                , "<td><img src='/"+path+"' data='/"+path+"'></td>"
                , "<td><input style='display: block;' id='"+new_str+"' type='radio'  name='is_main' value='"+path+"' title=''></td>"
                , "<td><input class='layui-input' type='text' name='imgSorts[]' value='0'></td>"
                , "<td><input class='layui-input' style='width: 100%' type='text' name='imgAlts[]' value=''></td>"
                , '<td><span style="color: #5FB878;">上传成功</span></td>'
                , '<td>'
                , "<button data-val='" + path + "' class=\"layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete upload-upload-product-delete\">删除</button>"
                , '</td>'
                , '</tr>'].join(''));
            demoListView.append(tr);
            if ($("input[name='is_main']",window.parent.document).length === 1) {
                $('#' + new_str,window.parent.document).attr('checked', true)
            }
        })

        var index1 = parent.layer.getFrameIndex(window.name)
        parent.layer.close(index1)
    })

    $("#remove_images").on('click',function (){
        var ids =[];//定义一个数组
        $('input[name="radio_image"]:checked').each(function(){//遍历每一个名字为nodes的复选框，其中选中的执行函数
            ids.push($(this).attr('data-id'));//将选中的值添加到数组chk_value中
        });
        if (!ids.length) {
            layer.msg("请先选择要删除的图片", {icon: 3})
            return;
        }
        layer.confirm("确定删除选中的图片？", function () {
            if (window.canAjax) {
                window.canAjax = false
                var loading = layer.load();
                admin.req({
                    url: layui.setter.prefix + 'picture/multipleMoveRemove'
                    , type: 'post'
                    , data: {ids: ids, _token: token}
                    , done: function (res) {
                        layer.msg('删除成功', {
                            offset: '15px'
                            , icon: 1
                            , time: 1000
                        }, function () {
                            window.canAjax = true
                            layer.close(loading);
                            location.reload()
                        });
                    }
                });
            }
        })
    })

    $(".radio_album").on('click',function (){
        let data_id = $(this).attr('data-id');
        // 保留单选 / 新组件参数，切换分类后仍能回填到原组件
        var href = layui.setter.prefix + "picture/pop?select_album_id=" + data_id;
        if (getQueryParam('single') === '1') {
            var field = getQueryParam('field') || '';
            href += "&single=1&field=" + encodeURIComponent(field);
        }
        if (auiPickId) {
            href += "&aui=" + encodeURIComponent(auiPickId);
        }
        location.href = href;
    })

    // 绑定上传实例：直接把选中的图片上传到文件库，并立即挂到当前相册下
    var uploadInst = upload.render({
        elem: '.ivu-upload-select'
        , field: 'file'
        , url: '/' + window.admin_prefix + '/upload'
        , accept: 'file'
        , exts: 'jpg|jpeg|png|gif|bmp|svg|webp|SVG|WEBP'
        , acceptMime: 'image/*,image/svg+xml,image/webp'
        , auto: true
        , multiple: false
        , data: {'_token': token}
        , before: function () {
            layer.load();
        }
        , done: function (res) {
            layer.closeAll('loading');
            if (res.code !== 0) {
                if (res.data && res.data.error_msg) {
                    layer.msg(res.data.error_msg, {icon: 5});
                } else {
                    layer.msg('上传失败', {icon: 5});
                }
                return;
            }
            var album_id = $("#select_album_id").val();
            // 如果选择了具体相册，则把图片归属到该相册；否则只进文件库，在“全部图片”里显示
            if (album_id && album_id !== "0") {
                admin.req({
                    url: layui.setter.prefix + 'photoAlbum/upload'
                    , type: 'post'
                    , data: {
                        album_id: album_id,
                        'imgPath[]': [res.data.fileinfo.true_path],
                        _token: token
                    }
                    , done: function () {
                        layer.msg('上传成功', {
                            offset: '15px'
                            , icon: 1
                            , time: 1000
                        }, function () {
                            location.reload();
                        });
                    }
                });
            } else {
                layer.msg('上传成功', {
                    offset: '15px'
                    , icon: 1
                    , time: 1000
                }, function () {
                    location.reload();
                });
            }
        }
        , error: function () {
            layer.closeAll('loading');
            layer.msg('上传失败', {icon: 5});
        }
    })

    // 此处不用再单独绑定按钮点击事件，layui.upload 会自动处理文件选择

    $("#create_album").on('click', function () {
        // 用于在创建成功后触发当前弹窗刷新
        window.__photoAlbumChanged = false
        layer.open({
            type: 2
            , closeBtn: 2
            , title: '创建相册分类'
            , content: '/' + window.admin_prefix + '/photoAlbum/create'
            , maxmin: true
            , area: window.layerArea || ["80%", "80%"]
            , btn: ['确定', '取消']
            , yes: function (index, layero) {
                var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-form-submit");
                submit.click();
            }
            , end: function () {
                if (window.__photoAlbumChanged) {
                    location.reload()
                } else {
                    window.canAjax = true
                }
            }
        })
    })

    form.on('select(photo_move)', function (data) {
        if (data.value === "0") return;
        var ids = [];
        $('input[name="radio_image"]:checked').each(function () {
            ids.push($(this).attr('data-id'))
        });
        if (!ids.length) {
            layer.msg("请先选择要移动的图片", {icon: 3})
            return;
        }
        layer.confirm("确定将选中的图片移动到该相册？", function () {
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'picture/multipleMoveAlbum'
                , type: 'post'
                , data: {ids: ids.join(','), photo_album_id: data.value, _token: token}
                , done: function (res) {
                    layer.msg('转移成功', {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        location.reload()
                    });
                }
            })
        })
    })

    table.on("tool(LAY-app-content-list)",
        function (t) {
            var e = t.data;
            "remove" === t.event ? (function () {
                // 只有勾选该行时才允许删除
                var selected = table.checkStatus('LAY-app-content-list').data || [];
                var isSelected = selected.some(function (row) {
                    return row.id === e.id
                })
                if (!isSelected) {
                    layer.msg("请先勾选该图片再删除", {icon: 3})
                    return;
                }
                layer.confirm("确定删除该图片？",
                function (index) {
                    admin.req({
                        url: layui.setter.prefix + 'picture/' + e.id
                        , data: {'_token': token, 'id': e.id}
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
            })() : "edit" === t.event && layer.open({
                type: 2,
                title: "编辑图片",
                content: layui.setter.prefix + 'picture/' + e.id + '/edit',
                maxmin: !0,
                area: window.layerArea,
                btn: ["确定", "取消"],
                yes: function (index, layero) {
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-edit-form-submit");
                    submit.click();
                }
            })
        })
    //监听提交
    form.on('submit(layuiadmin-app-create-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'picture'
                , type: 'post'
                , data: data.field
                , error: function (e) {
                    layer.close(loading)
                    window.canAjax = true
                }
                , done: function (res) {
                    layer.msg('添加成功', {
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

    form.on('submit(layuiadmin-app-edit-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            var id = $('#id').val();
            admin.req({
                url: layui.setter.prefix + 'picture/' + id
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

    form.on('submit(layuiadmin-app-multiple-move-album-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'picture/multipleMoveAlbum'
                , type: 'post'
                , data: data.field
                , done: function (res) {
                    layer.msg('转移成功', {
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


});
