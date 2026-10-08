{{-- 关联产品：搜索过滤 + 已选回显 + 勾选列表 --}}
@php
    $selectedProductIds = collect($selectedProductIds ?? [])->map(fn ($id) => (int)$id)->filter()->values();
    $products = $products ?? collect();
@endphp
<div class="layui-form-item">
    <label class="layui-form-label">{{ __('关联产品') }}</label>
    <div class="layui-input-block">
        <div style="margin-bottom:10px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <input type="text" id="pv-product-filter" class="layui-input" style="max-width:320px;"
                   placeholder="{{ __('搜索产品ID/名称') }}" autocomplete="off">
            <button type="button" class="layui-btn layui-btn-sm" id="pv-product-remote-search">{{ __('远程搜索') }}</button>
            <span class="layui-badge layui-bg-blue" id="pv-product-selected-count">{{ $selectedProductIds->count() }}</span>
            <span style="color:#888;">{{ __('已选') }}</span>
            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" id="pv-product-clear">{{ __('清空已选') }}</button>
        </div>
        <div id="pv-selected-preview" style="min-height:36px;margin-bottom:10px;padding:8px;border:1px dashed #e6e6e6;border-radius:4px;background:#fafafa;">
            @forelse($products->whereIn('id', $selectedProductIds->all()) as $sp)
                <span class="layui-badge-rim" style="margin:0 6px 6px 0;display:inline-block;">#{{ $sp->id }} {{ $sp->name }}</span>
            @empty
                <span style="color:#999;">{{ __('未选择产品') }}</span>
            @endforelse
        </div>
        <div id="pv-product-list" style="max-height:360px;overflow:auto;border:1px solid #eee;padding:10px;">
            @forelse($products as $product)
                <div class="pv-product-row" data-id="{{ $product->id }}" data-name="{{ mb_strtolower($product->name ?? '') }}" style="margin-bottom:6px;">
                    <input type="checkbox" name="products[]" value="{{ $product->id }}" title="#{{ $product->id }} {{ $product->name }}"
                           lay-filter="pv-product-check"
                           @if($selectedProductIds->contains($product->id)) checked @endif>
                </div>
            @empty
                <div style="color:#999;">{{ __('暂无产品') }}</div>
            @endforelse
        </div>
        <div class="layui-word-aux" style="margin-top:8px;">{{ __('支持本地过滤；远程搜索可加载更多产品。') }}</div>
    </div>
</div>
