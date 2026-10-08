<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body" style="padding:0">
                        <h2 style="color: #fe706e;font-size:14px;background: #fff3f3;padding: 10px;margin:15px 0 30px;">
                            <span style="font-size: 15px;font-weight: bold;display: inline-block;width: 20px;height:20px;line-height:20px;border-radius: 50%;background: #ccc;text-align: center;background: #fe706e;color: #fff;margin-right: 2px;">i</span> 尊敬的合作客户：欢迎您登录官网后台！系统检测到后台仍为初始密码登录，处于网络安全考虑，请您及时更改自己账户密码并保护个人信息警惕。</h2>
                        <div class="layui-form">
                            @csrf
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('新密码') }}</label>
                                <div class="layui-input-inline">
                                    <input type="password" name="password" id="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">{{ __('8到16个字符') }}</div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('确认新密码') }}</label>
                                <div class="layui-input-inline">
                                    <input type="password" name="current_password"  lay-verify="pass|confirmPassword" lay-verType="tips" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-password-form-submit"
                                       id="layuiadmin-app-password-form-submit" value="{{ __('确认添加') }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.dashboard.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
