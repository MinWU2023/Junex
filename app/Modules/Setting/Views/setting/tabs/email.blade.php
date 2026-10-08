{{-- 邮件配置 --}}
<div class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-update-form-submit" 
                       id="layuiadmin-app-update-form-submit" value="{{ __('确认添加') }}">
            </div>

            @php
                $emailFields = [
                    ['name' => 'mail_mailer', 'label' => __('邮件驱动'), 'value' => $setting->mail_mailer, 'type' => 'text'],
                    ['name' => 'mail_host', 'label' => __('host'), 'value' => $setting->mail_host, 'type' => 'text'],
                    ['name' => 'mail_port', 'label' => __('端口'), 'value' => $setting->mail_port, 'type' => 'text'],
                    ['name' => 'mail_username', 'label' => __('账号'), 'value' => $setting->mail_username, 'type' => 'text'],
                    ['name' => 'mail_password', 'label' => __('密码'), 'value' => $setting->mail_password, 'type' => 'password'],
                    ['name' => 'mail_encryption', 'label' => __('加密方式'), 'value' => $setting->mail_encryption, 'type' => 'password'],
                    ['name' => 'mail_from_address', 'label' => __('默认发件地址'), 'value' => $setting->mail_from_address, 'type' => 'text'],
                    ['name' => 'mail_from_name', 'label' => __('默认发件人'), 'value' => $setting->mail_from_name, 'type' => 'text'],
                    ['name' => 'mail_addressee', 'label' => __('询盘收件人'), 'value' => $setting->mail_addressee, 'type' => 'text'],
                ];
            @endphp
            @foreach($emailFields as $field)
                @include('Setting.Views.setting.tabs._input-field', $field)
            @endforeach

            <div class="layui-form-item layui-layout-admin">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">{{ __('立即提交') }}</button>
                        <button type="reset" class="layui-btn layui-btn-primary">{{ __('重置') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

