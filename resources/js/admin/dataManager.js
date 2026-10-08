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


    var loadingHtml = '<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop" style="font-size: 36px;"></i>';
    $('#loadingContainer').html(loadingHtml);

    function chartInit(id){
        let chartObj  = echarts.init(document.getElementById(id), null, {
            renderer: "canvas",
            useDirtyRect: false,
        });
        chartObj.showLoading({
            text: '数据加载中...',
            textStyle: {
                fontSize: 16,
                color: '#333'
            },
            spinner: 'dots', // 使用点状的加载图标
            spinnerSize: 60 // 图标大小
        });
        return chartObj;
    }

    //关键词排名数量
    var sheet_canvas1_chart = chartInit("sheet_canvas1");

    //每月询盘累计排名数量
    var sheet_canvas2_chart = chartInit("sheet_canvas2");

    //每月询盘数量
    var sheet_canvas3_chart = chartInit("sheet_canvas3");

    //询盘地区
    var sheet_canvas4_chart = chartInit("sheet_canvas4");

    //产品收录率
    var sheet_canvas6_chart = chartInit("sheet_canvas6");

    //运营指数
    var sheet_canvas7_chart = chartInit("sheet_canvas7");


    //产品名称待修改数量
    var sheet_canvas9_chart = chartInit("sheet_canvas9");

    //产品关键词待修改数量
    var sheet_canvas10_chart = chartInit("sheet_canvas10");

    //产品内链待修改数量
    var sheet_canvas11_chart = chartInit("sheet_canvas11");

    //产品图片重复超过3次的图片数量
    var sheet_canvas12_chart = chartInit("sheet_canvas12");

    var content_options = [];
    var content_charts = [];
    //有效产品
    content_charts[0] = chartInit("content_chart_0");


    var screenWidth = document.documentElement.clientWidth; // 获取屏幕宽度
    var newLegendRight = '20%'; // 默认值，可以根据需要调整

    // 根据屏幕宽度动态计算 newLegendRight 的值
    if (screenWidth < 1200) {
        // 在小屏幕上将距离右边的距离设置为更小的值
        newLegendRight = '2%';
    } else if (screenWidth < 1440) {
        // 在中等屏幕上将距离右边的距离设置为中等值
        newLegendRight = '10%';
    } else {
        // 在大屏幕上将距离右边的距离设置为较大的值
        newLegendRight = '20%';
    }



    function chartRender(chartObj,options){
        // 隐藏加载状态并渲染图表
        chartObj.hideLoading();
        // 更新图表配置并渲染
        chartObj.setOption(options);
        window.addEventListener("resize", chartObj.resize);
    }

    function setData(res){
        content_options = [
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "有效产品",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.product,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "产品分类",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.product_category,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "产品关键词",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.product_tag,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "视频",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.product_video,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "新闻资讯",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.article,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "产品综合得分",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.product_score,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "产品分类综合得分",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.product_category_score,
                    },
                ],
            },
            {
                tooltip: {
                    trigger: "axis",
                },
                grid: {
                    // 控制四周有空白
                    x: 50,
                    y: 50,
                    x2: 5,
                    y2: 70,
                },
                animation: true,
                xAxis: [
                    {
                        type: "category",
                        data: res.data.contentData.times,
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
                yAxis: {
                    type: "value",
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
                series: [
                    {
                        name: "产品关键词比例",
                        type: "line",
                        label: {
                            show: true, // 显示标签
                            position: "insideBottom", // 标签位置：顶部
                            color: "#333", // 标签文字颜色
                            distance: 15, // 设置标签与Y轴的距离
                        },
                        emphasis: {
                            lineStyle: {
                                width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                            },
                        },
                        itemStyle: {
                            normal: {
                                color: "#656EE5",
                            },
                        },
                        data: res.data.contentData.keywords_rate,
                    },
                ],
            },

        ];
        chartRender(content_charts[0],content_options[0]);
        // chartRender(content_charts[5],content_options[5]);
        let option1 = {
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
                    data: res.data.keywordsRankData.times,
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
                    data: res.data.keywordsRankData.one_data,
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
                    data: res.data.keywordsRankData.two_data,
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
                    data: res.data.keywordsRankData.three_data,
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
        };
        chartRender(sheet_canvas1_chart,option1);

        let option2 = {
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
            xAxis: [
                {
                    type: "category",
                    data: res.data.inquiryData.times,
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
                    name: "累计询盘数量",
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
                    name: "累计询盘数量",
                    type: "bar",
                    data: res.data.inquiryData.data,
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
                        label: {
                            show: true, //开启显示
                            position: "top", //在上方显示
                            textStyle: {
                                //数值样式
                                color: "#333",
                            },
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas2_chart,option2);

        let  option3 = {
            tooltip: {
                trigger: "axis",
                // formatter: '{b0}<br/><i class="ele-chart-dot" style="width:10px;height:10px;background: #ccc;"></i>网站运营指数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {c0}',
            },
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            animation: true,
            xAxis: [
                {
                    type: "category",
                    data: res.data.inquiryDataByMonth.times,
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
            yAxis: {
                type: "value",
                name: "每月询盘数量",
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
            series: [
                {
                    name: "每月询盘数量",
                    type: "line",
                    data: res.data.inquiryDataByMonth.data,
                    label: {
                        show: true, // 显示标签
                        position: "insideBottom", // 标签位置：顶部
                        color: "#333", // 标签文字颜色
                        distance: 15, // 设置标签与Y轴的距离
                    },
                    emphasis: {
                        lineStyle: {
                            width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                        },
                    },
                    itemStyle: {
                        normal: {
                            color: "#33D0BD",
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas3_chart,option3);

        let  option4 = {
            title: {
                left: "center",
            },
            tooltip: {
                trigger: "item",
                formatter: "{b} : {c} ({d}%)",
            },
            grid: {
                left: '0%', // 控制图表左侧边距
                right: 50, // 控制图表右侧边距
                top: '0%', // 控制图表上边距
                bottom: '0%' // 控制图表下边距
            },
            legend: {
                type: "scroll",
                orient: 'vertical',
                right:newLegendRight ,
                top:'35%',
                bottom: 20,
                pageTextStyle: {
                    fontSize: 10, // 滚动箭头文字的字号
                },
                itemWidth: 12,
                itemHeight: 10,
                textStyle: {
                    color: "#777",
                    fontSize: 13, // 图例文字的字号
                },
                padding: 0, // 内边距，增加上下空间
                formatter: function (name) {
                    // 自定义图例的显示方式，避免文字截断
                    return echarts.format.truncateText(name, 100, "14px Arial"); // 最大显示100个字符
                },
            },
            series: [
                {
                    type: "pie",
                    radius: ["30%", "60%"],
                    center: ['30%', '50%'], // 控制饼状图在左侧
                    label: {
                        normal: {
                            // formatter: '{d}%',
                            show: true,
                            formatter: "{b} : {d}%",
                            shadowColor: "rgba(0, 0, 0, 0.5)",

                            rich: {
                                //设置标识内容样式
                                per: {
                                    color: "rgba(133, 138, 155, 1)", //设置变量per的颜色，即设置{d}%的颜色
                                    padding: [2, 4],
                                    borderRadius: 2,
                                },
                                ng: {
                                    color: "rgba(92, 164, 252, 1)",
                                },
                            },

                            textStyle: {
                                fontSize: "14",
                                color: "#444",
                            },
                        },
                    },
                    itemStyle: {
                        borderColor: "#fff",
                        borderWidth: 1,
                        color: function (params) {
                            var colorList = [
                                '#656EE5', '#facc14',  '#61da84','#eb76eb','#28e0d1', '#fe706e','#65b0e5',  '#b07fef', '#f7ac75', '#29d4e1', '#FE706E'
                            ]; // 自定义颜色列表
                            return colorList[params.dataIndex];
                        },
                    },
                    // labelLine: {
                    //     normal: {
                    //         show: true,
                    //     },
                    // },
                    data: res.data.inquiryCountryRate,
                    // emphasis: {
                    //     shadowColor: "rgba(0, 0, 0, 0)", // 阴影颜色
                    //     shadowBlur: 30, // 阴影模糊度
                    //     itemStyle: {
                    //         shadowBlur: 10,
                    //         shadowOffsetX: 0,
                    //         shadowColor: "rgba(0, 0, 0, 0.5)",
                    //     },
                    // },
                },
            ],
        };
        chartRender(sheet_canvas4_chart,option4);

        let   option6 = {
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
            xAxis: [
                {
                    type: "category",
                    data: res.data.productIndexLinkRateData.times,
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
                    name: "产品收录率(%)",
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
                    name: "产品收录率(%)",
                    type: "bar",
                    data: res.data.productIndexLinkRateData.rate,
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
                        label: {
                            show: true, //开启显示
                            position: "top", //在上方显示
                            textStyle: {
                                //数值样式
                                color: "#333",
                            },
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas6_chart,option6);

        let option7 = {
            tooltip: {
                trigger: "axis",
                // formatter: '{b0}<br/><i class="ele-chart-dot" style="width:10px;height:10px;background: #ccc;"></i>网站运营指数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {c0}',
            },
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            animation: true,
            xAxis: [
                {
                    type: "category",
                    data: res.data.operationalData.times,
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
            yAxis: {
                type: "value",
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
            series: [
                {
                    name: "运营指数",
                    type: "line",
                    data: res.data.operationalData.data,
                    label: {
                        show: true, // 显示标签
                        position: "insideBottom", // 标签位置：顶部
                        color: "#333", // 标签文字颜色
                        distance: 15, // 设置标签与Y轴的距离
                    },
                    emphasis: {
                        lineStyle: {
                            width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                        },
                    },
                    itemStyle: {
                        normal: {
                            color: "#656EE5",
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas7_chart,option7);

        let   option9 = {
            tooltip: {
                trigger: "axis",
            },
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            animation: true,
            xAxis: [
                {
                    type: "category",
                    data: res.data.productData.times,
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
            yAxis: {
                type: "value",
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
            series: [
                {
                    name: "产品名称待修改数量",
                    type: "line",
                    data: res.data.productData.product_weight,
                    label: {
                        show: true, // 显示标签
                        position: "insideBottom", // 标签位置：顶部
                        color: "#333", // 标签文字颜色
                        distance: 15, // 设置标签与Y轴的距离
                    },
                    emphasis: {
                        lineStyle: {
                            width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                        },
                    },
                    itemStyle: {
                        normal: {
                            color: "#656EE5",
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas9_chart,option9);

        let   option10 = {
            tooltip: {
                trigger: "axis",
            },
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            animation: true,
            xAxis: [
                {
                    type: "category",
                    data: res.data.productData.times,
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
            yAxis: {
                type: "value",
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
            series: [
                {
                    name: "产品关键词待修改数量",
                    type: "line",
                    data: res.data.productData.product_keyword_weight,
                    label: {
                        show: true, // 显示标签
                        position: "insideBottom", // 标签位置：顶部
                        color: "#333", // 标签文字颜色
                        distance: 15, // 设置标签与Y轴的距离
                    },
                    emphasis: {
                        lineStyle: {
                            width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                        },
                    },
                    itemStyle: {
                        normal: {
                            color: "#656EE5",
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas10_chart,option10);

        let option11 = {
            tooltip: {
                trigger: "axis",
            },
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            animation: true,
            xAxis: [
                {
                    type: "category",
                    data: res.data.productData.times,
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
            yAxis: {
                type: "value",
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
            series: [
                {
                    name: "产品内链待修改数量",
                    type: "line",
                    data: res.data.productData.product_content_link_weight,
                    label: {
                        show: true, // 显示标签
                        position: "insideBottom", // 标签位置：顶部
                        color: "#333", // 标签文字颜色
                        distance: 15, // 设置标签与Y轴的距离
                    },
                    emphasis: {
                        lineStyle: {
                            width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                        },
                    },
                    itemStyle: {
                        normal: {
                            color: "#656EE5",
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas11_chart,option11);

        let  option12 = {
            tooltip: {
                trigger: "axis",
            },
            grid: {
                // 控制四周有空白
                x: 50,
                y: 50,
                x2: 5,
                y2: 70,
            },
            animation: true,
            xAxis: [
                {
                    type: "category",
                    data: res.data.productData.times,
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
            yAxis: {
                type: "value",
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
            series: [
                {
                    name: "产品图片标签待修改数量",
                    type: "line",
                    data: res.data.productData.product_img_alt_weight,
                    label: {
                        show: true, // 显示标签
                        position: "insideBottom", // 标签位置：顶部
                        color: "#333", // 标签文字颜色
                        distance: 15, // 设置标签与Y轴的距离
                    },
                    emphasis: {
                        lineStyle: {
                            width: 2, // 设置鼠标悬停时折线的线宽，与普通状态一致
                        },
                    },
                    itemStyle: {
                        normal: {
                            color: "#656EE5",
                        },
                    },
                },
            ],
        };
        chartRender(sheet_canvas12_chart,option12);
    }

    admin.req({
        url: layui.setter.prefix + 'dataManager'
        , type: 'post'
        , data: { _token: token}
        , done: function (res) {
                setData(res);
        }
    });

    admin.req({
        url: layui.setter.prefix + 'dataManager/productCategoryRate'
        , type: 'post'
        , data: { _token: token}
        , done: function (res) {
            $("#loadingContainer").html(res.data);
        }
    })

    //tab栏切换
    $(".tab_uldiv li").on("click", function () {
        //  销毁所有实例
        var dataValue = $(this).attr("data-value");
        $(this).parent().next().find(".item").each(function (i, n) {
                $(n).removeClass("active");
        });
        $(this).parent().find("li").each(function (i, n) {
            $(n).removeClass("active");
        });
        $(this).addClass('active');
        $(".content_item_"+dataValue).addClass('active');
        if (content_charts[dataValue]){
           content_charts[dataValue].dispose();
        }
        content_charts[dataValue] = chartInit("content_chart_"+dataValue);
        chartRender(content_charts[dataValue],content_options[dataValue]);
    });

    $("#generated_data").on('click',function (){
        let start_date = $('#start-date').val();
        let end_date = $('#end-date').val();
        // if (start_date && end_date){
            if (window.canAjax) {
                window.canAjax = false
                var loading = layer.load();
                admin.req({
                    url: layui.setter.prefix + 'dataManager'
                    , type: 'post'
                    , data: { _token: token,start_date:start_date,end_date:end_date}
                    , done: function (res) {
                        setData(res);
                        window.canAjax = true
                        layer.close(loading);
                    }
                });
            }
        // }else{
        //     layer.msg('请选择开始和结束时间', {
        //         icon: 2, // 设置图标为失败图标
        //         time: 2000, // 显示时间（毫秒）
        //         shade: 0.3, // 遮罩透明度
        //         shadeClose: true // 点击遮罩关闭弹框
        //     });
        // }
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
        }else if(dataValue === 'flowAnalysis'){
           let dataVersion  = clickedElement.getAttribute('data-version');
           dataVersion = parseFloat(dataVersion);
           if (dataVersion < 1.4){
               layer.msg('请升级统计插件至最新版', {
                   icon: 2, // 设置图标为失败图标
                   time: 2000, // 显示时间（毫秒）
                   shade: 0.3, // 遮罩透明度
                   shadeClose: true // 点击遮罩关闭弹框
               });
           }else{
               top.layui.index.openTabsPage(layui.setter.prefix+dataValue, '访客分析');
           }
        } else{
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
                case 'keyword':
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
