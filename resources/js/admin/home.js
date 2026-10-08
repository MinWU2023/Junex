layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'table', 'form', 'uploadLaravel', 'productFileUpload', 'laydate'], function () {
    var table = layui.table
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()

    $('.layui-btn-language').on('click', function () {
        layer.open({
            type: 2
            , closeBtn: 2
            , title: '开通语言'
            , content: '/' + window.admin_prefix + '/openLanguage'
            // , maxmin: true
            , area: ['500px !important;','400px !important;']
            // , btn: ['确定', '取消']
            // , yes: function (index, layero) {
            //     //点击确认触发 iframe 内容中的按钮提交
            //     var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-locale-form-submit");
            //     submit.click();
            // }
            // , end: function () {
            //     window.canAjax = true
            // }
        });
    });
    $('.layui-btn-notice,.layui-btn-notice_wrap').on('click', function () {
        let clickedElement = this;
        let dataId = clickedElement.getAttribute('data-id');
        layer.open({
            type: 2, // page 层类型
            area: ['600px', '550px'],
            title: '公告',
            btn: ['我知道了'],
            shade: 0.6, // 遮罩透明度
            shadeClose: true, // 点击遮罩区域，关闭弹层
            maxmin: true, // 允许全屏最小化
            anim: 0, // 0-6 的动画形式，-1 不开启
            content: layui.setter.prefix+'getNotice/'+dataId
        });
    });

    $(".view_renew").on('click', function () {
        top.layui.index.openTabsPage('/nosay/renew', '续费政策');
    })

    var laydate = layui.laydate;
    // 开始日期选择
    var startDate = laydate.render({
        elem: '#start-date',
        theme: 'molv',
        done: function (value, date) {
            // 在开始日期选择后，限制结束日期的最小值为选择的开始日期
            endDate.config.min = date;
            endDate.config.min.month = date.month - 1; // 月份要减1，因为月份是从0开始的
        }
    });

    // 结束日期选择
    var endDate = laydate.render({
        elem: '#end-date',
        theme: 'molv',
        done: function (value, date) {
            // 在结束日期选择后，限制开始日期的最大值为选择的结束日期
            startDate.config.max = date;
            startDate.config.max.month = date.month - 1;
        }
    });



    $(".fast_click").click(function () {
        let clickedElement = this;
        let dataValue = clickedElement.getAttribute('data-value');
        let click_title = '';
        switch (dataValue) {
            case 'product':
                click_title = '产品管理';
                break;
            case 'article':
                click_title = '文章管理';
                break;
            case 'blog':
                click_title = '博客管理';
                break;
            case 'inquiry':
                click_title = '询盘管理';
                break;
            case 'newsletter':
                click_title = '邮箱订阅';
                break;
            case 'woodpecker':
                click_title = '啄木鸟数据';
                break;
            case 'keywordRank':
            case 'keyword':
                click_title = '关键词排名';
                break;
            case 'dataManager':
                click_title = '数据管家';
                break;
            case 'operational/score':
                click_title = '网站运营指数';
                break;
            case 'listing':
                click_title = 'listing列表'
                break;
        }
        top.layui.index.openTabsPage('/nosay/' + dataValue, click_title);
    })

    form.on('submit(layuiadmin-app-create-locale-form-submit)', function (data) {
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting/locale'
                , type: 'post'
                , data: data.field
                , done: function (res) {
                    layer.msg('添加成功', {
                        offset: '15px'
                        , icon: 1
                        , time: 1000
                    }, function () {
                        layer.close(loading);
                        parent.layui.table.reload('LAY-app-locale-content-list'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    });
                },
                error: function (err) {
                    layer.close(loading);
                    window.canAjax = true
                }
            });
        }
    });

});
