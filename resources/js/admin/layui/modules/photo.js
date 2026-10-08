layui.define(["upload"], function (s) {
    var $ = layui.jquery
    var upload = layui.upload
    var token = $('input[name="_token"]').val()

    $(".eject_photos").click(function (){
        layer.open({
            type: 2,
            area: ['80%', '80%'],
            content: '/nosay/photos' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
    })

    s("photo", {})
})
