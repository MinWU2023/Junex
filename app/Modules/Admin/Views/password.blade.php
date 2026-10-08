<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">{{ __('修改密码') }}</div>
                    <div class="layui-card-body" pad15>

                        <div class="layui-form" lay-filter="">
                            @csrf
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('当前密码') }}</label>
                                <div class="layui-input-inline">
                                    <input type="password" name="current_password" lay-verify="required" lay-verType="tips" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('新密码') }}</label>
                                <div class="layui-input-inline">
                                    <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">{{ __('8到16个字符') }}</div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('确认新密码') }}</label>
                                <div class="layui-input-inline">
                                    <input type="password" name="password_confirmation" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="setmypass">{{ __('确认修改') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.password.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
