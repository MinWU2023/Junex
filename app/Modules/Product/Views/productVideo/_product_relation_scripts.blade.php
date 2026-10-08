<script>
(function () {
    function getSelectedIds() {
        var ids = [];
        document.querySelectorAll('#pv-product-list input[type="checkbox"][name="products[]"]:checked').forEach(function (el) {
            ids.push(parseInt(el.value, 10));
        });
        return ids;
    }

    function refreshPreview() {
        var box = document.getElementById('pv-selected-preview');
        var countEl = document.getElementById('pv-product-selected-count');
        if (!box) return;
        var checked = document.querySelectorAll('#pv-product-list input[type="checkbox"][name="products[]"]:checked');
        if (countEl) countEl.textContent = String(checked.length);
        if (!checked.length) {
            box.innerHTML = '<span style="color:#999;">{{ __('未选择产品') }}</span>';
            return;
        }
        var html = '';
        checked.forEach(function (el) {
            var title = el.getAttribute('title') || ('#' + el.value);
            html += '<span class="layui-badge-rim" style="margin:0 6px 6px 0;display:inline-block;">' + title + '</span>';
        });
        box.innerHTML = html;
    }

    function filterList(kw) {
        kw = String(kw || '').trim().toLowerCase();
        document.querySelectorAll('#pv-product-list .pv-product-row').forEach(function (row) {
            if (!kw) {
                row.style.display = '';
                return;
            }
            var id = String(row.getAttribute('data-id') || '');
            var name = String(row.getAttribute('data-name') || '');
            row.style.display = (id.indexOf(kw) >= 0 || name.indexOf(kw) >= 0) ? '' : 'none';
        });
    }

    function renderProductRows(list, selectedIds) {
        var root = document.getElementById('pv-product-list');
        if (!root) return;
        selectedIds = selectedIds || getSelectedIds();
        if (!list || !list.length) {
            root.innerHTML = '<div style="color:#999;">{{ __('暂无产品') }}</div>';
            if (window.layui && layui.form) layui.form.render('checkbox');
            return;
        }
        root.innerHTML = list.map(function (p) {
            var id = parseInt(p.id, 10);
            var name = String(p.name || '');
            var checked = selectedIds.indexOf(id) >= 0 || p.checked ? ' checked' : '';
            return '<div class="pv-product-row" data-id="' + id + '" data-name="' + name.toLowerCase().replace(/"/g, '&quot;') + '" style="margin-bottom:6px;">' +
                '<input type="checkbox" name="products[]" value="' + id + '" title="#' + id + ' ' + name.replace(/"/g, '&quot;') + '"' +
                ' lay-filter="pv-product-check"' + checked + '></div>';
        }).join('');
        if (window.layui && layui.form) {
            layui.form.render('checkbox');
        }
        refreshPreview();
    }

    function remoteSearch() {
        var input = document.getElementById('pv-product-filter');
        var kw = input ? String(input.value || '').trim() : '';
        if (!kw) {
            if (window.layui && layui.layer) {
                layui.layer.msg('{{ __('请输入关键词') }}');
            }
            return;
        }
        var loading = window.layui && layui.layer ? layui.layer.load(1) : null;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '{{ route('admin.productVideo.searchProducts') }}?keyword=' + encodeURIComponent(kw) + '&' +
            getSelectedIds().map(function (id) { return 'selected_ids[]=' + encodeURIComponent(id); }).join('&'));
        xhr.onload = function () {
            if (loading && layui.layer) layui.layer.close(loading);
            try {
                var res = JSON.parse(xhr.responseText || '{}');
                renderProductRows((res && res.data) || [], getSelectedIds());
            } catch (e) {
                if (window.layui && layui.layer) layui.layer.msg('{{ __('加载产品失败') }}');
            }
        };
        xhr.onerror = function () {
            if (loading && layui.layer) layui.layer.close(loading);
            if (window.layui && layui.layer) layui.layer.msg('{{ __('加载产品失败') }}');
        };
        xhr.send();
    }

    layui.use(['form'], function () {
        var form = layui.form;
        form.on('checkbox(pv-product-check)', function () {
            refreshPreview();
        });
        form.render('checkbox');
        refreshPreview();
    });

    var input = document.getElementById('pv-product-filter');
    if (input) {
        input.addEventListener('input', function () {
            filterList(input.value);
        });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                remoteSearch();
            }
        });
    }

    var searchBtn = document.getElementById('pv-product-remote-search');
    if (searchBtn) {
        searchBtn.addEventListener('click', remoteSearch);
    }

    var clearBtn = document.getElementById('pv-product-clear');
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            document.querySelectorAll('#pv-product-list input[type="checkbox"][name="products[]"]').forEach(function (el) {
                el.checked = false;
            });
            if (window.layui && layui.form) {
                layui.form.render('checkbox');
            }
            refreshPreview();
        });
    }
})();
</script>
