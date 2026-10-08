{{-- 关联分类 / 关联产品 --}}
<div class="pf-form-section">
    <div class="pf-form-section-title"><i class="layui-icon layui-icon-link"></i>{{ __('关联设置') }}</div>

    <div class="layui-form-item">
        <label class="layui-form-label">{{ __('关联分类') }}</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn pf-btn pf-btn-soft" id="btn-open-category-modal">
                <i class="layui-icon layui-icon-template-1"></i> {{ __('选择分类') }}
            </button>
            <p class="pf-form-hint">{{ __('可多选；父级勾选会联动子级。前台将展示该分类下产品的对应问答。') }}</p>
            <div id="selected-categories-preview" class="pf-relation-box">
                @forelse(($selectedCategories ?? []) as $cat)
                    <span class="pf-tag pf-tag-cat" style="margin:0 6px 6px 0;">#{{ $cat->id }} {{ $cat->name }}</span>
                @empty
                    <span class="pf-relation-empty">{{ __('未选择分类') }}</span>
                @endforelse
            </div>
            <div id="category-ids-inputs">
                @foreach(($selectedCategoryIds ?? []) as $cid)
                    <input type="hidden" name="category_ids[]" value="{{ (int)$cid }}">
                @endforeach
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">{{ __('关联产品') }}</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn pf-btn pf-btn-soft" id="btn-open-product-modal">
                <i class="layui-icon layui-icon-cart"></i> {{ __('选择产品') }}
            </button>
            <p class="pf-form-hint">{{ __('可多选；支持按分类筛选与关键词搜索。已关联项会默认勾选。') }}</p>
            <div id="selected-products-preview" class="pf-relation-box">
                @forelse(($selectedProducts ?? []) as $p)
                    <span class="pf-tag pf-tag-prod" style="margin:0 6px 6px 0;">#{{ $p->id }} {{ $p->name }}</span>
                @empty
                    <span class="pf-relation-empty">{{ __('未选择产品') }}</span>
                @endforelse
            </div>
            <div id="product-ids-inputs">
                @foreach(($selectedProductIds ?? []) as $pid)
                    <input type="hidden" name="product_ids[]" value="{{ (int)$pid }}">
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- 分类弹框 --}}
<div id="category-modal" style="display:none;">
    <div class="pf-modal-body layui-form">
        <div class="pf-modal-tools">
            <input type="text" id="category-filter-keyword" class="layui-input" placeholder="{{ __('筛选分类名称') }}" style="flex:1;min-width:180px;border-radius:8px;">
        </div>
        <div id="category-modal-tree" class="pf-modal-list"></div>
        <div class="pf-modal-footer">
            <button type="button" class="layui-btn pf-btn pf-btn-ghost" id="category-modal-cancel">{{ __('取消') }}</button>
            <button type="button" class="layui-btn pf-btn pf-btn-primary" id="category-modal-ok">{{ __('确定') }}</button>
        </div>
    </div>
</div>

{{-- 产品弹框 --}}
<div id="product-modal" style="display:none;">
    <div class="pf-modal-body layui-form">
        <div class="pf-modal-tools">
            <input type="text" id="product-search-keyword" class="layui-input" placeholder="{{ __('搜索产品ID/名称') }}" style="flex:1;min-width:160px;border-radius:8px;">
            <div class="layui-inline" style="min-width:200px;">
                <select id="product-search-category" lay-search>
                    <option value="0">{{ __('全部分类') }}</option>
                    @foreach(($flatCategories ?? []) as $fc)
                        <option value="{{ $fc['id'] }}">{{ $fc['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="layui-btn pf-btn pf-btn-primary" id="product-search-btn">{{ __('搜索') }}</button>
        </div>
        <div id="product-modal-list" class="pf-modal-list"></div>
        <div class="pf-modal-footer">
            <button type="button" class="layui-btn pf-btn pf-btn-ghost" id="product-modal-cancel">{{ __('取消') }}</button>
            <button type="button" class="layui-btn pf-btn pf-btn-primary" id="product-modal-ok">{{ __('确定') }}</button>
        </div>
    </div>
</div>
