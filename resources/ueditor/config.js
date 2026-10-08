layui.use(['jquery', 'layer'], function () {
    var $ = layui.$ //重点处
    window.UEDITOR_CONFIG.serverUrl = '/ueditor/server'
    var moreUedit = $('#moreUedit').find('script');
    moreUedit.each(function () {
        var id = $(this).attr('id');
        var token = $('#token').val()
        var ue = UE.getEditor(id, {
            toolbars: [[
                'fullscreen', 'source', '|', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                'customstyle', 'fontfamily', 'fontsize', '|',
                'directionalityltr', 'directionalityrtl', 'indent', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
                'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                'print', 'searchreplace', 'drafts', 'help'
            ]],
            initialFrameHeight: 300,
            autoHeightEnabled: false,
            autoWidthEnabled: false,
            elementPathEnabled: false,
            enableContextMenu: true,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', token); // 设置 CSRF token.
            var html = ue.getContent();
            if (html == '' || html == 'undefined') {
                setTimeout(function () {
                    ue.execCommand('drafts');
                }, 500);
            }
        });
    });
})

