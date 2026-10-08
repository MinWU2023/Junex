<?php
$nums = app('settings')['setting']->tag_max_num;
?>
<div class="layui-tag">
    @for($i=0;$i<$nums;$i++)
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('产品关键词') }} {{ $i+1 }}</label>
            <div class="layui-input-block">
                <input name="tag_names[{{ $i }}]" @isset($tags[$i]) value="{{ str_replace([' ','&nbsp;'],' ', trim($tags[$i]->name)) }}" @endif type="text"
                       autocomplete="off"
                       class="layui-input">
            </div>
        </div>
    @endfor
</div>

@if($active)
    <div style="width:100%;" class="layui-tagsearch">
        <div class="demoTable">
            <div style="display: inline-block;width: 125px;padding:9px 15px 9px 0">{{ __('搜索关键词') }}：</div>
            <div class="layui-inline" style="width: calc(100% - 205px);">
                <input class="layui-input" id="keyword" autocomplete="off" style="border-radius: 4px;">
            </div>
            <p class="layui-btn layuiadmin-btn-list" data-type="reload_keywords">{{ __('搜索') }}</p>
        </div>
        <table id="adwords" lay-filter="test" style="width:100%;"></table>
        <script type="text/html" id="adwords_toolbar">
            <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="adwords_copy"><i
                    class="layui-icon layui-icon-add-1"></i></a>
        </script>

    </div>
@endif


