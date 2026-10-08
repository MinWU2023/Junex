layui.define(["upload"], function (s) {
    var $ = layui.jquery
    var upload = layui.upload
    var token = $('input[name="_token"]').val()
    var fileIds = "";
    //多文件列表示例
    var demoListView = $('#upload-upload-demoList')
        , uploadListIns = upload.render({
        elem: '#upload-upload-uploadList'
        , data: {'_token': token}
        , url: '/' + window.admin_prefix + '/upload'
        , multiple: true
        , exts: (window.__albumUploadExts || 'jpg|jpeg|png|gif|bmp|svg')
        , acceptMime: 'image/*'
        , auto: true
        , bindAction: '#upload-upload-uploadListAction'
        , choose: function (obj) {
            var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
            //读取本地文件
            obj.preview(function (index, file, result) {
                var tr = $(['<tr id="upload-' + index + '">'
                    , '<td>' + file.name + "</td>"
                    , '<td><i class="layui-icon layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i></td>'
                    , '<td>'
                    , '<button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete">删除</button>'
                    , '</td>'
                    , '</tr>'].join(''));
                //删除
                tr.find('.upload-upload-demo-delete').on('click', function () {
                    console.log('点击删除了');
                    $("input[name='imgPath[]']").each(function(){
                        if ($(this).val() === $('#'+index).val()) {
                            $(this).remove()
                        }
                    })
                    delete files[index]; //删除对应的文件
                    tr.remove();
                    uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                });

                demoListView.append(tr);
            });
        }
        , done: function (res, index, upload) {
            if (res.code === 0) { //上传成功
                $('#allPaths').append("<input type='hidden' name='imgPath[]' value='" + res.data.fileinfo.true_path + "' />")
                var tr = demoListView.find('tr#upload-' + index)
                    // theRadio =  $('#' + index)
                    , tds = tr.children();
                // theRadio.val(res.data.fileinfo.true_path)
                // if ($("input[name='is_main']").length === 1) {
                //     theRadio.attr('checked', true)
                // }
                tds.eq(0).html("<img class='showProductImage' data='/" + res.data.fileinfo.true_path + "' src='/" + res.data.fileinfo.thumb_path + "'/><input  id='"+index+"' type='hidden'  value='"+res.data.fileinfo.true_path+"' >")
                tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');

                return delete this.files[index]; //删除文件队列已经上传成功的文件
            }
            this.error(index, upload,res);
        }
        , error: function (index, upload,res) {
            var tr = demoListView.find('tr#upload-' + index), tds = tr.children();
            if (res.data.error_msg){
                tds.eq(3).html('<span style="color: #FF5722;">'+res.data.error_msg+'</span>');
            }else{
                tds.eq(3).html('<span style="color: #FF5722;">上传失败</span>');
            }
        }
    });
    s("albumImageUpload", {})
})
