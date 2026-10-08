layui.define(["upload"], function (s) {
    var $ = layui.jquery
    var upload = layui.upload
    var token = $('input[name="_token"]').val()
    var fileIds = "";
    //多文件列表示例
    var fileListView = $('#upload-upload-fileList')
        , uploadListIns = upload.render({
        elem: '#upload-upload-uploadFileList'
        , data: {'_token': token}
        , url: '/' + window.admin_prefix + '/upload'
        , accept: 'file'
        , multiple: true
        , auto: true
        , choose: function (obj) {
            var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
            //读取本地文件
            obj.preview(function (index, file, result) {
                var tr = $(['<tr id="upload-' + index + '">'
                    , '<td>' +
                    "<input class='layui-input' type='text' name='fileNames[]' value=''></td>"
                    , "<td><input class='layui-input' type='text' name='fileSorts[]' value='0'></td>"
                    , '<td><i class="layui-icon layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i></td>'
                    , '<td>'
                    , '<button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete upload-product-file-delete">删除</button>'
                    , '</td>'
                    , '</tr>'].join(''));
                //删除
                tr.find('.upload-product-file-delete').on('click', function () {
                    $("input[name='filePath[]']").each(function(){
                        if ($(this).val() === $('#'+index).val()) {
                            $(this).remove()
                        }
                    })
                    delete files[index]; //删除对应的文件
                    tr.remove();
                    uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                });

                fileListView.append(tr);
            });
        }
        , done: function (res, index, upload) {
            if (res.code === 0) { //上传成功
                $('#allFilePaths').append("<input type='hidden' name='filePath[]' value='" + res.data.fileinfo.true_path + "' />")
                var tr = fileListView.find('tr#upload-' + index),
                     tds = tr.children();
                tds.eq(0).html('<td><input type="hidden" id="'+index+'" value="'+res.data.fileinfo.true_path+'">' +
                    "<input class='layui-input' type='text' name='fileNames[]' value='"+res.data.fileinfo.file_name+"'></td>")
                tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');

                return delete this.files[index]; //删除文件队列已经上传成功的文件
            }
            this.error(index, upload, res);
        }
        , error: function (index, upload, res) {
            var tr = fileListView.find('tr#upload-' + index)
                , tds = tr.children();
            tds.eq(2).html('<span style="color: #FF5722;">上传失败('+res.data.error_msg+')</span>');
        }
    });

    $(".upload-upload-demo-delete").click(function (){
        var theVal = $(this).prev().val();
        $("input[name='filePath[]']").each(function () {
            if ($(this).val() === theVal) {
                $(this).remove()
            }
        })
        $(this).parent().parent().remove()
    })
    s("productFileUpload", {})
})
