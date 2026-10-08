<script>
(function () {
    var categoryTree = @json($categoryTree ?? []);
    var selectedCategoryIds = @json(array_values(array_map('intval', $selectedCategoryIds ?? [])));
    var selectedProductIds = @json(array_values(array_map('intval', $selectedProductIds ?? [])));
    var selectedProductMeta = @json(($selectedProducts ?? collect())->map(fn($p) => ['id' => (int)$p->id, 'name' => (string)$p->name])->values());
    var selectedCategoryMeta = @json(($selectedCategories ?? collect())->map(fn($c) => ['id' => (int)$c->id, 'name' => (string)$c->name])->values());

    var categoryLayerIndex = null;
    var productLayerIndex = null;
    var draftCategoryIds = selectedCategoryIds.slice();
    var draftProductMap = {}; // id -> name
    selectedProductMeta.forEach(function (p) { draftProductMap[p.id] = p.name; });

    function renderHiddenInputs(containerId, name, ids) {
        var box = document.getElementById(containerId);
        if (!box) return;
        box.innerHTML = '';
        ids.forEach(function (id) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = String(id);
            box.appendChild(input);
        });
    }

    function renderCategoryPreview() {
        var box = document.getElementById('selected-categories-preview');
        if (!box) return;
        if (!selectedCategoryIds.length) {
            box.innerHTML = '<span class="pf-relation-empty">{{ __('未选择分类') }}</span>';
            return;
        }
        var map = {};
        selectedCategoryMeta.forEach(function (c) { map[c.id] = c.name; });
        box.innerHTML = selectedCategoryIds.map(function (id) {
            return '<span class="pf-tag pf-tag-cat" style="margin:0 6px 6px 0;">#' + id + ' ' + (map[id] || '') + '</span>';
        }).join('');
    }

    function renderProductPreview() {
        var box = document.getElementById('selected-products-preview');
        if (!box) return;
        if (!selectedProductIds.length) {
            box.innerHTML = '<span class="pf-relation-empty">{{ __('未选择产品') }}</span>';
            return;
        }
        box.innerHTML = selectedProductIds.map(function (id) {
            return '<span class="pf-tag pf-tag-prod" style="margin:0 6px 6px 0;">#' + id + ' ' + (draftProductMap[id] || '') + '</span>';
        }).join('');
    }

    function collectCategoryNodes(nodes, acc) {
        (nodes || []).forEach(function (n) {
            acc.push(n);
            if (n.children && n.children.length) collectCategoryNodes(n.children, acc);
        });
        return acc;
    }

    function renderCategoryTree(filterKw) {
        var root = document.getElementById('category-modal-tree');
        if (!root) return;
        filterKw = (filterKw || '').toLowerCase();
        var html = '';
        function walk(nodes) {
            (nodes || []).forEach(function (n) {
                var name = String(n.name || '');
                var matchSelf = !filterKw || name.toLowerCase().indexOf(filterKw) >= 0;
                var childHtml = '';
                if (n.children && n.children.length) {
                    // temp buffer
                    var before = html;
                    html = '';
                    walk(n.children);
                    childHtml = html;
                    html = before;
                }
                if (!matchSelf && !childHtml) return;
                var checked = draftCategoryIds.indexOf(parseInt(n.id, 10)) >= 0 ? ' checked' : '';
                var pad = (parseInt(n.depth, 10) || 0) * 18;
                html += '<div class="pf-cat-item" data-id="' + n.id + '" data-name="' + name.replace(/"/g, '&quot;') + '" style="padding-left:' + pad + 'px;margin:4px 0;">';
                html += '<input type="checkbox" lay-skin="primary" title="#' + n.id + ' ' + name + '" value="' + n.id + '"' + checked + ' class="pf-cat-check">';
                html += '</div>';
                html += childHtml;
            });
        }
        walk(categoryTree);
        root.innerHTML = html || '<div class="pf-relation-empty">{{ __('暂无产品分类') }}</div>';
        if (window.layui && layui.form) layui.form.render('checkbox');
    }

    function collectCheckedCategoryIds() {
        var ids = [];
        var meta = [];
        document.querySelectorAll('#category-modal-tree .pf-cat-check:checked').forEach(function (el) {
            var id = parseInt(el.value, 10);
            if (!id) return;
            ids.push(id);
            var item = el.closest('.pf-cat-item');
            meta.push({ id: id, name: item ? (item.getAttribute('data-name') || '') : '' });
        });
        return { ids: ids, meta: meta };
    }

    function openCategoryModal() {
        draftCategoryIds = selectedCategoryIds.slice();
        renderCategoryTree('');
        categoryLayerIndex = layer.open({
            type: 1,
            title: '{{ __('选择关联分类（可多选）') }}',
            area: ['640px', '620px'],
            content: $('#category-modal'),
            success: function () {
                renderCategoryTree(document.getElementById('category-filter-keyword').value || '');
            }
        });
    }

    function renderProductList(list) {
        var root = document.getElementById('product-modal-list');
        if (!root) return;
        if (!list || !list.length) {
            root.innerHTML = '<div class="pf-relation-empty">{{ __('暂无产品') }}</div>';
            if (window.layui && layui.form) layui.form.render('checkbox');
            return;
        }
        root.innerHTML = list.map(function (p) {
            var checked = (draftProductMap.hasOwnProperty(String(p.id)) || draftProductMap.hasOwnProperty(p.id)) ? ' checked' : '';
            if (!checked && Object.keys(draftProductMap).map(Number).indexOf(parseInt(p.id, 10)) >= 0) checked = ' checked';
            return '<div style="margin:4px 0;"><input type="checkbox" class="pf-product-check" lay-skin="primary" value="' + p.id + '" data-name="' + String(p.name || '').replace(/"/g, '&quot;') + '" title="#' + p.id + ' ' + String(p.name || '') + '"' + checked + '></div>';
        }).join('');
        if (window.layui && layui.form) layui.form.render('checkbox');
    }

    function loadProducts() {
        var kw = document.getElementById('product-search-keyword').value || '';
        var cat = document.getElementById('product-search-category').value || 0;
        var loading = layer.load(1);
        $.ajax({
            url: '{{ route('admin.productFaq.searchProducts') }}',
            type: 'GET',
            data: {
                keyword: kw,
                category_id: cat,
                selected_ids: Object.keys(draftProductMap).map(Number)
            },
            success: function (res) {
                layer.close(loading);
                renderProductList((res && res.data) || []);
            },
            error: function () {
                layer.close(loading);
                layer.msg('{{ __('加载产品失败') }}');
            }
        });
    }

    function openProductModal() {
        draftProductMap = {};
        selectedProductIds.forEach(function (id) {
            var found = selectedProductMeta.find(function (p) { return parseInt(p.id, 10) === parseInt(id, 10); });
            draftProductMap[id] = found ? found.name : '';
        });
        productLayerIndex = layer.open({
            type: 1,
            title: '{{ __('选择关联产品（可多选）') }}',
            area: ['720px', '680px'],
            content: $('#product-modal'),
            success: function () {
                if (window.layui && layui.form) layui.form.render('select');
                loadProducts();
            }
        });
    }

    function syncDraftProductsFromChecks() {
        // Keep previously selected that are not in current list, merge with checked
        var currentListIds = [];
        document.querySelectorAll('#product-modal-list .pf-product-check').forEach(function (el) {
            var id = parseInt(el.value, 10);
            currentListIds.push(id);
            if (el.checked) {
                draftProductMap[id] = el.getAttribute('data-name') || draftProductMap[id] || '';
            } else {
                delete draftProductMap[id];
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderCategoryPreview();
        renderProductPreview();
        renderHiddenInputs('category-ids-inputs', 'category_ids[]', selectedCategoryIds);
        renderHiddenInputs('product-ids-inputs', 'product_ids[]', selectedProductIds);

        var btnCat = document.getElementById('btn-open-category-modal');
        var btnProd = document.getElementById('btn-open-product-modal');
        if (btnCat) btnCat.addEventListener('click', openCategoryModal);
        if (btnProd) btnProd.addEventListener('click', openProductModal);

        var catFilter = document.getElementById('category-filter-keyword');
        if (catFilter) {
            catFilter.addEventListener('input', function () {
                renderCategoryTree(this.value || '');
            });
        }

        document.getElementById('category-modal-cancel').addEventListener('click', function () {
            if (categoryLayerIndex != null) layer.close(categoryLayerIndex);
        });
        document.getElementById('category-modal-ok').addEventListener('click', function () {
            var result = collectCheckedCategoryIds();
            selectedCategoryIds = result.ids;
            selectedCategoryMeta = result.meta;
            renderHiddenInputs('category-ids-inputs', 'category_ids[]', selectedCategoryIds);
            renderCategoryPreview();
            if (categoryLayerIndex != null) layer.close(categoryLayerIndex);
        });

        document.getElementById('product-search-btn').addEventListener('click', function () {
            syncDraftProductsFromChecks();
            loadProducts();
        });
        document.getElementById('product-modal-cancel').addEventListener('click', function () {
            if (productLayerIndex != null) layer.close(productLayerIndex);
        });
        document.getElementById('product-modal-ok').addEventListener('click', function () {
            syncDraftProductsFromChecks();
            selectedProductIds = Object.keys(draftProductMap).map(function (k) { return parseInt(k, 10); }).filter(Boolean);
            selectedProductMeta = selectedProductIds.map(function (id) {
                return { id: id, name: draftProductMap[id] || '' };
            });
            renderHiddenInputs('product-ids-inputs', 'product_ids[]', selectedProductIds);
            renderProductPreview();
            if (productLayerIndex != null) layer.close(productLayerIndex);
        });

        // Parent/child cascade for category checks
        document.addEventListener('click', function (e) {
            var el = e.target;
            if (!el || !el.classList || !el.classList.contains('pf-cat-check')) return;
            // after layui may wrap; use change via form.on below
        });
    });

    layui.use(['form', 'jquery'], function () {
        var form = layui.form;
        var $ = layui.$;
        form.on('checkbox', function (data) {
            var el = data.elem;
            if (!el || !el.classList.contains('pf-cat-check')) return;
            var item = el.closest('.pf-cat-item');
            if (!item) return;
            var id = parseInt(el.value, 10);
            var checked = !!el.checked;
            // toggle children by depth order in DOM
            var nodes = Array.prototype.slice.call(document.querySelectorAll('#category-modal-tree .pf-cat-item'));
            var start = nodes.indexOf(item);
            if (start < 0) return;
            var startDepth = parseInt((categoryTreeFindDepth(id) || 0), 10);
            for (var i = start + 1; i < nodes.length; i++) {
                var d = parseInt(nodes[i].style.paddingLeft || '0', 10) / 18;
                if (d <= startDepth) break;
                var cb = nodes[i].querySelector('.pf-cat-check');
                if (cb) {
                    cb.checked = checked;
                }
            }
            form.render('checkbox');
        });

        function categoryTreeFindDepth(id) {
            var found = null;
            function walk(nodes) {
                (nodes || []).forEach(function (n) {
                    if (parseInt(n.id, 10) === id) found = n.depth;
                    if (!found) walk(n.children);
                });
            }
            walk(categoryTree);
            return found;
        }
    });
})();
</script>
