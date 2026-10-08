layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index'], function () {
    var $ = layui.$;
    var token = $('#token').val();
    window.canAjax = true;

    // 从 URL 中读取当前相册 ID / 编辑器 ID
    var urlParams = new URLSearchParams(window.location.search);
    var currentAlbumId = urlParams.get('select_album_id') || '';
    var editorId = urlParams.get('editor_id') || '';

    // 图片选中 / 取消选中
    $(".select_image").on('click', function () {
        var data_id = $(this).attr('data-id');
        if ($(this).hasClass('add_dd')) {
            $(".radio_image_" + data_id).attr('checked', false);
            $(this).removeClass('add_dd');
        } else {
            $(".radio_image_" + data_id).attr('checked', 'checked');
            $(this).addClass('add_dd');
        }
    });

    // 「使用选中图片」
    // 父 <button> 有 disabled 属性，disabled button 自身不触发 click，
    // 事件绑定在内部 <span id="use_images"> 上，子元素 click 不受 disabled 影响。
    $('#use_images').on('click', function () {
        var paths = [];
        $('input[name="radio_image"]:checked').each(function () {
            paths.push($(this).val());
        });

        if (!paths.length) {
            layer.msg('请先选择图片');
            return;
        }

        // 先关闭相册弹层，再调用插入函数
        var albumIndex = parent.layer.getFrameIndex(window.name);
        parent.layer.close(albumIndex);

        // 优先走闭包插入函数（最可靠）
        var wins = [window];
        try { if (window.parent !== window) wins.push(window.parent); } catch (e) {}
        try { if (window.top !== window) wins.push(window.top); } catch (e) {}

        var insertFn = null;
        wins.some(function (w) {
            try {
                if (typeof w._tinymceAlbumInsert === 'function') {
                    insertFn = w._tinymceAlbumInsert;
                    return true;
                }
            } catch (e) {}
            return false;
        });
        if (insertFn) {
            insertFn(paths);
            return;
        }

        // 兜底：用 editor_id 在多层 window 查找 tinymce 实例并直接插入
        var editor = null;
        if (editorId) {
            wins.some(function (w) {
                try {
                    if (w.tinymce && typeof w.tinymce.get === 'function') {
                        var ed = w.tinymce.get(editorId);
                        if (ed) {
                            editor = ed;
                            return true;
                        }
                    }
                } catch (e) {}
                return false;
            });
        }
        if (!editor) {
            layer.msg('未找到 TinyMCE 编辑器，请重新从编辑器内打开相册');
            return;
        }
        editor.focus();
        paths.forEach(function (path) {
            editor.insertContent('<img src="/' + path + '" />');
        });
        editor.windowManager.close();
    });

    // 切换相册：保留 from_tinymce=1 参数
    $(".radio_album").on('click', function () {
        var data_id = $(this).attr('data-id');
        var url = layui.setter.prefix + 'picture/pop?from_tinymce=1&select_album_id=' + data_id;
        if (editorId) url += '&editor_id=' + encodeURIComponent(editorId);
        location.href = url;
    });

    // 「删除图片」（弹窗内直接删除相册图片）
    $("#remove_images").on('click', function () {
        var ids = [];
        $('input[name="radio_image"]:checked').each(function () {
            ids.push($(this).attr('data-id'));
        });
        if (!ids.length) return;

        layer.confirm("确定删除选中的图片？", function () {
            if (window.canAjax) {
                window.canAjax = false;
                var loading = layer.load();
                admin.req({
                    url: layui.setter.prefix + 'picture/multipleMoveRemove'
                    , type: 'post'
                    , data: {ids: ids, _token: token}
                    , done: function () {
                        layer.msg('删除成功', {offset: '15px', icon: 1, time: 1000}, function () {
                            window.canAjax = true;
                            layer.close(loading);
                            var base = layui.setter.prefix + 'picture/pop?from_tinymce=1';
                            if (currentAlbumId) base += '&select_album_id=' + currentAlbumId;
                            if (editorId) base += '&editor_id=' + encodeURIComponent(editorId);
                            location.href = base;
                        });
                    }
                });
            }
        });
    });
});
