layui.define(["upload"], function (s) {
    var $ = layui.jquery
    var upload = layui.upload
    var token = $('input[name="_token"]').val()
    var fileIds = "";
    //多文件列表示例
    upload.render({
        elem: '#upload-one-uploadFileList'
        , data: {'_token': token}
        , url: '/' + window.admin_prefix + '/upload'
        , accept: 'file'
        , auto: true
        ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
            layer.load(); //上传loading
        }
        ,done: function(res, index, upload){ //上传后的回调
            layer.closeAll('loading'); //关闭loading
            if (res.code === 0) { //上传成功
                $("#fileOnePath").val(res.data.fileinfo.true_path);
                layer.msg("上传成功",{"icon":1})
                return ; //删除文件队列已经上传成功的文件
            }
            this.error(index, upload, res);
        }
        , error: function (index, upload, res) {
            layer.closeAll('loading'); //关闭loading
            layer.msg('上传失败'+res.data.error_msg,{"icon":5})
        }
    })
    s("fileUploadOne", {})
})
