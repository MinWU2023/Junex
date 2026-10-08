{{-- 询盘敏感词过滤 --}}
<div id="app" class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <universal-component :data="{{ $sensitive_words }}" name="sensitive_words[]" label="询盘敏感词添加"></universal-component>
            <universal-component :data="{{ $banner_areas }}" name="banner_areas[]" label="banner位置添加"></universal-component>
            <universal-component :data="{{ $allow_ips }}" name="allow_ips[]" label="国内允许访问ip"></universal-component>
            <universal-component :data="{{ $ban_ips }}" name="ban_ips[]" label="询盘禁止ip"></universal-component>
            <universal-component :data="{{ $ban_emails }}" name="ban_emails[]" label="询盘禁止邮箱"></universal-component>
            <universal-component :data="{{ $ban_access_ips }}" name="ban_access_ips[]" label="网站禁止访问ip"></universal-component>
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