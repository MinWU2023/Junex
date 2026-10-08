{{-- WhatsApp设置 --}}
<div class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('whatsapp悬浮窗') }}</label>
                <div class="layui-input-block layui-input-inline" style="margin-left: 0;width: 394px;margin-right: 0;">
                    <select name="whatsapp_float_active">
                        <option value="">{{ __('关闭') }}</option>
                        <option @if ($setting->whatsapp_float_active) selected @endif value="1">{{ __('开启') }}</option>
                    </select>
                </div>
            </div>

            @include('Setting.Views.setting.tabs._input-field', [
                'name' => 'whatsapp_bottom',
                'label' => __('悬浮窗高度高度'),
                'value' => $setting->whatsapp_bottom,
                'placeholder' => '请输入',
                'required' => true
            ])

            @for ($i = 0; $i < 6; $i++)
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">{{ __('联系信息') }} {{ $i + 1 }}</label>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="text" name="whatsapp_float_data[key][{{ $i }}]" 
                                   value="@isset($setting->whatsapp_float_data['key'][$i]){{ $setting->whatsapp_float_data['key'][$i] }}@endif"
                                   placeholder="{{ __('联系人') }}" class="layui-input">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="text" name="whatsapp_float_data[value][{{ $i }}]" 
                                   value="@isset($setting->whatsapp_float_data['value'][$i]){{ $setting->whatsapp_float_data['value'][$i] }}@endif"
                                   placeholder="{{ __('whatsapp') }}" class="layui-input">
                        </div>
                    </div>
                </div>
            @endfor

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

