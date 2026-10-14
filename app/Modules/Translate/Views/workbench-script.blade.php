<script>
(function ($) {
    if (!$) {
        alert('jQuery 未加载，翻译工作台不可用');
        return;
    }

    var apiPrefix = '/' + (window.admin_prefix || '{{ config('app.admin_prefix') }}') + '/';
    var csrfToken = '{{ csrf_token() }}';

    var state = {
        translated: {},
        previewMeta: {},
        logCount: 0,
        loadSeq: 0,
        currentModule: '',
        mode: 'single', // single | batch
        batchRunning: false,
        batchStop: false,
        batchModule: '',
        batchLocale: '',
        batchFields: [],
        batchPreviews: {}, // id -> { id, label, fields: { name: meta+translated } }
        previewId: ''
    };

    function twBootLog(msg, isError) {
        var $log = $('#tw-log');
        if (!$log.length) return;
        $log.find('.tw-log-empty').remove();
        state.logCount++;
        $('#tw-status-count').text('共 ' + state.logCount + ' 条');
        var color = '#d4d4d4';
        if (isError === true) color = '#ff6b6b';
        else if (isError === false) color = '#6ee7b7';
        $log.prepend('<div class="tw-log-item" style="color:' + color + '"><div class="tw-log-time">' + new Date().toLocaleTimeString() + '</div>' + msg + '</div>');
    }

    function setStatus(text, loading) {
        $('#tw-status-text').text(text || '就绪');
        $('#tw-status-dot').toggleClass('loading', !!loading);
    }

    function escapeHtml(text) {
        return $('<div>').text(text || '').html();
    }

    function uiMsg(text) {
        twBootLog(text, true);
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

    function selectedModule() { return $('#tw-module').val(); }
    function selectedLocale() { return $('#tw-locale').val(); }
    function selectedRecordId() {
        var manual = $('#tw-record-manual').val();
        return manual || $('#tw-record').val();
    }
    function selectedFields() {
        var fields = [];
        $('#tw-fields input[name="tw-field"]:checked').each(function () { fields.push($(this).val()); });
        return fields;
    }

    function ensureBaseSelection(needRecord) {
        var module = selectedModule();
        var locale = selectedLocale();
        var fields = selectedFields();
        if (!module) { uiMsg('请选择数据表'); return null; }
        if (!locale) { uiMsg('请选择目标语言'); return null; }
        if (!fields.length) { uiMsg('请至少选择一个字段'); return null; }
        var id = selectedRecordId();
        if (needRecord && !id) { uiMsg('请选择或输入记录 ID'); return null; }
        return { module: module, locale: locale, id: id, fields: fields };
    }

    function updateSaveButtonState() {
        var has = false;
        if (state.mode === 'batch') {
            has = Object.keys(state.batchPreviews).length > 0;
        } else {
            has = Object.keys(state.translated).length > 0;
        }
        $('#tw-save-one').prop('disabled', !has).toggleClass('layui-btn-disabled', !has);
        $('#tw-save-one').html(state.mode === 'batch'
            ? '<i class="layui-icon layui-icon-ok"></i> 确认批量写入数据库'
            : '<i class="layui-icon layui-icon-ok"></i> 确认写入数据库');
    }

    function syncEditorToState() {
        if (!$('#tw-preview-body .tw-preview-editor').length) return;
        if (state.mode === 'batch' && state.previewId) {
            var item = state.batchPreviews[state.previewId];
            if (!item) return;
            $('#tw-preview-body .tw-preview-editor').each(function () {
                var field = $(this).data('field');
                if (item.fields[field]) {
                    item.fields[field].translated = $(this).val();
                }
            });
        } else {
            $('#tw-preview-body .tw-preview-editor').each(function () {
                state.translated[$(this).data('field')] = $(this).val();
            });
        }
    }

    function renderPreviewFields(fieldsMap) {
        var html = '';
        Object.keys(fieldsMap).forEach(function (name) {
            var meta = fieldsMap[name] || {};
            html += '<div class="tw-preview-item"><div class="tw-preview-title"><strong>' + escapeHtml(meta.label || name) + '</strong> (' + escapeHtml(name) + ')</div>';
            html += '<div class="tw-preview-grid"><div class="tw-preview-col"><div class="tw-preview-label">英文原文</div>';
            html += '<pre class="tw-preview-box tw-preview-source">' + escapeHtml(meta.value || '') + '</pre></div>';
            html += '<div class="tw-preview-col"><div class="tw-preview-label">翻译预览（可编辑）</div>';
            html += '<textarea class="tw-preview-editor" data-field="' + escapeHtml(name) + '" rows="' + (meta.is_rich ? 8 : 3) + '">' + escapeHtml(meta.translated || '') + '</textarea>';
            if (meta.existing) html += '<div class="tw-preview-existing">库中已有：' + escapeHtml(meta.existing) + '</div>';
            html += '</div></div></div>';
        });
        return html;
    }

    function renderPreviewPanel() {
        if (state.mode === 'batch') {
            var ids = Object.keys(state.batchPreviews);
            if (!ids.length) {
                $('#tw-preview-panel').hide();
                $('#tw-preview-switch').hide();
                updateSaveButtonState();
                return;
            }
            if (!state.previewId || !state.batchPreviews[state.previewId]) {
                state.previewId = ids[0];
            }
            var switchHtml = '';
            ids.forEach(function (id) {
                var row = state.batchPreviews[id];
                switchHtml += '<option value="' + id + '"' + (String(id) === String(state.previewId) ? ' selected' : '') + '>#' + id + ' - ' + escapeHtml(row.label || '') + '</option>';
            });
            $('#tw-preview-record').html(switchHtml);
            $('#tw-preview-count').text('共 ' + ids.length + ' 条可预览');
            $('#tw-preview-switch').show();

            var tip = '<div class="tw-preview-tip">批量预览模式：可用下拉切换记录对比原文/译文，修改后点「确认批量写入数据库」。</div>';
            var current = state.batchPreviews[state.previewId];
            $('#tw-preview-body').html(tip + renderPreviewFields(current.fields || {}));
            $('#tw-preview-panel').show();
            updateSaveButtonState();
            return;
        }

        $('#tw-preview-switch').hide();
        var keys = Object.keys(state.translated);
        if (!keys.length) {
            $('#tw-preview-panel').hide();
            $('#tw-preview-body').empty();
            updateSaveButtonState();
            return;
        }
        var fieldsMap = {};
        keys.forEach(function (name) {
            var meta = state.previewMeta[name] || { label: name, value: '', existing: '', is_rich: false };
            fieldsMap[name] = {
                label: meta.label,
                value: meta.value,
                existing: meta.existing,
                is_rich: meta.is_rich,
                translated: state.translated[name]
            };
        });
        var tip = '<div class="tw-preview-tip">请检查翻译结果，可修改后再点「确认写入数据库」。</div>';
        $('#tw-preview-body').html(tip + renderPreviewFields(fieldsMap));
        $('#tw-preview-panel').show();
        updateSaveButtonState();
    }

    function showPreviewRecord(id) {
        syncEditorToState();
        state.previewId = String(id);
        renderPreviewPanel();
        $('#tw-record').val(id);
        $('#tw-record-manual').val('');
    }

    function renderRecordOptions(items, total, moduleKey) {
        var moduleLabel = moduleKey || state.currentModule || '';
        var html = '<option value="">请选择记录' + (total ? '（共' + total + '条）' : '') + '</option>';
        (items || []).forEach(function (row) {
            html += '<option value="' + row.id + '">#' + row.id + ' - ' + row.label + '</option>';
        });
        $('#tw-record').html(html);
        if (!items || !items.length) {
            twBootLog('[' + moduleLabel + '] 未找到记录，可手动输入 ID', true);
        } else {
            twBootLog('[' + moduleLabel + '] 已加载 <strong>' + items.length + '</strong> 条记录', false);
        }
    }

    function renderFieldOptions(fields) {
        if (!fields || !fields.length) {
            $('#tw-fields-toolbar').hide();
            $('#tw-fields').html('<div class="tw-empty-hint">该数据表暂无可翻译字段</div>');
            return;
        }
        $('#tw-fields-toolbar').show();
        var html = fields.map(function (field) {
            return '<label class="tw-field-check"><input type="checkbox" name="tw-field" value="' + field.name + '" checked> ' + field.label + ' (' + field.name + ')</label>';
        }).join('');
        $('#tw-fields').html(html);
    }

    function resetPreviewState() {
        state.mode = 'single';
        state.translated = {};
        state.previewMeta = {};
        state.batchPreviews = {};
        state.previewId = '';
        state.batchStop = true;
        state.batchRunning = false;
        $('#tw-stop-batch').hide();
        $('#tw-preview-panel').hide();
        $('#tw-preview-switch').hide();
        $('#tw-preview-body').empty();
        updateSaveButtonState();
    }

    window.twLoadModuleData = function (module) {
        module = module || '';
        state.currentModule = module;
        state.loadSeq += 1;
        var seq = state.loadSeq;

        resetPreviewState();
        $('#tw-record-manual').val('');
        $('#tw-keyword').val('');

        if (!module) {
            $('#tw-fields-toolbar').hide();
            $('#tw-fields').html('<div class="tw-empty-hint">请先选择数据表</div>');
            $('#tw-record').html('<option value="">选择数据表后自动加载</option>');
            return;
        }

        $('#tw-record').html('<option value="">加载中...</option>');
        $('#tw-fields').html('<div class="tw-empty-hint">加载字段中...</div>');
        $('#tw-fields-toolbar').hide();
        setStatus('加载 ' + module + '...', true);

        $.ajax({
            url: apiPrefix + 'translateWorkbench/records',
            data: { module: module, limit: 100, _t: Date.now() },
            dataType: 'json',
            cache: false
        }).done(function (res) {
            if (seq !== state.loadSeq || state.currentModule !== module) return;
            if (res.code === 0) {
                renderRecordOptions(res.data && res.data.items, res.data && res.data.total, module);
            } else {
                twBootLog('加载记录失败：' + (res.message || ''), true);
                $('#tw-record').html('<option value="">加载失败，请手动输入 ID</option>');
            }
        }).fail(function (xhr) {
            if (seq !== state.loadSeq || state.currentModule !== module) return;
            twBootLog('加载记录失败（' + xhr.status + '）', true);
            $('#tw-record').html('<option value="">加载失败，请手动输入 ID</option>');
        });

        $.ajax({
            url: apiPrefix + 'translateWorkbench/fields',
            data: { module: module, _t: Date.now() },
            dataType: 'json',
            cache: false
        }).done(function (res) {
            if (seq !== state.loadSeq || state.currentModule !== module) return;
            if (res.code === 0) {
                renderFieldOptions(res.data || []);
            } else {
                twBootLog('加载字段失败：' + (res.message || ''), true);
                $('#tw-fields').html('<div class="tw-empty-hint">加载字段失败</div>');
            }
        }).fail(function (xhr) {
            if (seq !== state.loadSeq || state.currentModule !== module) return;
            twBootLog('加载字段失败（' + xhr.status + '）', true);
            $('#tw-fields').html('<div class="tw-empty-hint">加载字段失败</div>');
        }).always(function () {
            if (seq === state.loadSeq && state.currentModule === module) {
                setStatus('就绪', false);
            }
        });
    };

    function looksLikeHtml(value) {
        return /<[^>]+>/.test(String(value || ''));
    }

    function normalizeCompare(text) {
        return String(text || '')
            .replace(/&nbsp;/gi, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .toLowerCase();
    }

    /** 仅当目标语言已有内容，且与英文原文明显不同时才跳过 */
    function shouldSkipExisting(meta) {
        if (!$('#tw-skip-existing').prop('checked')) return false;
        var existing = String(meta.existing || '').trim();
        if (!existing) return false;
        var source = String(meta.value || '').trim();
        if (!source) return false;
        // 库中仍是英文/与原文相同 → 不跳过，必须重翻
        if (normalizeCompare(existing) === normalizeCompare(source)) return false;
        return true;
    }

    function translateOneField(field, locale) {
        var d = $.Deferred();
        if (!field.value || !String(field.value).trim()) {
            d.resolve('');
            return d.promise();
        }
        var forceRich = !!(field.is_rich || looksLikeHtml(field.value));
        $.ajax({
            url: apiPrefix + 'translateWorkbench/translate',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken,
                text: field.value,
                locale: locale,
                type: forceRich ? (field.type || 'html') : (field.type || 'text'),
                is_rich: forceRich ? 1 : 0
            }
        }).done(function (res) {
            if (res.code !== 0) {
                d.reject(res.message || '翻译失败');
                return;
            }
            var text = (res.data && res.data.text) || '';
            var seg = (res.data && res.data.segment_count) || 0;
            var done = (res.data && res.data.translated_count) || 0;
            if (forceRich || (res.data && res.data.is_rich)) {
                twBootLog('富文本提取 ' + seg + ' 段，成功翻译 ' + done + ' 段', done > 0 ? false : true);
                if (res.data.same_as_source && done === 0) {
                    d.reject('富文本未提取到可译文案或全部翻译失败（segments=' + seg + '）');
                    return;
                }
                d.resolve(text);
                return;
            }
            if (res.data && res.data.same_as_source) {
                d.reject('翻译结果仍为原文，目标语言：' + ((res.data && res.data.target) || locale));
                return;
            }
            d.resolve(text);
        }).fail(function (xhr) {
            var msg = '翻译接口失败(' + xhr.status + ')';
            try {
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            } catch (e) {}
            d.reject(msg);
        });
        return d.promise();
    }

    function translateRecordJobs(jobs, locale, index, onFieldDone, onDone) {
        if (index >= jobs.length) {
            onDone();
            return;
        }
        var job = jobs[index];
        if (shouldSkipExisting(job.meta)) {
            twBootLog(job.meta.label + ' (' + job.name + ') 目标语言已有不同内容，已跳过', false);
            onFieldDone(job.name, job.meta, job.meta.existing, true);
            translateRecordJobs(jobs, locale, index + 1, onFieldDone, onDone);
            return;
        }
        var richHint = looksLikeHtml(job.meta.value) ? ' [富文本]' : '';
        twBootLog('正在翻译：<strong>' + job.meta.label + '</strong> (' + job.name + ')' + richHint);
        translateOneField(job.meta, locale).done(function (text) {
            twBootLog('✓ ' + job.name + ' → ' + locale + ' 完成', false);
            onFieldDone(job.name, job.meta, text, false);
            translateRecordJobs(jobs, locale, index + 1, onFieldDone, onDone);
        }).fail(function (err) {
            twBootLog('✗ ' + job.name + ' 翻译失败：' + err + '（预览暂填原文）', true);
            onFieldDone(job.name, job.meta, job.meta.value || '', false);
            translateRecordJobs(jobs, locale, index + 1, onFieldDone, onDone);
        });
    }

    function fetchSource(module, id, fields, locale) {
        return $.getJSON(apiPrefix + 'translateWorkbench/source', {
            module: module,
            id: id,
            locale: locale,
            fields: fields
        });
    }

    function saveOne(module, id, locale, fields) {
        return $.ajax({
            url: apiPrefix + 'translateWorkbench/save',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken,
                module: module,
                id: id,
                locale: locale,
                fields: fields
            }
        });
    }

    window.twPreviewTranslate = function () {
        twBootLog('点击预览当前记录...');
        var sel = ensureBaseSelection(true);
        if (!sel) return;

        state.mode = 'single';
        state.batchPreviews = {};
        state.previewId = String(sel.id);
        state.translated = {};
        state.previewMeta = {};
        $('#tw-preview-switch').hide();
        $('#tw-preview-panel').hide();
        updateSaveButtonState();
        setStatus('翻译中 #' + sel.id + '...', true);
        twBootLog('<strong>开始预览 #' + sel.id + '</strong>（不写入数据库）');

        fetchSource(sel.module, sel.id, sel.fields, sel.locale).done(function (res) {
            if (res.code !== 0) {
                setStatus('失败', false);
                twBootLog('读取原文失败：' + (res.message || ''), true);
                return;
            }
            var jobs = [];
            $.each(res.data.fields || {}, function (name, meta) {
                jobs.push({ name: name, meta: meta });
            });
            if (!jobs.length) {
                setStatus('失败', false);
                twBootLog('没有可翻译字段', true);
                return;
            }
            translateRecordJobs(jobs, sel.locale, 0, function (name, meta, text) {
                state.previewMeta[name] = meta;
                state.translated[name] = text;
            }, function () {
                setStatus('预览就绪', false);
                renderPreviewPanel();
                twBootLog('预览完成，请检查后点「确认写入数据库」', false);
            });
        }).fail(function (xhr) {
            setStatus('失败', false);
            twBootLog('读取原文接口失败（' + xhr.status + '）', true);
        });
    };

    function translateBatchRecord(ids, index) {
        if (state.batchStop) {
            state.batchRunning = false;
            $('#tw-stop-batch').hide();
            setStatus('已停止', false);
            renderPreviewPanel();
            twBootLog('批量预览已停止，可切换下拉查看已完成记录', true);
            return;
        }
        if (index >= ids.length) {
            state.batchRunning = false;
            $('#tw-stop-batch').hide();
            setStatus('批量预览就绪', false);
            if (!state.previewId) {
                state.previewId = String(ids[0] || '');
            }
            renderPreviewPanel();
            twBootLog('<strong>批量预览完成（共 ' + Object.keys(state.batchPreviews).length + ' 条）</strong>，请切换记录检查后确认入库', false);
            return;
        }

        var id = ids[index];
        setStatus('批量翻译 ' + (index + 1) + '/' + ids.length + ' (#' + id + ')', true);
        $('#tw-record').val(id);
        twBootLog('<strong>[' + (index + 1) + '/' + ids.length + '] 预览 #' + id + '</strong>');

        fetchSource(state.batchModule, id, state.batchFields, state.batchLocale).done(function (res) {
            if (state.batchStop) {
                translateBatchRecord(ids, ids.length);
                return;
            }
            if (res.code !== 0) {
                twBootLog('#' + id + ' 读取原文失败：' + (res.message || ''), true);
                translateBatchRecord(ids, index + 1);
                return;
            }
            var jobs = [];
            $.each(res.data.fields || {}, function (name, meta) {
                jobs.push({ name: name, meta: meta });
            });
            var record = {
                id: id,
                label: res.data.label || ('#' + id),
                fields: {}
            };
            translateRecordJobs(jobs, state.batchLocale, 0, function (name, meta, text) {
                record.fields[name] = {
                    label: meta.label,
                    value: meta.value,
                    existing: meta.existing,
                    is_rich: meta.is_rich,
                    type: meta.type,
                    translated: text
                };
            }, function () {
                state.batchPreviews[String(id)] = record;
                if (!state.previewId) {
                    state.previewId = String(id);
                    renderPreviewPanel();
                } else {
                    // 更新下拉选项数量
                    var idsDone = Object.keys(state.batchPreviews);
                    var switchHtml = '';
                    idsDone.forEach(function (rid) {
                        var row = state.batchPreviews[rid];
                        switchHtml += '<option value="' + rid + '"' + (String(rid) === String(state.previewId) ? ' selected' : '') + '>#' + rid + ' - ' + escapeHtml(row.label || '') + '</option>';
                    });
                    $('#tw-preview-record').html(switchHtml);
                    $('#tw-preview-count').text('已完成 ' + idsDone.length + '/' + ids.length);
                    $('#tw-preview-switch').show();
                    $('#tw-preview-panel').show();
                    updateSaveButtonState();
                }
                translateBatchRecord(ids, index + 1);
            });
        }).fail(function (xhr) {
            twBootLog('#' + id + ' 读取原文失败（' + xhr.status + '）', true);
            translateBatchRecord(ids, index + 1);
        });
    }

    window.twBatchPreview = function () {
        twBootLog('点击批量预览翻译...');
        if (state.batchRunning) {
            uiMsg('批量预览正在进行中');
            return;
        }
        var sel = ensureBaseSelection(false);
        if (!sel) return;

        uiConfirm('将按当前数据表、语言和字段，批量翻译全部记录并生成预览，<strong>不会立即入库</strong>。确认开始？', function () {
            state.mode = 'batch';
            state.batchRunning = true;
            state.batchStop = false;
            state.batchModule = sel.module;
            state.batchLocale = sel.locale;
            state.batchFields = sel.fields.slice();
            state.batchPreviews = {};
            state.previewId = '';
            state.translated = {};
            state.previewMeta = {};
            $('#tw-stop-batch').show();
            $('#tw-preview-panel').hide();
            updateSaveButtonState();
            setStatus('批量预览中...', true);

            $.ajax({
                url: apiPrefix + 'translateWorkbench/all-ids',
                data: { module: sel.module, _t: Date.now() },
                dataType: 'json',
                cache: false
            }).done(function (res) {
                if (res.code !== 0) {
                    state.batchRunning = false;
                    $('#tw-stop-batch').hide();
                    setStatus('失败', false);
                    twBootLog('加载批量 ID 失败：' + (res.message || ''), true);
                    return;
                }
                var ids = res.data || [];
                if (!ids.length) {
                    state.batchRunning = false;
                    $('#tw-stop-batch').hide();
                    setStatus('就绪', false);
                    uiMsg('没有可批量翻译的记录');
                    return;
                }
                twBootLog('<strong>开始批量预览，共 ' + ids.length + ' 条</strong>（仅预览，不入库）', false);
                translateBatchRecord(ids, 0);
            }).fail(function (xhr) {
                state.batchRunning = false;
                $('#tw-stop-batch').hide();
                setStatus('失败', false);
                twBootLog('加载批量 ID 失败（' + xhr.status + '）', true);
            });
        });
    };

    window.twStopBatch = function () {
        state.batchStop = true;
        setStatus('正在停止...', true);
        twBootLog('正在停止批量预览...', true);
    };

    function saveBatchAll() {
        syncEditorToState();
        var ids = Object.keys(state.batchPreviews);
        if (!ids.length) {
            uiMsg('没有可入库的预览数据');
            return;
        }
        uiConfirm('确认将 <strong>' + ids.length + '</strong> 条预览结果写入数据库？此操作会覆盖目标语言对应字段。', function () {
            setStatus('批量入库中...', true);
            var chain = $.Deferred().resolve();
            var ok = 0;
            var fail = 0;
            ids.forEach(function (id) {
                chain = chain.then(function () {
                    var item = state.batchPreviews[id];
                    var fields = {};
                    Object.keys(item.fields || {}).forEach(function (name) {
                        fields[name] = item.fields[name].translated || '';
                    });
                    return saveOne(state.batchModule, id, state.batchLocale, fields).then(function (res) {
                        if (res.code === 0) {
                            ok++;
                            twBootLog('✓ #' + id + ' 已入库', false);
                        } else {
                            fail++;
                            twBootLog('✗ #' + id + ' 入库失败：' + (res.message || ''), true);
                        }
                    }, function (xhr) {
                        fail++;
                        twBootLog('✗ #' + id + ' 入库失败（' + xhr.status + '）', true);
                    });
                });
            });
            chain.always(function () {
                setStatus('就绪', false);
                twBootLog('<strong>批量入库完成：成功 ' + ok + '，失败 ' + fail + '</strong>', fail ? true : false);
            });
        });
    }

    window.twConfirmSave = function () {
        if (state.mode === 'batch') {
            saveBatchAll();
            return;
        }

        var sel = ensureBaseSelection(true);
        if (!sel) return;
        syncEditorToState();
        if (!Object.keys(state.translated).length) {
            uiMsg('请先点「预览当前记录」或「批量预览翻译」');
            return;
        }
        var fields = Object.keys(state.translated).join('、');
        uiConfirm('确认将 #' + sel.id + ' 的 [' + fields + '] 写入数据库？', function () {
            setStatus('保存中...', true);
            saveOne(sel.module, sel.id, sel.locale, state.translated).done(function (res) {
                setStatus('已入库', false);
                if (res.code === 0) twBootLog('✓ 已写入数据库（#' + sel.id + '）', false);
                else twBootLog('保存失败：' + (res.message || ''), true);
            }).fail(function (xhr) {
                setStatus('失败', false);
                twBootLog('保存失败（' + xhr.status + '）', true);
            });
        });
    };

    $(function () {
        $('#tw-preview-record').on('change', function () {
            showPreviewRecord($(this).val());
        });
        $('#tw-reload-records').off('click.tw').on('click.tw', function () {
            var module = selectedModule();
            if (!module) return uiMsg('请先选择数据表');
            var seq = ++state.loadSeq;
            setStatus('刷新记录...', true);
            $.ajax({
                url: apiPrefix + 'translateWorkbench/records',
                data: {
                    module: module,
                    keyword: $('#tw-keyword').val(),
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
                    twBootLog('刷新记录失败：' + (res.message || ''), true);
                }
            }).fail(function (xhr) {
                if (seq !== state.loadSeq) return;
                twBootLog('刷新记录失败（' + xhr.status + '）', true);
            }).always(function () {
                if (seq === state.loadSeq) setStatus('就绪', false);
            });
        });
        $('#tw-translate-one').on('click', function () { window.twPreviewTranslate(); });
        $('#tw-batch').on('click', function () { window.twBatchPreview(); });
        $('#tw-stop-batch').on('click', function () { window.twStopBatch(); });
        $('#tw-save-one').on('click', function () { window.twConfirmSave(); });
        $('#tw-fields-all').on('click', function () { $('#tw-fields input[name="tw-field"]').prop('checked', true); });
        $('#tw-fields-none').on('click', function () { $('#tw-fields input[name="tw-field"]').prop('checked', false); });
        $('#tw-clear-log').on('click', function () {
            state.logCount = 0;
            $('#tw-status-count').text('');
            $('#tw-log').html('<div class="tw-log-empty">选择数据后开始翻译</div>');
        });

        var initialModule = $('#tw-module').val();
        if (initialModule) window.twLoadModuleData(initialModule);

        twBootLog('工作台已就绪：单条/批量均可先预览，确认后再入库', false);
        updateSaveButtonState();
    });
})(window.jQuery);
</script>
