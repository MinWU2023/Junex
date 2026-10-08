layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index'], function () {
    var $ = layui.$;
    $(".click_photo").click(function (index){
        let num = index.timeStamp.toString();
        let new_str = num.replace(".", '-');
        let path = $(this).attr('path');
        var demoListView = $('#upload-upload-demoList',window.parent.document);
        $('#allPaths',window.parent.document).append("<input type='hidden' name='imgPath[]' value='" + path + "' />")
        var tr = $(['<tr id="upload-' + new_str + '">'
            , "<td><img src='/"+path+"' data='/"+path+"'></td>"
            , "<td><input style='display: block;' id='"+new_str+"' type='radio'  name='is_main' value='' title=''></td>"
            , "<td><input class='layui-input' type='text' name='imgSorts[]' value='0'></td>"
            , "<td><input class='layui-input' style='width: 100%' type='text' name='imgAlts[]' value=''></td>"
            , '<td><span style="color: #5FB878;">上传成功</span></td>'
            , '<td>'
            , '<button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete">删除</button>'
            , '</td>'
            , '</tr>'].join(''));


        tr.find('.upload-upload-demo-delete',window.parent.document).on('click', function () {
            console.log('删除了1111')
            $("input[name='imgPath[]']",window.parent.document).each(function(){
                if ($(this).val() === $('#'+new_str).val()) {
                    $(this).remove()
                }
            })
            tr.remove();
        });

        demoListView.append(tr);
        if ($("input[name='is_main']",window.parent.document).length === 1) {
            console.log('选中'+new_str)
            $('#' + new_str,window.parent.document).attr('checked', true)
        }
    })
});
