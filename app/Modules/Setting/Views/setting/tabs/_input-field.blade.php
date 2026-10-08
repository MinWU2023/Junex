{{-- 输入框字段 --}}
<div class="layui-form-item" style="{{ $style ?? '' }}">
    <label class="layui-form-label slide-width">{{ $label }}</label>
    <div class="layui-input-block main-width">
        <input type="{{ $type ?? 'text' }}" 
               name="{{ $name }}" 
               value="{{ $value ?? '' }}" 
               placeholder="{{ $placeholder ?? '请输入' . $label }}" 
               autocomplete="off" 
               class="layui-input"
               {{ isset($required) && $required ? 'lay-verify=required' : '' }}>
    </div>
    @if(isset($help))
        <div class="layui-input-block main-width" style="color:#fa5661">
            {{ $help }}
        </div>
    @endif
</div>

