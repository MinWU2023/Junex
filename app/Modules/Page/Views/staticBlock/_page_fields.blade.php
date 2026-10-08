<div class="layui-form-item">
    <label class="layui-form-label">{{ __('关联单页面') }}</label>
    <div class="layui-input-block">
        <div style="max-height:320px;overflow:auto;border:1px solid #eee;padding:10px;background:#fafafa;">
            @php
                $selectedIds = array_map('intval', (array)($selectedPageIds ?? []));
                $selectedKeys = array_map(function ($k) { return trim((string)$k, '/'); }, (array)($selectedPageKeys ?? []));
            @endphp

            @if(($allPages ?? collect())->isNotEmpty())
                <div style="margin-bottom:8px;color:#666;font-size:12px;">{{ __('单页面') }}</div>
                @foreach(($allPages ?? []) as $page)
                    <input type="checkbox"
                           name="page_ids[]"
                           value="{{ $page->id }}"
                           title="{{ $page->name }} ({{ $page->url_key }})"
                           lay-skin="primary"
                           @if(in_array((int)$page->id, $selectedIds, true)) checked @endif>
                @endforeach
            @endif

            @if(!empty($virtualPages))
                <div style="margin:12px 0 8px;color:#666;font-size:12px;">{{ __('虚拟页面（非单页面数据）') }}</div>
                @foreach($virtualPages as $virtual)
                    <input type="checkbox"
                           name="page_keys[]"
                           value="{{ $virtual['key'] }}"
                           title="{{ $virtual['name'] }} ({{ $virtual['key'] }})"
                           lay-skin="primary"
                           @if(in_array($virtual['key'], $selectedKeys, true)) checked @endif>
                @endforeach
            @endif

            @if(!empty($categoryPages))
                <div style="margin:12px 0 8px;color:#666;font-size:12px;">{{ __('产品分类') }}（{{ __('一级分类') }}）</div>
                @foreach($categoryPages as $category)
                    <input type="checkbox"
                           name="page_keys[]"
                           value="{{ $category['key'] }}"
                           title="{{ $category['name'] }}"
                           lay-skin="primary"
                           @if(in_array($category['key'], $selectedKeys, true)) checked @endif>
                @endforeach
            @endif

            @if(($allPages ?? collect())->isEmpty() && empty($virtualPages) && empty($categoryPages))
                <div style="color:#999;">{{ __('暂无可用页面') }}</div>
            @endif
        </div>
        <div class="layui-word-aux">{{ __('可多选。勾选后该板块在对应前台页面显示。产品分类勾选一级分类后，该分类及其子分类页都会显示。') }}</div>
    </div>
</div>
