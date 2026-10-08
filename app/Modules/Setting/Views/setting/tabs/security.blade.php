{{-- 安全设置 --}}
<div class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-update-form-submit" 
                       id="layuiadmin-app-update-form-submit" value="{{ __('确认添加') }}">
            </div>

            @include('Setting.Views.setting.tabs._input-field', [
                'name' => 'gibberish_threshold',
                'type' => 'number',
                'label' => __('垃圾指数阈值分'),
                'value' => $setting->gibberish_threshold,
                'placeholder' => '请输入垃圾指数阈值分'
            ])
            <div class="layui-form-mid layui-word-aux" style="margin-left: 110px; margin-top: -15px;">超过此分的询盘将不显示在列表中且不转发邮件</div>

            @include('Setting.Views.setting.tabs._input-field', [
                'name' => 'upload_image_max_size',
                'label' => __('图片上传大小限制kb'),
                'value' => $setting->upload_image_max_size,
                'placeholder' => '图片上传大小限制'
            ])

            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('开启国内ip验证') }}</label>
                <div class="layui-input-block">
                    <select name="home_lock">
                        <option value="">{{ __('关闭') }}</option>
                        <option @if ($setting->home_lock) selected @endif value="1">{{ __('开启') }}</option>
                    </select>
                </div>
            </div>

            @include('Setting.Views.setting.tabs._input-field', [
                'name' => 'home_lock_password',
                'label' => __('国内访问密码'),
                'value' => $setting->home_lock_password,
                'placeholder' => '国内访问密码'
            ])

            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('询盘验证码设置') }}</label>
                <div class="layui-input-block">
                    <select name="chat_token">
                        <option value="">{{ __('关闭') }}</option>
                        <option @if ($setting->chat_token === 'google captcha') selected @endif value="google captcha">Google Captcha</option>
                    </select>
                </div>
            </div>

            @php
                $securityFields = [
                    ['name' => 'nocaptcha_sitkey', 'label' => __('谷歌验证码网站密钥'), 'value' => $setting->nocaptcha_sitkey, 'placeholder' => '请输入网站密钥'],
                    ['name' => 'nocaptcha_secret', 'label' => __('谷歌验证码密钥'), 'value' => $setting->nocaptcha_secret, 'placeholder' => '请输入密钥'],
                ];
            @endphp
            @foreach($securityFields as $field)
                <div class="layui-form-item">
                    <label class="layui-form-label">{{ $field['label'] }}</label>
                    <div class="layui-input-block">
                        <input type="text" name="{{ $field['name'] }}" value="{{ $field['value'] }}" 
                               placeholder="{{ $field['placeholder'] }}" autocomplete="off" class="layui-input">
                    </div>
                </div>
            @endforeach

            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('上传文件名生成方式') }}</label>
                <div class="layui-input-block">
                    <select name="upload_name_type">
                        <option @if ($setting->upload_name_type == 0) selected @endif value="0">{{ __('随机生成') }}</option>
                        <option @if ($setting->upload_name_type == 1) selected @endif value="1">{{ __('已有文件名+随机数') }}</option>
                        <option @if ($setting->upload_name_type == 2) selected @endif value="2">{{ __('保持原名称') }}</option>
                    </select>
                </div>
            </div>

            @php
                $toggleFields = [
                    ['name' => 'login_pwd_encrypt', 'label' => __('登录密码加密'), 'value' => $setting->login_pwd_encrypt],
                    ['name' => 'single_sign_on', 'label' => __('单点登陆'), 'value' => $setting->single_sign_on],
                    ['name' => 'inquiry_source_on', 'label' => __('询盘来源是否开启'), 'value' => $setting->inquiry_source_on],
                ];
            @endphp
            @foreach($toggleFields as $field)
                @include('Setting.Views.setting.tabs._radio-field', [
                    'label' => $field['label'],
                    'name' => $field['name'],
                    'value' => $field['value'],
                    'options' => ['1' => __('开启'), '0' => __('关闭')],
                    'blockClass' => 'layui-input-inline'
                ])
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

