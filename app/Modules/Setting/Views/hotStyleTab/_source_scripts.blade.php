<script>
    layui.use(['form', 'element'], function () {
        var form = layui.form;
        var element = layui.element;
        var $ = layui.$;
        form.render();
        element.render();

        function toggleSourceBoxes(type) {
            if (type === 'category') {
                $('#flag_source_box').hide();
                $('#category_source_box').show();
            } else {
                $('#category_source_box').hide();
                $('#flag_source_box').show();
            }
        }

        form.on('select(source_type)', function (data) {
            toggleSourceBoxes(data.value);
        });

        form.on('select(product_category_id)', function (data) {
            fillFromCategory(data.value);
            loadCategoryProducts(data.value);
        });

        // lay-search 下拉有时不会触发 form.on('select')，点选项时再补一次
        document.addEventListener('click', function (e) {
            var node = e.target;
            if (!node || !node.closest) {
                return;
            }
            var dd = node.closest('dd[lay-value]');
            if (!dd) {
                return;
            }
            var box = dd.closest('.layui-form-select');
            var select = box ? box.previousElementSibling : null;
            if (!select || select.id !== 'product_category_id') {
                return;
            }
            var categoryId = dd.getAttribute('lay-value');
            if (!categoryId) {
                return;
            }
            fillFromCategory(categoryId);
        }, true);

        var categoryNames = @json(collect($categories ?? [])->mapWithKeys(function ($cat) {
            return [(string)$cat->id => (string)($cat->name ?? '')];
        }));

        $('#hot_tab_select_all').on('click', function () {
            setCategoryProductsChecked(true);
        });
        $('#hot_tab_unselect_all').on('click', function () {
            setCategoryProductsChecked(false);
        });

        function fillFromCategory(categoryId) {
            categoryId = String(categoryId || '');
            var name = $.trim(categoryNames[categoryId] || '');
            if (!name) {
                var $opt = $('#product_category_id option[value="' + categoryId.replace(/"/g, '\\"') + '"]');
                name = $.trim($opt.attr('data-name') || $opt.text() || '');
                name = name.replace(/^--\s*/, '').replace(/\s*\(#\d+\)\s*$/, '');
            }
            if (!name) {
                return;
            }
            var tabKey = name.replace(/\s+/g, '').replace(/[^0-9A-Za-z\u4e00-\u9fff]/g, '').toLowerCase();
            var keyInput = document.querySelector('input[name="tab_key"]');
            if (keyInput && tabKey) {
                keyInput.value = tabKey;
            }
            var labels = document.querySelectorAll('input.layui-input');
            for (var i = 0; i < labels.length; i++) {
                if (/^translate\[[^\]]+\]\[label\]$/.test(labels[i].name || '')) {
                    labels[i].value = name;
                }
            }
        }

        function setCategoryProductsChecked(checked) {
            var $inputs = $('#category_products_box input[name="product_ids[]"]');
            if (!$inputs.length) {
                return;
            }
            $inputs.prop('checked', checked);
            form.render('checkbox');
        }

        function loadCategoryProducts(categoryId) {
            var $box = $('#category_products_box');
            if (!categoryId) {
                $box.html('<div style="color:#999;">{{ __('请先选择产品分类') }}</div>');
                form.render('checkbox');
                return;
            }
            $box.html('<div style="color:#999;">{{ __('加载中...') }}</div>');
            var selected = [];
            $('input[name="product_ids[]"]:checked').each(function () {
                selected.push($(this).val());
            });
            $.get('{{ route('admin.hotStyleTab.productsByCategory') }}', {
                category_id: categoryId,
                selected: selected.join(',')
            }, function (res) {
                if (!res || res.code !== 0) {
                    $box.html('<div style="color:#f56c6c;">{{ __('加载失败') }}</div>');
                    return;
                }
                var list = res.data || [];
                if (!list.length) {
                    $box.html('<div style="color:#999;">{{ __('该分类下暂无启用产品') }}</div>');
                    form.render('checkbox');
                    return;
                }
                var html = '';
                for (var i = 0; i < list.length; i++) {
                    var item = list[i];
                    var checked = item.checked ? ' checked' : '';
                    html += '<input type="checkbox" name="product_ids[]" value="' + item.id + '" title="#' + item.id + ' ' + (item.name || '') + '" lay-skin="primary"' + checked + '>';
                }
                $box.html(html);
                form.render('checkbox');
            }).fail(function () {
                $box.html('<div style="color:#f56c6c;">{{ __('加载失败') }}</div>');
            });
        }
    });
</script>
