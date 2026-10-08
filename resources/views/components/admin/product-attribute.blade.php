@php
    $defaultLocale = config('app.locale');
    $optionAttributes = collect($productAttribute)->values();

    $selectedValuesByAttr = [];
    if ($productAttributeValues && count($productAttributeValues)) {
        foreach ($productAttributeValues as $productAttributeValue) {
            $attrId = $productAttributeValue->product_attribute_id;
            $valueName = $productAttributeValue->translate($defaultLocale)->name
                ?? $productAttributeValue->name
                ?? '';
            $valueName = trim((string)$valueName);
            if ($valueName === '') {
                continue;
            }
            if (!isset($selectedValuesByAttr[$attrId])) {
                $selectedValuesByAttr[$attrId] = [];
            }
            if (!in_array($valueName, $selectedValuesByAttr[$attrId], true)) {
                $selectedValuesByAttr[$attrId][] = $valueName;
            }
        }
    }
@endphp

<div class="layui-card product-attribute-card">
    <div class="layui-card-body">
        @if($optionAttributes->isNotEmpty())
            <div class="product-attr-multi-section">
                @foreach($optionAttributes as $v)
                    @php
                        $options = array_values(array_filter(array_map('trim', explode(',', (string)$v->options))));
                        $selected = $selectedValuesByAttr[$v->id] ?? [];
                        if (empty($selected) && !empty($v->default)) {
                            $defaultParts = array_values(array_filter(array_map('trim', explode(',', (string)$v->default))));
                            $selected = empty($options)
                                ? $defaultParts
                                : array_values(array_intersect($defaultParts, $options));
                        }
                        $available = array_values(array_diff($options, $selected));
                    @endphp
                    <div class="clearfix product-attr-multi-item"
                         data-attr-id="{{ $v->id }}"
                         data-bind-url="{{ route('admin.product.attribute.bindValues', $v->id) }}"
                         data-options='@json($options)'>
                        <label class="layui-form-label">
                            @isset($v->translate($defaultLocale)->name)
                                {{ $v->translate($defaultLocale)->name }}
                            @else
                                {{ $v->name }}
                            @endif
                        </label>
                        <div class="layui-input-block" style="margin-top:20px;">
                            <div class="product-attr-tags-container">
                                <div class="product-attr-tags-display">
                                    @foreach($selected as $selectedValue)
                                        <span class="layui-badge product-attr-tag-item" data-value="{{ $selectedValue }}" style="background-color:#009688;color:#fff;height:auto;line-height:1.4;padding:4px 10px;font-size:13px;">
                                            {{ $selectedValue }}
                                            <i class="layui-icon layui-icon-close product-attr-tag-remove" title="{{ __('删除') }}"></i>
                                        </span>
                                    @endforeach
                                </div>
                                <select class="product-attr-value-select layui-input" lay-ignore>
                                    <option value="">{{ __('请选择属性值（可多选）') }}</option>
                                    @foreach($available as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                <input type="text"
                                       class="product-attr-bind-input layui-input"
                                       placeholder="{{ __('输入属性值，逗号分隔，回车绑定') }}"
                                       autocomplete="off">
                                <input type="hidden"
                                       class="product-attr-values-hidden"
                                       name="translate[attributes][{{ $v->id }}]"
                                       value="{{ implode(',', $selected) }}">
                            </div>
                            <div class="layui-form-mid layui-word-aux">{{ __('可多选：从下拉选择添加；也可在下方输入框用逗号分隔后回车绑定新属性值。点击标签 × 删除') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($optionAttributes->isEmpty())
            <div class="layui-word-aux" style="padding: 10px 0;">{{ __('请先选择属性分类') }}</div>
        @endif
    </div>
</div>

<style>
    .product-attr-tags-container {
        border: 1px solid #e6e6e6;
        border-radius: 2px;
        padding: 8px;
        min-height: 38px;
        background: #fff;
    }
    .product-attr-tags-display {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 8px;
        min-height: 28px;
    }
    .product-attribute-card .product-attr-tag-item,
    .product-attr-multi-item .product-attr-tag-item {
        display: inline-flex !important;
        align-items: center;
        height: auto !important;
        line-height: 1.4 !important;
        padding: 4px 10px !important;
        background-color: #009688 !important;
        color: #fff !important;
        border-radius: 2px;
        font-size: 13px;
    }
    .product-attr-tag-remove {
        margin-left: 6px;
        cursor: pointer;
        font-size: 12px;
        opacity: 0.9;
    }
    .product-attr-tag-remove:hover {
        color: #ff5722;
        opacity: 1;
    }
    .product-attr-value-select {
        width: 100%;
        height: 38px;
        border: 1px solid #e6e6e6;
        border-radius: 2px;
        padding: 0 10px;
        background: #fff;
    }
    .product-attr-bind-input {
        width: 100%;
        margin-top: 8px;
    }
</style>

<script>
(function () {
    function jq() {
        if (window.layui && layui.$) return layui.$;
        if (window.jQuery) return window.jQuery;
        return null;
    }

    function parseOptions($item) {
        var raw = $item.attr('data-options') || '[]';
        try {
            var list = JSON.parse(raw);
            return Array.isArray(list) ? list : [];
        } catch (e) {
            return [];
        }
    }

    function getSelectedValues($item) {
        var $ = jq();
        return $item.find('.product-attr-tag-item').map(function () {
            return $(this).attr('data-value');
        }).get();
    }

    function syncHidden($item) {
        $item.find('.product-attr-values-hidden').val(getSelectedValues($item).join(','));
    }

    function rebuildSelect($item) {
        var $ = jq();
        var selected = getSelectedValues($item);
        var allOptions = parseOptions($item);
        var $select = $item.find('select.product-attr-value-select');
        var placeholder = $select.find('option:first').text() || '';
        $select.empty();
        $select.append($('<option></option>').attr('value', '').text(placeholder || '请选择属性值（可多选）'));
        allOptions.forEach(function (opt) {
            if (selected.indexOf(opt) === -1) {
                $select.append($('<option></option>').attr('value', opt).text(opt));
            }
        });
        $select.val('');
    }

    function setOptions($item, options) {
        if (!Array.isArray(options)) return;
        $item.attr('data-options', JSON.stringify(options));
        rebuildSelect($item);
    }

    function csrfToken() {
        var $ = jq();
        var token = $('meta[name="csrf-token"]').attr('content');
        if (!token) {
            token = $('input[name="_token"]').val() || '';
        }
        return token || '';
    }

    function toast(msg, icon) {
        if (window.layui && layui.layer) {
            layui.layer.msg(msg, {icon: icon || 1, time: 1500});
            return;
        }
        if (window.layer) {
            layer.msg(msg, {icon: icon || 1, time: 1500});
        }
    }

    function bindTypedValues($item, raw) {
        var $ = jq();
        var $input = $item.find('.product-attr-bind-input');
        var url = $item.attr('data-bind-url');
        raw = $.trim(raw || '');
        if (!raw || !url) return;
        if ($item.data('binding')) return;

        $item.data('binding', true);
        $input.prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                values: raw,
                _token: csrfToken()
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (res) {
                var payload = (res && res.data) ? res.data : {};
                if (payload.options) {
                    setOptions($item, payload.options);
                }
                var values = Array.isArray(payload.values) ? payload.values : [];
                values.forEach(function (value) {
                    addTag($item, value);
                });
                $input.val('');
                var created = Array.isArray(payload.created) ? payload.created.length : 0;
                toast(created > 0 ? ('绑定成功，新增 ' + created + ' 个属性值') : '绑定成功');
            },
            error: function (xhr) {
                var msg = '绑定失败';
                try {
                    var body = JSON.parse(xhr.responseText || '{}');
                    msg = body.message || body.msg || msg;
                } catch (e) {}
                toast(msg, 2);
            },
            complete: function () {
                $item.data('binding', false);
                $input.prop('disabled', false).focus();
            }
        });
    }

    function addTag($item, value) {
        var $ = jq();
        value = $.trim(value || '');
        if (!value) return;
        var selected = getSelectedValues($item);
        if (selected.indexOf(value) !== -1) {
            rebuildSelect($item);
            return;
        }
        var $tag = $('<span class="layui-badge product-attr-tag-item"></span>')
            .attr('data-value', value)
            .attr('style', 'background-color:#009688;color:#fff;height:auto;line-height:1.4;padding:4px 10px;font-size:13px;')
            .append(document.createTextNode(value + ' '))
            .append($('<i class="layui-icon layui-icon-close product-attr-tag-remove"></i>'));
        $item.find('.product-attr-tags-display').append($tag);
        syncHidden($item);
        rebuildSelect($item);
    }

    function removeTag($tag) {
        var $item = $tag.closest('.product-attr-multi-item');
        $tag.remove();
        syncHidden($item);
        rebuildSelect($item);
    }

    function ensureTagStyles() {
        if (document.getElementById('product-attr-tag-style')) return;
        var css = '.product-attribute-card .product-attr-tag-item,.product-attr-multi-item .product-attr-tag-item{display:inline-flex!important;align-items:center;height:auto!important;line-height:1.4!important;padding:4px 10px!important;background-color:#009688!important;color:#fff!important;border-radius:2px;font-size:13px}.product-attr-tag-remove{margin-left:6px;cursor:pointer;color:#fff!important}';
        var style = document.createElement('style');
        style.id = 'product-attr-tag-style';
        style.type = 'text/css';
        style.appendChild(document.createTextNode(css));
        document.head.appendChild(style);
    }

    window.initProductAttributeMultiSelect = function () {
        var $ = jq();
        ensureTagStyles();
        if (!$) return;
        $('.product-attr-multi-item').each(function () {
            var $item = $(this);
            syncHidden($item);
            rebuildSelect($item);
        });
    };

    function bindEvents() {
        var $ = jq();
        if (!$) return;

        $(document)
            .off('change.productAttrMulti', 'select.product-attr-value-select')
            .on('change.productAttrMulti', 'select.product-attr-value-select', function () {
                var $select = $(this);
                var value = $select.val();
                var $item = $select.closest('.product-attr-multi-item');
                if (!value) return;
                addTag($item, value);
            });

        $(document)
            .off('click.productAttrTagRemove', '.product-attr-tag-remove')
            .on('click.productAttrTagRemove', '.product-attr-tag-remove', function (e) {
                e.preventDefault();
                e.stopPropagation();
                removeTag($(this).closest('.product-attr-tag-item'));
            });

        $(document)
            .off('keydown.productAttrBind', '.product-attr-bind-input')
            .on('keydown.productAttrBind', '.product-attr-bind-input', function (e) {
                if (e.isComposing || e.keyCode === 229) return;
                if (e.key !== 'Enter' && e.keyCode !== 13) return;
                e.preventDefault();
                e.stopPropagation();
                var $input = $(this);
                var $item = $input.closest('.product-attr-multi-item');
                bindTypedValues($item, $input.val());
            });

        window.initProductAttributeMultiSelect();
    }

    // 组件经 AJAX 插入时 script 可能不执行，由 product.js 再调 init；
    // 这里尽量自执行，并在 layui 就绪后绑定。
    if (window.layui) {
        layui.use(['form'], function () {
            bindEvents();
        });
    } else if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindEvents);
    } else {
        bindEvents();
    }
})();
</script>
