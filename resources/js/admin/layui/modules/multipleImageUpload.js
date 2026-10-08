layui.define(["upload"], function (s) {
    var $ = layui.jquery
    var upload = layui.upload
    var token = $('input[name="_token"]').val()
    var fileIds = "";
    //多文件列表示例
    var uploadListIns = upload.render({
        elem: '.multiple-image-upload'
        , data: {'_token': token}
        , url: '/' + window.admin_prefix + '/upload'
        , multiple: true
        , auto: true
        , choose: function (obj) {
            var item_name = this.item.attr('name');
            var item_display_name = this.item.attr('display_name');
            var demoListView = $('#upload-upload-demoList-' + item_display_name);
            var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
            //读取本地文件
            obj.preview(function (index, file, result) {
                var tr = $(['<tr id="upload-' + index + '">'
                    , '<td>' + file.name + '</td>'
                    , "<td><input style='display: block;' id='" + index + "' type='radio' name='"+item_name+"[is_main][]' value='' title=''></td>"
                    , "<td><input class='layui-input' type='text' name='"+item_name+"[imgSorts][]' value='0'></td>"
                    , "<td><input class='layui-input' style='width: 100%' type='text' name='"+item_name+"[imgAlts][]' value=''></td>"
                    , '<td><i class="layui-icon layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i></td>'
                    , '<td>'
                    , '<button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete">删除</button>'
                    , '</td>'
                    , '</tr>'].join(''));
                //删除
                tr.find('.upload-upload-demo-delete').on('click', function () {
                    $("input[name='imgPath[]']").each(function () {
                        if ($(this).val() === $('#' + index).val()) {
                            $(this).remove()
                        }
                    })
                    delete files[index]; //删除对应的文件
                    tr.remove();
                    uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                });
                console.log(demoListView);
                demoListView.append(tr);
            });
        }
        , done: function (res, index, upload) {
            var item_name = this.item.attr('name');
            var item_display_name = this.item.attr('display_name');
            var demoListView = $('#upload-upload-demoList-' + item_display_name);
            if (res.code === 0) { //上传成功
                $('#allPaths-'+item_display_name).append("<input type='hidden' name='"+item_name+"[imgPath][]' value='" + res.data.fileinfo.true_path + "' />")
                var tr = demoListView.find('tr#upload-' + index)
                theRadio = $('#' + index), tds = tr.children();
                theRadio.val(res.data.fileinfo.true_path)
                if ($("input[name='is_main']").length === 1) {
                    theRadio.attr('checked', true)
                }
                tds.eq(0).html("<img class='showProductImage' data='/" + res.data.fileinfo.true_path + "' src='/" + res.data.fileinfo.thumb_path + "'/>")
                tds.eq(4).html('<span style="color: #5FB878;">上传成功</span>');

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
    s("multipleImageUpload", {})
})
