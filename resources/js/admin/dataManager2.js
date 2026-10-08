layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index',
    excel: 'layui_exts/excel'
}).use(['index', 'form','laydate','excel'], function () {
    admin = layui.admin
        , form = layui.form;
    var $ = layui.$
    var token = $('#token').val()
    var laydate = layui.laydate;

    //关键词排名数量
    var sheet_canvas1_chart = echarts.init(document.getElementById("sheet_canvas1"), null, {
        renderer: "canvas",
        useDirtyRect: false,
    });
    sheet_canvas1_chart.showLoading({
        text: '数据加载中...',
        textStyle: {
            fontSize: 16,
            color: '#333'
        },
        spinner: 'dots', // 使用点状的加载图标
        spinnerSize: 60 // 图标大小
    });
    setTimeout(function() {
        // 隐藏加载状态并渲染图表
        sheet_canvas1_chart.hideLoading();
        // 更新图表配置并渲染
        sheet_canvas1_chart.setOption({
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            tooltip: {
                trigger: "axis",
                axisPointer: {
                    type: "shadow",
                },
            },
            legend: {
                bottom: "0%", // 调整图例位置
                itemWidth: 10, // 调整图例色块宽度
                itemHeight: 8, // 调整图例色块高度
                textStyle: {
                    color: "#777",
                },
            },
            xAxis: [
                {
                    type: "category",
                    data: [
                        "2022.03",
                        "2022.04",
                        "2022.05",
                        "2022.06",
                        "2022.07",
                        "2022.08",
                        "2022.09",
                        "2022.10",
                        "2022.11",
                        "2022.12",
                        "2023.01",
                        "2023.02",
                    ],
                    axisTick: {
                        show: true, // 显示刻度线
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#898989", // 更改刻度线颜色
                        },
                    },
                    axisLabel: {
                        color: "#4A4D55", // 更改刻度文字颜色
                    },
                },
            ],
            yAxis: [
                {
                    type: "value",
                    name: "关键词排名数量",
                    nameGap: 30,
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: "#ECEEF6",
                        },
                    },
                    nameTextStyle: {
                        color: "#444", // 设置Y轴标题颜色
                        fontSize: 13, // 更改Y轴轴标题文字大小
                    },
                    axisLabel: {
                        color: "#4A4D55", // 更改刻度文字颜色
                    },
                },
            ],
            series: [
                {
                    name: "第一页",
                    type: "bar",
                    data: [20, 32, 18, 25, 30, 20, 36, 80, 99, 86, 56, 75],
                    barGap: "40%",
                    barCategoryGap: "40%",
                    barMaxWidth: 20,// 设置柱状图最大宽度
                    itemStyle: {
                        barBorderRadius: [2, 2, 2, 2],
                        color: new echarts.graphic.LinearGradient(
                            0,
                            0,
                            0,
                            1, // 渐变方向
                            [
                                { offset: 0, color: "#656EE5" }, // 渐变起始颜色
                                { offset: 1, color: "#757EF3" }, // 渐变结束颜色
                            ]
                        ),
                    },
                },
                {
                    name: "第二页",
                    type: "bar",
                    data: [20, 25, 12, 30, 22, 30, 89, 52, 33, 56, 41, 122],
                    barGap: "40%",
                    barCategoryGap: "40%",
                    barMaxWidth: 20,// 设置柱状图最大宽度
                    itemStyle: {
                        barBorderRadius: [2, 2, 2, 2],
                        color: new echarts.graphic.LinearGradient(
                            0,
                            0,
                            0,
                            1, // 渐变方向
                            [
                                { offset: 0, color: "#33D0BD" }, // 渐变起始颜色
                                { offset: 1, color: "#61F0DE" }, // 渐变结束颜色
                            ]
                        ),
                    },
                },
                {
                    name: "第三页",
                    type: "bar",
                    data: [20, 25, 12, 30, 22, 60, 58, 96, 23, 85, 75, 96],
                    barGap: "40%",
                    barCategoryGap: "40%",
                    barMaxWidth: 20,// 设置柱状图最大宽度
                    itemStyle: {
                        barBorderRadius: [2, 2, 2, 2],
                        color: new echarts.graphic.LinearGradient(
                            0,
                            0,
                            0,
                            1, // 渐变方向
                            [
                                { offset: 0, color: "#FE706E" }, // 渐变起始颜色
                                { offset: 1, color: "#FA908F" }, // 渐变结束颜色
                            ]
                        ),
                    },
                },
            ],
        });
        window.addEventListener("resize", sheet_canvas1_chart.resize);
    }, 2000); // 模拟2秒加载时间

    $("#generated_data").on('click',function (){
        console.log('重新渲染了')
    })

    $('.layui-btn-language').on('click', function () {
        layer.open({
            type: 2
            ,closeBtn: 2
            , title: '添加语种'
            , content: '/' + window.admin_prefix + '/setting/locale/create'
            , maxmin: true
            , area: window.layerArea
            , btn: ['确定', '取消']
            , yes: function (index, layero) {
                //点击确认触发 iframe 内容中的按钮提交
                var submit = layero.find('iframe').contents().find("#layuiadmin-app-create-locale-form-submit");
                submit.click();
            }
            , end: function(){
                window.canAjax = true
            }
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

    $(".view_renew").on('click',function (){
        top.layui.index.openTabsPage(layui.setter.prefix+'renew', '续费政策');
    })

    // 开始日期选择
    var startDate = laydate.render({
        elem: '#start-date',
        theme: 'molv',
        done: function(value, date){
            // 在开始日期选择后，限制结束日期的最小值为选择的开始日期
            endDate.config.min = date;
            endDate.config.min.month = date.month - 1; // 月份要减1，因为月份是从0开始的
        }
    });

    // 结束日期选择
    var endDate = laydate.render({
        elem: '#end-date',
        theme: 'molv',
        done: function(value, date){
            // 在结束日期选择后，限制开始日期的最大值为选择的结束日期
            startDate.config.max = date;
            startDate.config.max.month = date.month - 1;
        }
    });

    $(".keywords_download").click(function (){
        layer.confirm("确定下载排名数据？", function () {
            if (window.canAjax) {
                window.canAjax = false
                var loading = layer.load();
                admin.req({
                    url: layui.setter.prefix + 'keywordRank/export'
                    , type: 'post'
                    , data: { _token: token}
                    , done: function (res) {
                        layer.msg('导出成功', {
                            offset: '15px'
                            , icon: 1
                            , time: 1000
                        }, function () {
                            var myDate = new Date();
                            layui.excel.exportExcel(res.data, '关键词排名' + myDate.getTime() + '导出.xlsx', 'xlsx')
                            window.canAjax = true
                            layer.close(loading);
                        });
                    }
                });
            }
        })
    })

    $(".redirect_btn").click(function (){
        let clickedElement = this;
        let dataValue = clickedElement.getAttribute('data-value');
        let click_title = '';
        if (dataValue === 'view_locale'){
            top.layui.index.openTabsPage( 'https://zh.wikipedia.org/wiki/ISO_639-1', '多语言');
        }else{
            switch (dataValue){
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
                    click_title = '关键词排名';
                    break;
                case 'dataManager':
                    click_title = '数据管家';
                    break;
                case 'operational/score':
                    click_title = '网站运营指数';
                    break;
            }
            top.layui.index.openTabsPage(layui.setter.prefix+dataValue, click_title);
        }

    })

    form.on('submit(layuiadmin-app-create-locale-form-submit)', function(data){
        if (window.canAjax) {
            window.canAjax = false
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var loading = layer.load();
            admin.req({
                url: layui.setter.prefix + 'setting/locale'
                ,type: 'post'
                ,data: data.field
                ,done: function(res){
                    layer.msg('添加成功', {
                        offset: '15px'
                        ,icon: 1
                        ,time: 1000
                    }, function(){
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
