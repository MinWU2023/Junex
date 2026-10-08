{{-- 单选框字段 --}}
<div class="layui-form-item">
    <label class="layui-form-label {{ $labelClass ?? '' }}">{{ $label }}</label>
    <div class="layui-input-block {{ $blockClass ?? '' }}">
        @foreach($options as $optValue => $optLabel)
            <input type="radio" 
                   name="{{ $name }}" 
                   value="{{ $optValue }}" 
                   title="{{ $optLabel }}"
                   @if($value == $optValue) checked @endif>
        @endforeach
    </div>
</div>