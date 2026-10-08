{{-- 相关数量设置 --}}
<div class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            @foreach ($nums as $key => $value)
                @include('Setting.Views.setting.tabs._input-field', [
                    'name' => $key,
                    'label' => $value,
                    'value' => $setting->$key,
                    'placeholder' => '请输入' . $value,
                    'required' => true
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

