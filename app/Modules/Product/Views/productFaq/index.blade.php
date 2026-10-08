<x-layui-layout>
    <body>
    <div class="layui-fluid pf-page">
        <div class="layui-card">
            <div class="layui-card-body">
                @include('Product.Views.productFaq._styles')

                @if(session('success') || session('error') || $errors->any())
                    <div id="status-message" class="pf-alert {{ session('success') ? 'pf-alert-success' : 'pf-alert-error' }}">
                        <i class="layui-icon {{ session('success') ? 'layui-icon-ok-circle' : 'layui-icon-close-fill' }}"></i>
                        <div>
                            @if(session('success'))
                                {{ session('success') }}
                            @elseif(session('error'))
                                {{ session('error') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </div>
                    </div>
                @endif

                <div class="pf-hero">
                    <div class="pf-hero-main">
                        <span class="pf-hero-kicker"><i class="layui-icon layui-icon-dialogue"></i>{{ __('产品管理') }}</span>
                        <h1 class="pf-hero-title">{{ __('产品Faqs') }}</h1>
                        <p class="pf-hero-desc">{{ __('管理产品详情页 FAQ：支持多语言、关联分类/产品，并可从 Faqs 管理同步数据。') }}</p>
                    </div>
                    <div class="pf-hero-actions">
                        <a class="layui-btn pf-btn pf-btn-primary" href="{{ route('admin.productFaq.create') }}">
                            <i class="layui-icon layui-icon-add-1"></i> {{ __('添加问答') }}
                        </a>
                        <button type="button" class="layui-btn pf-btn pf-btn-danger" id="btn-batch-destroy">
                            <i class="layui-icon layui-icon-delete"></i> {{ __('批量删除') }}
                        </button>
                        <a class="layui-btn pf-btn pf-btn-ghost" href="{{ route('admin.faq.index') }}">{{ __('Faqs管理') }}</a>
                    </div>
                </div>

                <form class="layui-form pf-toolbar" method="get" action="{{ route('admin.productFaq.index') }}" id="product-faq-filter">
                    <div class="pf-toolbar-left">
                        <span class="pf-search-label">{{ __('问题') }}</span>
                        <input class="layui-input pf-search-input" name="subject" value="{{ $subject ?? '' }}" placeholder="{{ __('输入问题关键词') }}" autocomplete="off">
                        <input type="hidden" value="{{ csrf_token() }}" id="token">
                        <button class="layui-btn pf-btn pf-btn-primary" type="submit">{{ __('搜索') }}</button>
                        @if(!empty($subject))
                            <a class="layui-btn pf-btn pf-btn-ghost" href="{{ route('admin.productFaq.index') }}">{{ __('重置') }}</a>
                        @endif
                    </div>
                    <div class="pf-toolbar-right">
                        <button class="layui-btn pf-btn pf-btn-soft" type="button" id="btn-sync-faqs">{{ __('同步Faqs') }}</button>
                        <button class="layui-btn pf-btn pf-btn-ghost" type="button" id="btn-export">{{ __('导出') }}</button>
                        <button class="layui-btn pf-btn pf-btn-ghost" type="button" id="btn-import">{{ __('导入') }}</button>
                        <input type="file" id="import-file" accept=".xlsx,.xls,.csv" style="display:none;">
                    </div>
                </form>

                <div class="pf-table-wrap">
                    <table class="layui-table pf-table" id="product-faq-table" lay-skin="line">
                        <thead>
                        <tr>
                            <th style="width:44px;"><input type="checkbox" id="check-all"></th>
                            <th style="width:70px;">ID</th>
                            <th>{{ __('问题') }}</th>
                            <th>{{ __('关联分类') }}</th>
                            <th>{{ __('关联产品') }}</th>
                            <th style="width:80px;">{{ __('排序') }}</th>
                            <th style="width:90px;">{{ __('状态') }}</th>
                            <th style="width:140px;">{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($faqs as $faq)
                            <tr data-id="{{ $faq->id }}">
                                <td><input type="checkbox" class="row-check" value="{{ $faq->id }}"></td>
                                <td><span class="pf-id">{{ $faq->id }}</span></td>
                                <td>
                                    <div class="pf-subject">{{ $faq->subject }}</div>
                                    @if($faq->source_faq_id)
                                        <div class="pf-form-hint">{{ __('同步自 Faqs') }} #{{ $faq->source_faq_id }}</div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $catIds = $faq->categories->pluck('id')->map(fn($v)=>(int)$v)->values()->all();
                                        $catMeta = $faq->categories->map(fn($c)=>['id'=>(int)$c->id,'name'=>(string)$c->name])->values()->all();
                                    @endphp
                                    <div class="pf-rel-cell js-open-cat-modal"
                                         data-faq-id="{{ $faq->id }}"
                                         data-ids='@json($catIds)'
                                         data-meta='@json($catMeta)'
                                         title="{{ __('点击关联分类') }}">
                                        <button type="button" class="layui-btn layui-btn-xs pf-rel-btn">
                                            <i class="layui-icon layui-icon-link"></i>{{ __('关联分类') }}
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $prodIds = $faq->products->pluck('id')->map(fn($v)=>(int)$v)->values()->all();
                                        $prodMeta = $faq->products->map(fn($p)=>['id'=>(int)$p->id,'name'=>(string)$p->name])->values()->all();
                                    @endphp
                                    <div class="pf-rel-cell js-open-prod-modal"
                                         data-faq-id="{{ $faq->id }}"
                                         data-ids='@json($prodIds)'
                                         data-meta='@json($prodMeta)'
                                         title="{{ __('点击关联产品') }}">
                                        <button type="button" class="layui-btn layui-btn-xs pf-rel-btn">
                                            <i class="layui-icon layui-icon-cart"></i>{{ __('关联产品') }}
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <input type="number"
                                           class="layui-input js-pf-sort pf-sort-input"
                                           data-id="{{ $faq->id }}"
                                           value="{{ (int)$faq->sort }}"
                                           min="0"
                                           step="1"
                                           style="width:90px;height:32px;line-height:32px;border-radius:8px;"
                                           title="{{ __('回车或失焦保存') }}">
                                </td>
                                <td>
                                    @if((int)$faq->active === 1)
                                        <span class="pf-status pf-status-on">{{ __('启用') }}</span>
                                    @else
                                        <span class="pf-status pf-status-off">{{ __('禁用') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="pf-actions">
                                        <a class="layui-btn layui-btn-xs pf-btn pf-btn-primary" href="{{ route('admin.productFaq.edit', $faq->id) }}">{{ __('编辑') }}</a>
                                        <form method="post" action="{{ route('admin.productFaq.destroy', $faq->id) }}" style="display:inline;" onsubmit="return confirm('{{ __('确定删除？') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="layui-btn layui-btn-xs pf-btn pf-btn-danger" type="submit">{{ __('删除') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="pf-empty">
                                    <div class="pf-empty-icon"><i class="layui-icon layui-icon-dialogue"></i></div>
                                    <div>{{ __('暂无产品Faqs') }}</div>
                                    <div class="pf-form-hint" style="margin-top:6px;">{{ __('可点击「添加问答」，或从 Faqs 管理同步数据。') }}</div>
                                    <div style="margin-top:14px;">
                                        <a class="layui-btn pf-btn pf-btn-primary" href="{{ route('admin.productFaq.create') }}">{{ __('立即添加') }}</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pf-pagination">{{ $faqs->links('pagination.front') }}</div>
            </div>
        </div>
    </div>

    <form id="sync-form" method="post" action="{{ route('admin.productFaq.syncFromFaqs') }}" style="display:none;">@csrf</form>

    {{-- 列表页：关联分类弹框 --}}
    <div id="list-category-modal" style="display:none;">
        <div class="pf-modal-body layui-form">
            <div class="pf-modal-tools">
                <input type="text" id="list-category-filter-keyword" class="layui-input" placeholder="{{ __('筛选分类名称') }}" style="flex:1;min-width:180px;border-radius:8px;">
            </div>
            <div id="list-category-modal-tree" class="pf-modal-list"></div>
            <div class="pf-modal-footer">
                <button type="button" class="layui-btn layui-btn-primary pf-btn pf-btn-ghost" id="list-category-modal-cancel">{{ __('取消') }}</button>
                <button type="button" class="layui-btn layui-btn-normal pf-btn pf-btn-primary" id="list-category-modal-ok">{{ __('保存关联') }}</button>
            </div>
        </div>
    </div>

    {{-- 列表页：关联产品弹框 --}}
    <div id="list-product-modal" style="display:none;">
        <div class="pf-modal-body layui-form">
            <div class="pf-modal-tools">
                <input type="text" id="list-product-search-keyword" class="layui-input" placeholder="{{ __('搜索产品ID/名称') }}" style="flex:1;min-width:160px;border-radius:8px;">
                <div class="layui-inline" style="min-width:200px;">
                    <select id="list-product-search-category" lay-search>
                        <option value="0">{{ __('全部分类') }}</option>
                        @foreach(($flatCategories ?? []) as $fc)
                            <option value="{{ $fc['id'] }}">{{ $fc['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="layui-btn pf-btn pf-btn-primary" id="list-product-search-btn">{{ __('搜索') }}</button>
            </div>
            <div id="list-product-modal-list" class="pf-modal-list"></div>
            <div class="pf-modal-footer">
                <button type="button" class="layui-btn layui-btn-primary pf-btn pf-btn-ghost" id="list-product-modal-cancel">{{ __('取消') }}</button>
                <button type="button" class="layui-btn layui-btn-normal pf-btn pf-btn-primary" id="list-product-modal-ok">{{ __('保存关联') }}</button>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            layui.config({
                base: "{{ asset('ui/modules/') }}/"
            }).extend({
                excel: 'layui_exts/excel'
            });
            layui.use(['form', 'excel', 'jquery', 'layer'], function () {
                var form = layui.form, excel = layui.excel, $ = layui.$, layer = layui.layer;
                form.render();

                var token = $('#token').val();
                var categoryTree = @json($categoryTree ?? []);
                var currentFaqId = 0;
                var currentCell = null;
                var draftCategoryIds = [];
                var draftProductMap = {};
                var catLayerIndex = null;
                var prodLayerIndex = null;

                var statusMsg = document.getElementById('status-message');
                if (statusMsg) {
                    setTimeout(function () {
                        statusMsg.style.transition = 'opacity 0.5s ease';
                        statusMsg.style.opacity = '0';
                        setTimeout(function () { statusMsg.style.display = 'none'; }, 500);
                    }, 2500);
                }

                $('#check-all').on('change', function () {
                    $('.row-check').prop('checked', this.checked);
                });

                $('#btn-batch-destroy').on('click', function () {
                    var ids = [];
                    $('.row-check:checked').each(function () { ids.push(parseInt(this.value, 10)); });
                    if (!ids.length) {
                        layer.msg('{{ __('请先选择要删除的数据') }}');
                        return;
                    }
                    layer.confirm('{{ __('确定批量删除选中的') }} ' + ids.length + ' {{ __('条数据？') }}', function (index) {
                        layer.close(index);
                        var loading = layer.load(1);
                        $.ajax({
                            url: '{{ route('admin.productFaq.batchDestroy') }}',
                            type: 'POST',
                            data: { _token: token, ids: ids },
                            success: function (res) {
                                layer.close(loading);
                                if (res && res.code === 0) {
                                    layer.msg(res.msg || '{{ __('批量删除成功') }}', { time: 1200 }, function () {
                                        location.reload();
                                    });
                                } else {
                                    layer.msg((res && res.msg) || '{{ __('批量删除失败') }}');
                                }
                            },
                            error: function () {
                                layer.close(loading);
                                layer.msg('{{ __('批量删除失败') }}');
                            }
                        });
                    });
                });

                function saveProductFaqSort(input) {
                    var id = parseInt(input.getAttribute('data-id'), 10) || 0;
                    var sort = parseInt(input.value, 10);
                    if (!id || isNaN(sort) || sort < 0) {
                        layer.msg('{{ __('排序值无效') }}');
                        return;
                    }
                    $.ajax({
                        url: "{{ route('admin.productFaq.updateSort', ['id' => '__ID__']) }}".replace('__ID__', id),
                        type: 'POST',
                        data: { _token: token, sort: sort },
                        success: function (res) {
                            if (res && res.code === 0) {
                                layer.msg(res.msg || '{{ __('排序已更新') }}', { time: 800 });
                                if (res.data && typeof res.data.sort !== 'undefined') {
                                    input.value = res.data.sort;
                                }
                            } else {
                                layer.msg((res && res.msg) || '{{ __('保存失败') }}');
                            }
                        },
                        error: function () {
                            layer.msg('{{ __('保存失败') }}');
                        }
                    });
                }

                $(document).on('change', '.js-pf-sort', function () {
                    saveProductFaqSort(this);
                });
                $(document).on('keydown', '.js-pf-sort', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.blur();
                    }
                });

                function parseJsonAttr(el, name) {
                    try { return JSON.parse(el.getAttribute(name) || '[]'); } catch (e) { return []; }
                }

                function findCatDepth(id) {
                    var found = null;
                    function walk(nodes) {
                        (nodes || []).forEach(function (n) {
                            if (parseInt(n.id, 10) === id) found = n.depth;
                            if (found == null) walk(n.children);
                        });
                    }
                    walk(categoryTree);
                    return found || 0;
                }

                function renderCategoryTree(filterKw) {
                    var root = document.getElementById('list-category-modal-tree');
                    if (!root) return;
                    filterKw = (filterKw || '').toLowerCase();
                    var html = '';
                    function walk(nodes) {
                        (nodes || []).forEach(function (n) {
                            var name = String(n.name || '');
                            var matchSelf = !filterKw || name.toLowerCase().indexOf(filterKw) >= 0;
                            var before = html;
                            html = '';
                            walk(n.children || []);
                            var childHtml = html;
                            html = before;
                            if (!matchSelf && !childHtml) return;
                            var checked = draftCategoryIds.indexOf(parseInt(n.id, 10)) >= 0 ? ' checked' : '';
                            var pad = (parseInt(n.depth, 10) || 0) * 18;
                            var title = ('#' + n.id + ' ' + name).replace(/"/g, '&quot;');
                            html += '<div class="pf-cat-item" data-id="' + n.id + '" data-name="' + name.replace(/"/g, '&quot;') + '" style="padding-left:' + pad + 'px;">';
                            html += '<input type="checkbox" lay-skin="primary" class="list-pf-cat-check" title="' + title + '" value="' + n.id + '"' + checked + '>';
                            html += '</div>' + childHtml;
                        });
                    }
                    walk(categoryTree);
                    root.innerHTML = html || '<div class="pf-relation-empty">{{ __('暂无产品分类') }}</div>';
                    form.render('checkbox');
                }

                function collectCheckedCategoryIds() {
                    var ids = [], meta = [];
                    document.querySelectorAll('#list-category-modal-tree .list-pf-cat-check:checked').forEach(function (el) {
                        var id = parseInt(el.value, 10);
                        if (!id) return;
                        ids.push(id);
                        var item = el.closest('.pf-cat-item');
                        meta.push({ id: id, name: item ? (item.getAttribute('data-name') || '') : '' });
                    });
                    return { ids: ids, meta: meta };
                }

                function openCategoryModal(cell) {
                    currentCell = cell;
                    currentFaqId = parseInt(cell.getAttribute('data-faq-id'), 10) || 0;
                    draftCategoryIds = parseJsonAttr(cell, 'data-ids').map(Number).filter(Boolean);
                    catLayerIndex = layer.open({
                        type: 1,
                        title: '{{ __('关联分类（可多选）') }} #' + currentFaqId,
                        area: ['640px', '620px'],
                        content: $('#list-category-modal'),
                        success: function (layero) {
                            layero.find('.layui-layer-content').css({
                                height: 'auto',
                                overflow: 'visible',
                                padding: '12px 15px 8px'
                            });
                            layero.find('.pf-modal-body').css({ height: '520px' });
                            renderCategoryTree(document.getElementById('list-category-filter-keyword').value || '');
                        }
                    });
                }

                function renderProductList(list) {
                    var root = document.getElementById('list-product-modal-list');
                    if (!root) return;
                    if (!list || !list.length) {
                        root.innerHTML = '<div class="pf-relation-empty">{{ __('暂无产品') }}</div>';
                        form.render('checkbox');
                        return;
                    }
                    root.innerHTML = list.map(function (p) {
                        var checked = draftProductMap.hasOwnProperty(String(p.id)) || draftProductMap.hasOwnProperty(p.id) ? ' checked' : '';
                        var name = String(p.name || '').replace(/"/g, '&quot;');
                        var title = ('#' + p.id + ' ' + String(p.name || '')).replace(/"/g, '&quot;');
                        return '<div style="margin:4px 0;"><input type="checkbox" class="list-pf-product-check" lay-skin="primary" value="' + p.id + '" data-name="' + name + '" title="' + title + '"' + checked + '></div>';
                    }).join('');
                    form.render('checkbox');
                }

                function syncDraftProductsFromChecks() {
                    document.querySelectorAll('#list-product-modal-list .list-pf-product-check').forEach(function (el) {
                        var id = parseInt(el.value, 10);
                        if (el.checked) {
                            draftProductMap[id] = el.getAttribute('data-name') || draftProductMap[id] || '';
                        } else {
                            delete draftProductMap[id];
                        }
                    });
                }

                function loadProducts() {
                    var kw = document.getElementById('list-product-search-keyword').value || '';
                    var cat = document.getElementById('list-product-search-category').value || 0;
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

                function openProductModal(cell) {
                    currentCell = cell;
                    currentFaqId = parseInt(cell.getAttribute('data-faq-id'), 10) || 0;
                    var ids = parseJsonAttr(cell, 'data-ids').map(Number).filter(Boolean);
                    var meta = parseJsonAttr(cell, 'data-meta');
                    draftProductMap = {};
                    ids.forEach(function (id) {
                        var found = meta.find(function (p) { return parseInt(p.id, 10) === id; });
                        draftProductMap[id] = found ? found.name : '';
                    });
                    prodLayerIndex = layer.open({
                        type: 1,
                        title: '{{ __('关联产品（可多选）') }} #' + currentFaqId,
                        area: ['720px', '680px'],
                        content: $('#list-product-modal'),
                        success: function (layero) {
                            layero.find('.layui-layer-content').css({
                                height: 'auto',
                                overflow: 'visible',
                                padding: '12px 15px 8px'
                            });
                            layero.find('.pf-modal-body').css({ height: '580px' });
                            form.render('select');
                            loadProducts();
                        }
                    });
                }

                $(document).on('click', '.js-open-cat-modal', function () {
                    openCategoryModal(this);
                });
                $(document).on('click', '.js-open-prod-modal', function () {
                    openProductModal(this);
                });

                $('#list-category-filter-keyword').on('input', function () {
                    renderCategoryTree(this.value || '');
                });
                $('#list-category-modal-cancel').on('click', function () {
                    if (catLayerIndex != null) layer.close(catLayerIndex);
                });
                $('#list-category-modal-ok').on('click', function () {
                    var result = collectCheckedCategoryIds();
                    var loading = layer.load(1);
                    $.ajax({
                        url: "{{ route('admin.productFaq.syncRelations', ['id' => '__ID__']) }}".replace('__ID__', currentFaqId),
                        type: 'POST',
                        data: {
                            _token: token,
                            type: 'categories',
                            category_ids: result.ids
                        },
                        success: function (res) {
                            layer.close(loading);
                            if (!res || res.code !== 0) {
                                layer.msg((res && res.msg) || '{{ __('保存失败') }}');
                                return;
                            }
                            if (currentCell) {
                                currentCell.setAttribute('data-ids', JSON.stringify(res.data.category_ids || []));
                                currentCell.setAttribute('data-meta', JSON.stringify(res.data.categories || []));
                            }
                            layer.msg(res.msg || '{{ __('关联已保存') }}');
                            if (catLayerIndex != null) layer.close(catLayerIndex);
                        },
                        error: function () {
                            layer.close(loading);
                            layer.msg('{{ __('保存失败') }}');
                        }
                    });
                });

                $('#list-product-search-btn').on('click', function () {
                    syncDraftProductsFromChecks();
                    loadProducts();
                });
                $('#list-product-modal-cancel').on('click', function () {
                    if (prodLayerIndex != null) layer.close(prodLayerIndex);
                });
                $('#list-product-modal-ok').on('click', function () {
                    syncDraftProductsFromChecks();
                    var ids = Object.keys(draftProductMap).map(Number).filter(Boolean);
                    var loading = layer.load(1);
                    $.ajax({
                        url: "{{ route('admin.productFaq.syncRelations', ['id' => '__ID__']) }}".replace('__ID__', currentFaqId),
                        type: 'POST',
                        data: {
                            _token: token,
                            type: 'products',
                            product_ids: ids
                        },
                        success: function (res) {
                            layer.close(loading);
                            if (!res || res.code !== 0) {
                                layer.msg((res && res.msg) || '{{ __('保存失败') }}');
                                return;
                            }
                            if (currentCell) {
                                currentCell.setAttribute('data-ids', JSON.stringify(res.data.product_ids || []));
                                currentCell.setAttribute('data-meta', JSON.stringify(res.data.products || []));
                            }
                            layer.msg(res.msg || '{{ __('关联已保存') }}');
                            if (prodLayerIndex != null) layer.close(prodLayerIndex);
                        },
                        error: function () {
                            layer.close(loading);
                            layer.msg('{{ __('保存失败') }}');
                        }
                    });
                });

                form.on('checkbox', function (data) {
                    var el = data.elem;
                    if (!el || !el.classList.contains('list-pf-cat-check')) return;
                    var item = el.closest('.pf-cat-item');
                    if (!item) return;
                    var id = parseInt(el.value, 10);
                    var checked = !!el.checked;
                    var nodes = Array.prototype.slice.call(document.querySelectorAll('#list-category-modal-tree .pf-cat-item'));
                    var start = nodes.indexOf(item);
                    if (start < 0) return;
                    var startDepth = findCatDepth(id);
                    for (var i = start + 1; i < nodes.length; i++) {
                        var d = parseInt(nodes[i].style.paddingLeft || '0', 10) / 18;
                        if (d <= startDepth) break;
                        var cb = nodes[i].querySelector('.list-pf-cat-check');
                        if (cb) cb.checked = checked;
                    }
                    form.render('checkbox');
                });

                $('#btn-sync-faqs').on('click', function () {
                    layer.confirm('{{ __('确定从 Faqs 管理同步问答数据？已同步过的将更新文案。') }}', function (index) {
                        layer.close(index);
                        $('#sync-form').submit();
                    });
                });

                $('#btn-export').on('click', function () {
                    var ids = [];
                    $('.row-check:checked').each(function () { ids.push(parseInt(this.value, 10)); });
                    var msg = ids.length ? '{{ __('确定导出选中数据？') }}' : '{{ __('确定导出全部数据？') }}';
                    layer.confirm(msg, function (index) {
                        layer.close(index);
                        var loading = layer.load();
                        $.ajax({
                            url: '{{ route('admin.productFaq.export') }}',
                            type: 'POST',
                            data: { _token: token, ids: ids, locale: '{{ config('app.locale') }}' },
                            success: function (res) {
                                layer.close(loading);
                                if (res && res.code === 0) {
                                    excel.exportExcel(res.data, '产品Faqs' + Date.now() + '.xlsx', 'xlsx');
                                    layer.msg('{{ __('导出成功') }}');
                                } else {
                                    layer.msg((res && res.msg) || '{{ __('导出失败') }}');
                                }
                            },
                            error: function () {
                                layer.close(loading);
                                layer.msg('{{ __('导出失败') }}');
                            }
                        });
                    });
                });

                $('#btn-import').on('click', function () { $('#import-file').click(); });
                $('#import-file').on('change', function (e) {
                    var file = e.target.files && e.target.files[0];
                    if (!file) return;
                    var loading = layer.load();
                    excel.importExcel([file], {}, function (data) {
                        try {
                            var sheet = data[file.name] || data[Object.keys(data)[0]];
                            var firstSheet = sheet[Object.keys(sheet)[0]];
                            var rows = [];
                            (firstSheet || []).forEach(function (r) {
                                if (!r) return;
                                rows.push({
                                    id: r.id != null ? r.id : (r.A != null ? r.A : r[0]),
                                    subject: r.subject != null ? r.subject : (r.B != null ? r.B : r[1]),
                                    content: r.content != null ? r.content : (r.C != null ? r.C : r[2]),
                                    sort: r.sort != null ? r.sort : (r.D != null ? r.D : r[3]),
                                    active: r.active != null ? r.active : (r.E != null ? r.E : r[4]),
                                    product_ids: r.product_ids != null ? r.product_ids : (r.F != null ? r.F : r[5]),
                                    category_ids: r.category_ids != null ? r.category_ids : (r.G != null ? r.G : r[6])
                                });
                            });
                            $.ajax({
                                url: '{{ route('admin.productFaq.import') }}',
                                type: 'POST',
                                data: { _token: token, rows: rows },
                                success: function (res) {
                                    layer.close(loading);
                                    layer.msg((res && res.msg) || '{{ __('导入完成') }}', { time: 2000 }, function () {
                                        location.reload();
                                    });
                                },
                                error: function (xhr) {
                                    layer.close(loading);
                                    var msg = (xhr.responseJSON && xhr.responseJSON.msg) || '{{ __('导入失败') }}';
                                    layer.msg(msg);
                                }
                            });
                        } catch (err) {
                            layer.close(loading);
                            layer.msg('{{ __('解析文件失败') }}');
                        }
                        $('#import-file').val('');
                    });
                });
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
