@php
    $currentSourceType = (string)old('source_type', $model->source_type ?? 'flag');
@endphp
<div class="layui-form-item">
    <label class="layui-form-label">{{ __('来源类型') }}</label>
    <div class="layui-input-block">
        <select name="source_type" id="source_type" lay-filter="source_type" lay-verify="required">
            @foreach($sourceTypes as $typeKey => $typeLabel)
                <option value="{{ $typeKey }}" @if($currentSourceType === (string)$typeKey) selected @endif>{{ $typeLabel }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item" id="flag_source_box" style="{{ $currentSourceType === 'flag' ? '' : 'display:none;' }}">
    <label class="layui-form-label">{{ __('标记来源') }}</label>
    <div class="layui-input-block">
        <select name="product_source" id="product_source">
            @foreach($productSources as $sourceKey => $sourceLabel)
                <option value="{{ $sourceKey }}" @if((string)old('product_source', $model->product_source ?? 'hot') === (string)$sourceKey) selected @endif>{{ $sourceLabel }}</option>
            @endforeach
        </select>
    </div>
</div>

<div id="category_source_box" style="{{ $currentSourceType === 'category' ? '' : 'display:none;' }}">
    <div class="layui-form-item">
        <label class="layui-form-label">{{ __('产品分类') }}</label>
        <div class="layui-input-block">
            <select name="product_category_id" id="product_category_id" lay-filter="product_category_id" lay-search>
                <option value="">{{ __('请选择分类') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" data-name="{{ $cat->name }}" @if((string)old('product_category_id', $model->product_category_id ?? '') === (string)$cat->id) selected @endif>
                        @if((int)$cat->parent_id > 0)-- @endif{{ $cat->name }} (#{{ $cat->id }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">{{ __('选择产品') }}</label>
        <div class="layui-input-block">
            <div id="category_products_actions" style="margin-bottom:8px;">
                <button type="button" class="layui-btn layui-btn-xs" id="hot_tab_select_all">{{ __('全选') }}</button>
                <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" id="hot_tab_unselect_all">{{ __('取消全选') }}</button>
            </div>
            <div id="category_products_box" style="max-height:320px;overflow:auto;border:1px solid #eee;padding:10px;border-radius:2px;">
            @if(($categoryProducts ?? collect())->isEmpty())
                <div class="hot-tab-products-empty" style="color:#999;">{{ __('请先选择产品分类') }}</div>
            @else
                @foreach($categoryProducts as $product)
                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" title="#{{ $product->id }} {{ $product->name }}"
                           lay-skin="primary"
                           @if(in_array((int)$product->id, array_map('intval', $selectedProductIds ?? []), true)) checked @endif>
                @endforeach
            @endif
            </div>
        </div>
        <div class="layui-form-mid layui-word-aux">{{ __('仅展示所选分类及其子分类下的启用产品，可多选') }}</div>
    </div>
</div>
