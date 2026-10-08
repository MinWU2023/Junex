{{-- 表单包装器 --}}
<div class="layui-tab-item {{ $class ?? '' }}">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-update-form-submit" 
                       id="layuiadmin-app-update-form-submit" value="{{ __('确认添加') }}">
            </div>
            
            {{ $slot }}
            
            <div class="layui-form-item layui-layout-admin">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="{{ $filter ?? 'component-form-demo1' }}">
                            {{ __('立即提交') }}
                        </button>
                        <button type="reset" class="layui-btn layui-btn-primary">{{ __('重置') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

