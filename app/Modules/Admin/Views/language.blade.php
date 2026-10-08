<x-layui-layout>
    <body>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="contact_us">
                            <h2><span>{{ __('联系我们') }}</span></h2>
                            <ul>
                                <li>
                                    <div class="image"><img src="{{ asset('admin/images/svg/svg_17.svg') }}"/></div>
                                    <div class="txt">
                                        <h3>{{ __('客服经理') }}</h3>
                                        <p>TEL:{{ isset($website_info['customer_manager_tel']) ? $website_info['customer_manager_tel'] : '' }}</p>
                                        <p>Email:{{ isset( $website_info['customer_manager_email']) ? $website_info['customer_manager_email'] :'' }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="image"><img src="{{ asset('admin/images/svg/svg_18.svg') }}"/></div>
                                    <div class="txt">
                                        <h3>{{ __('销售经理') }}</h3>
                                        <p>TEL:{{ isset($website_info['operations_manager_tel']) ? $website_info['operations_manager_tel'] : '' }} </p>
                                        <p>Email:{{ isset($website_info['operations_manager_email']) ? $website_info['operations_manager_email'] :'' }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .layui-layer-iframe {
                max-width: 500px !important;
                height: 400px !important;
            }
            .contact_us{padding: 0 10px;}
            .contact_us h2{font-size:20px;color: #222;display: inline-block;margin: 20px 0 30px;font-weight: bold;position: relative;text-indent: 8px}
            .contact_us h2 span{position: relative;z-index: 2;text-indent: 10px;}
            .contact_us h2::before{position: absolute;content: "";width: 14px;height: 14px;background: #b8efe8;left: 0;top: 0;z-index: 1;}
            /* .contact_us ul{display: flex;display:-webkit-flex;flex-wrap: wrap;} */
            .contact_us ul li{padding:0px 30px;background: #fbfaff;display: flex;display:-webkit-flex;box-sizing: border-box;align-items: center;color: #555;border-radius: 8px;flex-wrap: wrap;}
            .contact_us ul li:nth-child(1){margin-bottom:20px}
            .contact_us ul li:last-child{margin-right: 0;}
            .contact_us ul li .image{margin-right: 10px;width: 60px;}
            .contact_us ul li .txt{width:calc((100% - 70px));padding: 20px 0;}
            .contact_us ul li h3{color: #333;margin-bottom:5px;font-weight: bold;font-size: 15px;}
            .contact_us ul li p{margin:4px 0;}
        </style>
        @section('scripts')
        <script src="{{ mix('/js/admin/admin.home.js') }}"></script>
        @endsection
    </body>
</x-layui-layout>
