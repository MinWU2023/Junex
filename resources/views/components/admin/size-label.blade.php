<style>
    body {
        margin: 0
    }

    .warnbox {
        text-align: center;
        font-size: 14px;
    }

    .flexhs {
        color: #344663;
        display: flex;
        display: -webkit-flex;
        justify-content: center;
        margin: 20px 0 5px;
        align-items: center;
    }

    .flexhs h2 {
        font-size: 18px;
        margin: 0;
        margin-left: 7px;
    }

    .flexhs img {
        width: 25px;
    }

    .warntext {
        padding: 0 7%;
        color: #344663;
        margin-bottom: 20px;    line-height: 1.5;
    }

    .warncontact {
        color: #687384;
        padding: 0 7%;
    }

    .warncontact span {
        padding-left: 6%
    }

    .warnkj {
        color: #5a6c88;
        margin-bottom: 20px;
    }


</style>

<?php
$website_info = json_decode(app('settings')['setting']->website_info, true);
?>
<div class="warnbox">
    <div class="pic"><img src="{{ asset('admin/images/warnpic.jpg') }}"/></div>
    <div class="flexhs"><img src="{{ asset('admin/images/svg/warn.svg') }}"/>
        <h2>{{ __('空间不足提醒') }}</h2></div>
    <div class="warnkj">{{ __('总空间') }}：{{ app('settings')['setting']->max_size }}G，{{ __('已用空间') }}：{{ $use_size }}G</div>
    <div class="warntext">{!! app('settings')['setting']->size_label !!}</div>
    <div class="warncontact">
        @isset($website_info['customer_manager_tel'])
            {{ __('客服经理') }}：{{ isset($website_info['customer_manager_tel']) ? $website_info['customer_manager_tel'] : '' }}
        @endif
        @isset($website_info['operations_manager_tel'])
            <span>
            {{ __('销售经理') }}：{{ isset($website_info['operations_manager_tel']) ? $website_info['operations_manager_tel'] : '' }}
            </span>
        @endif
    </div>
</div>

