/** layuiAdmin.std-v1.4.0 LPPL License By https://www.layui.com/admin/ */
;layui.define(function (e) {
    var i = (layui.$, layui.layer, layui.laytpl, layui.setter, layui.view, layui.admin);
    i.events.logout = function () {
        i.req({
            url: layui.setter.prefix + "logout", type: "get", data: {}, done: function (e) {
                i.exit(function () {
                    // location.href = layui.setter.prefix + "login"
                    top.location.href = layui.setter.prefix + "login";
                    layui.data('layui-router-nav',{
                        key: 'nav',
                        value: []
                    });
                })
            }
        })
    }, e("common", {})
});
