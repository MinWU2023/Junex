<link rel="stylesheet" href="{{asset('css/admin/admin.public.css')}}">
<link rel="stylesheet" href="{{ asset('report/css/report.css') }}">
<style>
    .layui-table-view {
        margin: 0;
    }

    .box .i-box {
        padding: 20px;
        box-sizing: border-box;
    }

    .layui-table-page {
        text-align: right;
    }
</style>
<div class="box bg-fff">
    <div class="i-box">
        <div class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">时间范围</label>
                    <div class="layui-inline" id="test6" lay-key="8">
                        <div class="layui-input-inline">
                            <input type="text" autocomplete="off" name="startDate" id="startDate" class="layui-input" placeholder="开始日期">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline">
                            <input type="text" autocomplete="off" name="endDate" id="endDate" class="layui-input" placeholder="结束日期">
                        </div>
                        <button class="layui-btn" lay-submit="" lay-filter="formDemoPane">查询</button>
                    </div>
                </div>
            </div>
        </div>
        <table id="report_zzz" lay-filter="report_zzz"></table>
    </div>
</div>
<script type="text/javascript" src="{{ mix('/js/admin/admin.public.js') }}"></script>
<script>
    layui.use(['jquery', 'table', 'laydate', 'form', 'layer'], function() {
        var $ = layui.jquery,
            table = layui.table,
            laydate = layui.laydate,
            form = layui.form,
            layer = layui.layer;
            var $initType ='inquiryData';
            var conditionData = layui.data($initType).child;
            var $time = conditionData.time > 10 ? conditionData.time :  '0'+ conditionData.time;
            var $initTime = '';


        function getNowFormatDate(isReduce) {
            var date = new Date();
            var seperator1 = "-";
            var month = date.getMonth() + 1;
            if (isReduce) {
                month = date.getMonth();
            }
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            var currentdate = date.getFullYear() + seperator1 + month;
            return currentdate;
        }
        
        if(conditionData.time){
            $initTime = new Date().getFullYear() + '-' + $time;
        }else{
            $initTime = '';
        }
        laydate.render({
            elem: '#startDate',
            format: 'yyyy-MM',
            type: 'month',
            theme: '#393D49',
            calendar: true,
            value: $initTime,
            istoday: true,
            max: getNowFormatDate()
        });

        laydate.render({
            elem: '#endDate',
            format: 'yyyy-MM',
            type: 'month',
            value: $initTime,
            theme: '#393D49',
            calendar: true,
            istoday: true,
            max: getNowFormatDate()
        });

        function getTableData($start_time, $end_time) {
            if (conditionData.time) {
                var $year = new Date().getFullYear();
                $start_time = $end_time = $year + '-' +$time;
                conditionData.time = '';
                layui.data($initType, {
                    key: 'child',
                    value: {
                        type: conditionData.type || '',
                        time: '',
                    }
                });
            }

            if($start_time && $start_time.indexOf('-') != -1){
                $start_time = $start_time.replace('-','');
            }

            if($end_time && $end_time.indexOf('-') != -1){
                $end_time = $end_time.replace('-','');
            }

            table.render({
                elem: '#report_zzz',
                where: {
                    start_time: $start_time || '',
                    end_time: $end_time || '',
                    type: conditionData.type
                },
                loading: true,
                method: 'post',
                url: '/nosay/report/getStatistics',
                page: {
                    curr: 1,
                },
                cols: [
                    [{
                        field: 'add_date',
                        title: '添加时间'
                    }, {
                        field: 'num',
                        title: '数量'
                    }]
                ],
            });
        }

        getTableData();

        form.on('submit(formDemoPane)', function(data) {
            if (data.field.startDate && data.field.endDate) {
                var $start = new Date(data.field.startDate).getTime(),
                    $end = new Date(data.field.endDate).getTime();
                if ($start > $end) {
                    layer.msg('开始时间不能大于结束时间!', {
                        icon: 2,
                        time: 1500
                    });
                } else {
                    getTableData(data.field.startDate, data.field.endDate);
                }
            } else {
                getTableData(data.field.startDate, data.field.endDate);
            }
            return false;
        });
    });
</script>
