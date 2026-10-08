layui.define(["upload", "element"], function (s) {
    var $ = layui.jquery
    var upload = layui.upload
    var element = layui.element
    var token = $('input[name="_token"]').val()
    $('.uploadPath').each(function() {
        let watermark =  $(this).attr('watermark');
        let limit =  $(this).attr('limit');
        let data_field =  $(this).attr('data-field');
        let uploadType = $(this).attr('data-type');
        var btn = $(this);
        var imgBase64
        upload.render({
            elem: this
            ,data: { '_token': token,watermark:watermark,limit:limit,uploadType:uploadType}
            ,url: '/' + window.admin_prefix + '/upload'
            ,before: function(obj){
                obj.preview(function(index, file, result){
                    imgBase64 = result
                    btn.parent().find('#upload-img').attr('src', '/js/admin/css/modules/layer/default/loading-1.gif'); //图片链接（base64）
                });
            }
            ,progress: function(n, elem){
                var percent = n + '%' //获取进度百分比
                element.init();
                element.progress('demo', percent); //可配合 layui 进度条元素使用
                //以下系 layui 2.5.6 新增
                // console.log(elem); //得到当前触发的元素 DOM 对象。可通过该元素定义的属性值匹配到对应的进度条。
            }
            ,done: function(res){
                //如果上传失败
                if(res.code !== 0){
                    if (res.data.error_msg){
                        return layer.msg(res.data.error_msg,{"icon":5});
                    }else{
                        return layer.msg('上传失败',{"icon":5});
                    }

                }
                // 替换：先清旧图再写入新图
                $(".upload_div_"+data_field+" .field_"+data_field).remove();
                $(".upload_div_"+data_field).prepend('<img class="layui-upload-img field_'+data_field+'" src="'+imgBase64+'">');
                btn.parent().find('.path-name').val(res.data.fileinfo.true_path)
                $(".upload_div_"+data_field+' .removeImg').css('display','flex')
                //上传成功
            }
            ,error: function(){
                // var demoText = $('#test-upload-demoText');
                // demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini upload-reload">重试</a>');
                // demoText.find('.upload-reload').on('click', function(){
                //     uploadInst.upload();
                // });
            }
        });
    })

    // 使用委托，兼容动态插入的封面图删除按钮
    $(document).off('click.uploadLaravelRemove', '.removeImg').on('click.uploadLaravelRemove', '.removeImg', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var attr = $(this).attr('field');
        if (!attr) return;
        $('.imgVal_' + attr).val('');
        $('.field_' + attr).remove();
        $(this).css('display', 'none');
    });

    // 从相册单选一张图片回填到 layui-upload 组件（替换封面）
    $(document).off('click.uploadLaravelSelect', '.selectAlbumImage').on('click.uploadLaravelSelect', '.selectAlbumImage', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var field = $(this).attr('data-field') || '';
        if (!field) return;
        layer.open({
            type: 2
            , closeBtn: 2
            , title: '选择相册图片'
            , content: '/' + window.admin_prefix + '/picture/pop?select_album_id=0&single=1&field=' + encodeURIComponent(field)
            , maxmin: true
            , area: window.layerArea || ["80%", "80%"]
        });
    });
    s("uploadLaravel", {})
})
