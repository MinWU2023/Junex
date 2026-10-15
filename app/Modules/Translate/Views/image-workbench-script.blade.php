<script>
(function ($) {
    if (!$) {
        alert('jQuery 未加载，图片工作台不可用');
        return;
    }

    var apiPrefix = '/' + (window.admin_prefix || '{{ config('app.admin_prefix') }}') + '/';
    var csrfToken = '{{ csrf_token() }}';

    var state = {
        logCount: 0,
        loadSeq: 0,
        currentModule: '',
        mode: 'single',
        batchRunning: false,
        batchStop: false,
        batchModule: '',
        batchFields: [],
        batchDomain: '',
        batchPreviews: {},
        previewId: '',
        singlePreview: null,
        saveRunning: false
    };

    function setSaveButtonBusy(busy) {
        state.saveRunning = !!busy;
        var $btn = $('#iw-save-one');
        if (busy) {
            $btn.prop('disabled', true).addClass('layui-btn-disabled');
            return;
        }
        updateSaveButtonState();
    }

    function showSaveProgress(total, title) {
        var $box = $('#iw-save-progress');
        if (!$box.length) return;
        $box.addClass('is-active');
        $('#iw-save-progress-title').text(title || '写入数据库进度');
        $('#iw-save-total').text(total || 0);
        $('#iw-save-done').text(0);
        $('#iw-save-ok').text(0);
        $('#iw-save-fail').text(0);
        $('#iw-save-progress-result').text('准备写入...');
        $('#iw-save-progress-bar').removeClass('is-fail is-done').css('width', '0%');
    }

    function updateSaveProgress(done, total, ok, fail, currentLabel) {
        var pct = total > 0 ? Math.min(100, Math.round((done / total) * 100)) : 0;
        $('#iw-save-total').text(total || 0);
        $('#iw-save-done').text(done || 0);
        $('#iw-save-ok').text(ok || 0);
        $('#iw-save-fail').text(fail || 0);
        $('#iw-save-progress-bar').css('width', pct + '%');
        var tip = '进度 ' + done + '/' + total + '（' + pct + '%）';
        if (currentLabel) tip += ' · ' + currentLabel;
        $('#iw-save-progress-result').text(tip);
        setStatus('入库 ' + done + '/' + total + '（成功 ' + ok + ' / 失败 ' + fail + '）', done < total);
        $('#iw-status-count').text('入库 ' + done + '/' + total);
    }

    function finishSaveProgress(ok, fail, total) {
        var done = (ok || 0) + (fail || 0);
        updateSaveProgress(done, total, ok, fail, '');
        var $bar = $('#iw-save-progress-bar');
        $bar.removeClass('is-fail is-done');
        if (fail > 0) $bar.addClass('is-fail');
        else $bar.addClass('is-done');
        var result = '写入完成：共 ' + total + ' 条，成功 ' + ok + '，失败 ' + fail;
        $('#iw-save-progress-result').html(
            fail
                ? '<span style="color:#ff4d4f;">' + result + '</span>'
                : '<span style="color:#52c41a;">' + result + '</span>'
        );
        setStatus(fail ? ('入库完成（失败 ' + fail + '）') : '入库完成', false);
        $('#iw-status-count').text('成功 ' + ok + ' / 失败 ' + fail);
        if (window.layui && layui.layer) {
            layui.layer.msg(result, { icon: fail ? 0 : 1, time: 2500 });
        }
    }

    function bootLog(msg, isError) {
        var $log = $('#iw-log');
        if (!$log.length) return;
        $log.find('.iw-log-empty').remove();
        state.logCount++;
        if (!state.saveRunning) {
            $('#iw-status-count').text('共 ' + state.logCount + ' 条');
        }
        var color = '#d4d4d4';
        if (isError === true) color = '#ff6b6b';
        else if (isError === false) color = '#6ee7b7';
        $log.prepend('<div class="iw-log-item" style="color:' + color + '"><div class="iw-log-time">' + new Date().toLocaleTimeString() + '</div>' + msg + '</div>');
        $log.scrollTop(0);
    }

    function setStatus(text, loading) {
        $('#iw-status-text').text(text || '就绪');
        $('#iw-status-dot').toggleClass('loading', !!loading);
    }

    function escapeHtml(text) {
        return $('<div>').text(text || '').html();
    }

    function uiMsg(text) {
        bootLog(text, true);
        if (window.layui && layui.layer) layui.layer.msg(text);
        else alert(text);
    }

    function uiConfirm(html, onOk) {
        if (window.layui && layui.layer) {
            layui.layer.confirm(html, { icon: 3, title: '请确认' }, function (i) {
                layui.layer.close(i);
                onOk();
            });
        } else if (window.confirm($('<div>').html(html).text())) {
            onOk();
        }
    }

    function selectedModule() { return $('#iw-module').val(); }
    function selectedDomain() {
        var d = $.trim($('#iw-domain').val() || '');
        return d || 'https://minge2601.dyyweb.com';
    }
    function selectedRecordId() {
        var manual = $('#iw-record-manual').val();
        return manual || $('#iw-record').val();
    }
    function selectedFields() {
        var fields = [];
        $('#iw-fields input[name="iw-field"]:checked').each(function () { fields.push($(this).val()); });
        return fields;
    }

    function ensureBaseSelection(needRecord) {
        var module = selectedModule();
        var fields = selectedFields();
        var domain = selectedDomain();
        if (!module) { uiMsg('请选择数据表'); return null; }
        if (!fields.length) { uiMsg('请至少选择一个字段'); return null; }
        if (!domain) { uiMsg('请填写要剥离的域名'); return null; }
        var id = selectedRecordId();
        if (needRecord && !id) { uiMsg('请选择或输入记录 ID'); return null; }
        return { module: module, id: id, fields: fields, domain: domain };
    }

    function updateSaveButtonState() {
        var has = false;
        if (state.mode === 'batch') {
            has = Object.keys(state.batchPreviews).length > 0;
        } else {
            has = !!(state.singlePreview && (state.singlePreview.locales || []).length);
        }
        $('#iw-save-one').prop('disabled', !has).toggleClass('layui-btn-disabled', !has);
        $('#iw-save-one').html(state.mode === 'batch'
            ? '<i class="layui-icon layui-icon-ok"></i> 确认批量写入数据库'
            : '<i class="layui-icon layui-icon-ok"></i> 确认写入数据库');
    }

    function syncEditorToState() {
        var $editors = $('#iw-preview-body .iw-preview-editor');
        if (!$editors.length) return;

        if (state.mode === 'batch' && state.previewId) {
            var item = state.batchPreviews[state.previewId];
            if (!item) return;
            $editors.each(function () {
                var locale = $(this).data('locale');
                var field = $(this).data('field');
                var loc = (item.locales || []).find(function (row) { return row.locale === locale; });
                if (loc && loc.fields && loc.fields[field]) {
                    loc.fields[field].after = $(this).val();
                    loc.fields[field].changed = loc.fields[field].before !== loc.fields[field].after;
                }
            });
            return;
        }

        if (!state.singlePreview) return;
        $editors.each(function () {
            var locale = $(this).data('locale');
            var field = $(this).data('field');
            var loc = (state.singlePreview.locales || []).find(function (row) { return row.locale === locale; });
            if (loc && loc.fields && loc.fields[field]) {
                loc.fields[field].after = $(this).val();
                loc.fields[field].changed = loc.fields[field].before !== loc.fields[field].after;
            }
        });
    }

    function renderLocalesHtml(locales) {
        var html = '';
        (locales || []).forEach(function (loc) {
            var changeCount = 0;
            Object.keys(loc.fields || {}).forEach(function (name) {
                if (loc.fields[name].changed || (loc.fields[name].count || 0) > 0) changeCount++;
            });
            html += '<div class="iw-locale-block">';
            html += '<div class="iw-locale-head">' + escapeHtml(loc.label || loc.locale) + ' <code>(' + escapeHtml(loc.locale) + ')</code>';
            html += '<span class="iw-badge">' + changeCount + ' 个字段有变更</span></div>';
            Object.keys(loc.fields || {}).forEach(function (name) {
                var meta = loc.fields[name] || {};
                var changed = !!meta.changed || (meta.count || 0) > 0;
                html += '<div class="iw-preview-item' + (changed ? '' : ' iw-unchanged') + '">';
                html += '<div class="iw-preview-title"><strong>' + escapeHtml(meta.label || name) + '</strong> (' + escapeHtml(name) + ')';
                if (meta.count) html += ' <span style="color:#d46b08;font-size:12px;">替换 ' + meta.count + ' 处</span>';
                else html += ' <span style="color:#999;font-size:12px;">无匹配</span>';
                html += '</div>';
                html += '<div class="iw-preview-grid"><div><div class="iw-preview-label">处理前</div>';
                html += '<pre class="iw-preview-box iw-preview-source">' + escapeHtml(meta.before || '') + '</pre></div>';
                html += '<div><div class="iw-preview-label">处理后（可编辑）</div>';
                html += '<textarea class="iw-preview-editor" data-locale="' + escapeHtml(loc.locale) + '" data-field="' + escapeHtml(name) + '" rows="6">' + escapeHtml(meta.after || '') + '</textarea>';
                html += '</div></div></div>';
            });
            html += '</div>';
        });
        if (!html) {
            html = '<div class="iw-empty-hint">该记录没有翻译行可处理</div>';
        }
        return html;
    }

    function renderPreviewPanel() {
        if (state.mode === 'batch') {
            var ids = Object.keys(state.batchPreviews);
            if (!ids.length) {
                $('#iw-preview-panel').hide();
                updateSaveButtonState();
                return;
            }
            if (!state.previewId || !state.batchPreviews[state.previewId]) {
                state.previewId = ids[0];
            }
            var switchHtml = '';
            ids.forEach(function (rid) {
                var row = state.batchPreviews[rid];
                switchHtml += '<option value="' + rid + '"' + (String(rid) === String(state.previewId) ? ' selected' : '') + '>#' + rid + ' - ' + escapeHtml(row.label || '') + '（替换 ' + (row.total_replacements || 0) + '）</option>';
            });
            $('#iw-preview-record').html(switchHtml);
            $('#iw-preview-count').text('已完成 ' + ids.length + ' 条');
            $('#iw-preview-switch').show();
            var item = state.batchPreviews[state.previewId];
            $('#iw-preview-body').html(renderLocalesHtml(item.locales || []));
            $('#iw-preview-panel').show();
            updateSaveButtonState();
            return;
        }

        $('#iw-preview-switch').hide();
        if (!state.singlePreview) {
            $('#iw-preview-panel').hide();
            updateSaveButtonState();
            return;
        }
        $('#iw-preview-body').html(renderLocalesHtml(state.singlePreview.locales || []));
        $('#iw-preview-panel').show();
        updateSaveButtonState();
    }

    function showPreviewRecord(id) {
        syncEditorToState();
        state.previewId = String(id || '');
        renderPreviewPanel();
    }

    function renderRecordOptions(items, total, module) {
        var html = '<option value="">选择记录（共 ' + (total || 0) + ' 条）</option>';
        (items || []).forEach(function (row) {
            html += '<option value="' + row.id + '">#' + row.id + ' - ' + escapeHtml(row.label || '') + '</option>';
        });
        $('#iw-record').html(html);
        bootLog('已加载记录列表：' + module + '（本页 ' + (items || []).length + ' / 共 ' + (total || 0) + '）', false);
    }

    function renderFields(fields) {
        if (!fields || !fields.length) {
            $('#iw-fields').html('<div class="iw-empty-hint">该数据表没有可处理字段</div>');
            $('#iw-fields-toolbar').hide();
            return;
        }
        var html = '';
        fields.forEach(function (f) {
            html += '<label class="iw-field-check"><input type="checkbox" name="iw-field" value="' + escapeHtml(f.name) + '" checked> ';
            html += '<span>' + escapeHtml(f.label || f.name) + ' <code style="color:#999;">' + escapeHtml(f.name) + '</code></span></label>';
        });
        $('#iw-fields').html(html);
        $('#iw-fields-toolbar').show();
    }

    window.iwLoadModuleData = function (module) {
        module = module || selectedModule();
        state.currentModule = module || '';
        state.singlePreview = null;
        state.batchPreviews = {};
        state.previewId = '';
        $('#iw-preview-panel').hide();
        updateSaveButtonState();
        if (!module) {
            $('#iw-record').html('<option value="">请先选择数据表</option>');
            $('#iw-fields').html('<div class="iw-empty-hint">请先选择数据表</div>');
            $('#iw-fields-toolbar').hide();
            return;
        }
        var seq = ++state.loadSeq;
        setStatus('加载字段与记录...', true);
        $.when(
            $.ajax({ url: apiPrefix + 'imageWorkbench/fields', data: { module: module, _t: Date.now() }, dataType: 'json', cache: false }),
            $.ajax({ url: apiPrefix + 'imageWorkbench/records', data: { module: module, limit: 100, _t: Date.now() }, dataType: 'json', cache: false })
        ).done(function (fieldsRes, recordsRes) {
            if (seq !== state.loadSeq || state.currentModule !== module) return;
            var fRes = fieldsRes[0];
            var rRes = recordsRes[0];
            if (fRes && fRes.code === 0) renderFields(fRes.data || []);
            else bootLog('加载字段失败：' + ((fRes && fRes.message) || ''), true);
            if (rRes && rRes.code === 0) renderRecordOptions(rRes.data && rRes.data.items, rRes.data && rRes.data.total, module);
            else bootLog('加载记录失败：' + ((rRes && rRes.message) || ''), true);
        }).fail(function () {
            if (seq !== state.loadSeq) return;
            bootLog('加载数据表信息失败', true);
        }).always(function () {
            if (seq === state.loadSeq) setStatus('就绪', false);
        });
    };

    function previewRequest(module, id, fields, domain) {
        return $.ajax({
            url: apiPrefix + 'imageWorkbench/preview',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken,
                module: module,
                id: id,
                fields: fields,
                domain: domain
            }
        });
    }

    function saveRequest(module, id, localesPayload) {
        return $.ajax({
            url: apiPrefix + 'imageWorkbench/save',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken,
                module: module,
                id: id,
                locales: localesPayload
            }
        });
    }

    function localesToSavePayload(locales) {
        var out = {};
        (locales || []).forEach(function (loc) {
            var fields = {};
            Object.keys(loc.fields || {}).forEach(function (name) {
                // 仅回写有变更的字段，减少误写
                var meta = loc.fields[name];
                if (!meta) return;
                if (meta.changed || (meta.count || 0) > 0 || meta.before !== meta.after) {
                    fields[name] = meta.after || '';
                }
            });
            if (Object.keys(fields).length) {
                out[loc.locale] = fields;
            }
        });
        return out;
    }

    window.iwPreviewOne = function () {
        var sel = ensureBaseSelection(true);
        if (!sel) return;

        state.mode = 'single';
        state.batchPreviews = {};
        state.previewId = String(sel.id);
        state.singlePreview = null;
        $('#iw-preview-switch').hide();
        $('#iw-preview-panel').hide();
        updateSaveButtonState();
        setStatus('处理中 #' + sel.id + '...', true);
        bootLog('<strong>开始预览 #' + sel.id + '</strong>（域名：' + escapeHtml(sel.domain) + '，全部语言）');

        previewRequest(sel.module, sel.id, sel.fields, sel.domain).done(function (res) {
            if (!res || res.code !== 0) {
                setStatus('失败', false);
                bootLog('预览失败：' + ((res && res.message) || ''), true);
                return;
            }
            state.singlePreview = res.data;
            setStatus('预览就绪', false);
            renderPreviewPanel();
            bootLog('预览完成：共替换 <strong>' + (res.data.total_replacements || 0) + '</strong> 处，涉及 ' + ((res.data.locales || []).length) + ' 种语言。请检查后入库。', false);
        }).fail(function (xhr) {
            setStatus('失败', false);
            bootLog('预览接口失败（' + xhr.status + '）', true);
        });
    };

    function previewBatchRecord(ids, index) {
        if (state.batchStop) {
            state.batchRunning = false;
            $('#iw-stop-batch').hide();
            setStatus('已停止', false);
            renderPreviewPanel();
            bootLog('批量预览已停止', true);
            return;
        }
        if (index >= ids.length) {
            state.batchRunning = false;
            $('#iw-stop-batch').hide();
            setStatus('批量预览就绪', false);
            if (!state.previewId) state.previewId = String(ids[0] || '');
            renderPreviewPanel();
            bootLog('<strong>批量预览完成（共 ' + Object.keys(state.batchPreviews).length + ' 条）</strong>', false);
            return;
        }

        var id = ids[index];
        setStatus('批量处理 ' + (index + 1) + '/' + ids.length + ' (#' + id + ')', true);
        $('#iw-record').val(id);
        bootLog('<strong>[' + (index + 1) + '/' + ids.length + '] 预览 #' + id + '</strong>');

        previewRequest(state.batchModule, id, state.batchFields, state.batchDomain).done(function (res) {
            if (state.batchStop) {
                previewBatchRecord(ids, ids.length);
                return;
            }
            if (!res || res.code !== 0) {
                bootLog('#' + id + ' 预览失败：' + ((res && res.message) || ''), true);
                previewBatchRecord(ids, index + 1);
                return;
            }
            state.batchPreviews[String(id)] = res.data;
            if (!state.previewId) {
                state.previewId = String(id);
                renderPreviewPanel();
            } else {
                var idsDone = Object.keys(state.batchPreviews);
                var switchHtml = '';
                idsDone.forEach(function (rid) {
                    var row = state.batchPreviews[rid];
                    switchHtml += '<option value="' + rid + '"' + (String(rid) === String(state.previewId) ? ' selected' : '') + '>#' + rid + ' - ' + escapeHtml(row.label || '') + '（替换 ' + (row.total_replacements || 0) + '）</option>';
                });
                $('#iw-preview-record').html(switchHtml);
                $('#iw-preview-count').text('已完成 ' + idsDone.length + '/' + ids.length);
                $('#iw-preview-switch').show();
                $('#iw-preview-panel').show();
                updateSaveButtonState();
            }
            bootLog('#' + id + ' 完成，替换 ' + (res.data.total_replacements || 0) + ' 处', false);
            setTimeout(function () {
                previewBatchRecord(ids, index + 1);
            }, 200);
        }).fail(function (xhr) {
            bootLog('#' + id + ' 预览失败（' + xhr.status + '）', true);
            setTimeout(function () {
                previewBatchRecord(ids, index + 1);
            }, 300);
        });
    }

    window.iwBatchPreview = function () {
        if (state.batchRunning) {
            uiMsg('批量预览正在进行中');
            return;
        }
        var sel = ensureBaseSelection(false);
        if (!sel) return;

        uiConfirm('将按当前数据表与字段，对<strong>全部记录</strong>的全部语言翻译字段做图片域名剥离预览，<strong>不会立即入库</strong>。确认开始？', function () {
            state.mode = 'batch';
            state.batchRunning = true;
            state.batchStop = false;
            state.batchModule = sel.module;
            state.batchFields = sel.fields.slice();
            state.batchDomain = sel.domain;
            state.batchPreviews = {};
            state.previewId = '';
            state.singlePreview = null;
            $('#iw-stop-batch').show();
            $('#iw-preview-panel').hide();
            updateSaveButtonState();
            setStatus('批量预览中...', true);

            $.ajax({
                url: apiPrefix + 'imageWorkbench/all-ids',
                data: { module: sel.module, _t: Date.now() },
                dataType: 'json',
                cache: false
            }).done(function (res) {
                if (!res || res.code !== 0) {
                    state.batchRunning = false;
                    $('#iw-stop-batch').hide();
                    setStatus('失败', false);
                    bootLog('加载批量 ID 失败：' + ((res && res.message) || ''), true);
                    return;
                }
                var ids = res.data || [];
                if (!ids.length) {
                    state.batchRunning = false;
                    $('#iw-stop-batch').hide();
                    setStatus('就绪', false);
                    uiMsg('没有可批量处理的记录');
                    return;
                }
                bootLog('<strong>开始批量预览，共 ' + ids.length + ' 条</strong>（域名：' + escapeHtml(sel.domain) + '）', false);
                previewBatchRecord(ids, 0);
            }).fail(function (xhr) {
                state.batchRunning = false;
                $('#iw-stop-batch').hide();
                setStatus('失败', false);
                bootLog('加载批量 ID 失败（' + xhr.status + '）', true);
            });
        });
    };

    window.iwStopBatch = function () {
        state.batchStop = true;
        setStatus('正在停止...', true);
        bootLog('正在停止批量预览...', true);
    };

    function saveBatchAll() {
        syncEditorToState();
        var ids = Object.keys(state.batchPreviews);
        if (!ids.length) {
            uiMsg('没有可入库的预览数据');
            return;
        }
        if (state.saveRunning) {
            uiMsg('正在写入数据库，请稍候');
            return;
        }
        uiConfirm('确认将 <strong>' + ids.length + '</strong> 条预览结果写入数据库？会覆盖对应语言的翻译字段。', function () {
            var total = ids.length;
            var ok = 0;
            var fail = 0;
            var index = 0;
            setSaveButtonBusy(true);
            showSaveProgress(total, '批量写入数据库进度');
            bootLog('<strong>开始批量入库，共 ' + total + ' 条</strong>', false);
            updateSaveProgress(0, total, 0, 0, '开始写入...');

            function next() {
                if (index >= total) {
                    finishSaveProgress(ok, fail, total);
                    bootLog('<strong>批量入库完成：共 ' + total + ' 条，成功 ' + ok + '，失败 ' + fail + '</strong>', fail ? true : false);
                    setSaveButtonBusy(false);
                    return;
                }
                var id = ids[index];
                var item = state.batchPreviews[id] || {};
                var payload = localesToSavePayload(item.locales || []);
                if (!Object.keys(payload).length) {
                    ok++;
                    bootLog('✓ [' + (index + 1) + '/' + total + '] #' + id + ' 无变更，跳过', false);
                    index++;
                    updateSaveProgress(index, total, ok, fail, '');
                    next();
                    return;
                }
                updateSaveProgress(index, total, ok, fail, '正在写入 #' + id + '...');
                saveRequest(state.batchModule, id, payload).done(function (res) {
                    if (res && res.code === 0) {
                        ok++;
                        bootLog('✓ [' + (index + 1) + '/' + total + '] #' + id + ' 已入库（语言：' + ((res.data && res.data.locales) || []).join(',') + '）', false);
                    } else {
                        fail++;
                        bootLog('✗ [' + (index + 1) + '/' + total + '] #' + id + ' 入库失败：' + ((res && res.message) || ''), true);
                    }
                }).fail(function (xhr) {
                    fail++;
                    bootLog('✗ [' + (index + 1) + '/' + total + '] #' + id + ' 入库失败（' + xhr.status + '）', true);
                }).always(function () {
                    index++;
                    updateSaveProgress(index, total, ok, fail, index < total ? '下一条准备中...' : '');
                    next();
                });
            }

            next();
        });
    }

    window.iwConfirmSave = function () {
        if (state.saveRunning) {
            uiMsg('正在写入数据库，请稍候');
            return;
        }
        if (state.mode === 'batch') {
            saveBatchAll();
            return;
        }

        var sel = ensureBaseSelection(true);
        if (!sel) return;
        syncEditorToState();
        if (!state.singlePreview) {
            uiMsg('请先点「预览当前记录」或「批量预览」');
            return;
        }
        var payload = localesToSavePayload(state.singlePreview.locales || []);
        if (!Object.keys(payload).length) {
            uiMsg('没有检测到需要写入的变更');
            return;
        }
        uiConfirm('确认将 #' + sel.id + ' 的全部语言变更写入数据库？', function () {
            setSaveButtonBusy(true);
            showSaveProgress(1, '写入数据库进度');
            updateSaveProgress(0, 1, 0, 0, '正在写入 #' + sel.id + '...');
            bootLog('<strong>开始入库 #' + sel.id + '</strong>', false);
            saveRequest(sel.module, sel.id, payload).done(function (res) {
                if (res && res.code === 0) {
                    finishSaveProgress(1, 0, 1);
                    bootLog('✓ 已写入数据库（#' + sel.id + '，语言：' + ((res.data && res.data.locales) || []).join(',') + '）', false);
                } else {
                    finishSaveProgress(0, 1, 1);
                    bootLog('✗ 保存失败：' + ((res && res.message) || ''), true);
                }
            }).fail(function (xhr) {
                finishSaveProgress(0, 1, 1);
                bootLog('✗ 保存失败（' + xhr.status + '）', true);
            }).always(function () {
                setSaveButtonBusy(false);
            });
        });
    };

    $(function () {
        $('#iw-preview-record').on('change', function () {
            showPreviewRecord($(this).val());
        });
        $('#iw-reload-records').on('click', function () {
            var module = selectedModule();
            if (!module) return uiMsg('请先选择数据表');
            var seq = ++state.loadSeq;
            setStatus('刷新记录...', true);
            $.ajax({
                url: apiPrefix + 'imageWorkbench/records',
                data: {
                    module: module,
                    keyword: $('#iw-keyword').val(),
                    limit: 100,
                    _t: Date.now()
                },
                dataType: 'json',
                cache: false
            }).done(function (res) {
                if (seq !== state.loadSeq || state.currentModule !== module) return;
                if (res.code === 0) {
                    renderRecordOptions(res.data && res.data.items, res.data && res.data.total, module);
                } else {
                    bootLog('刷新记录失败：' + (res.message || ''), true);
                }
            }).fail(function (xhr) {
                if (seq !== state.loadSeq) return;
                bootLog('刷新记录失败（' + xhr.status + '）', true);
            }).always(function () {
                if (seq === state.loadSeq) setStatus('就绪', false);
            });
        });
        $('#iw-fields-all').on('click', function () { $('#iw-fields input[name="iw-field"]').prop('checked', true); });
        $('#iw-fields-none').on('click', function () { $('#iw-fields input[name="iw-field"]').prop('checked', false); });
        $('#iw-clear-log').on('click', function () {
            state.logCount = 0;
            $('#iw-status-count').text('');
            $('#iw-log').html('<div class="iw-log-empty">选择数据后开始处理</div>');
        });

        var initialModule = $('#iw-module').val();
        if (initialModule) window.iwLoadModuleData(initialModule);

        bootLog('图片工作台已就绪：处理全部语言翻译字段中的图片域名，预览确认后再入库', false);
        updateSaveButtonState();
    });
})(window.jQuery);
</script>
