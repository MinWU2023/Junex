(function ($) {
    'use strict';

    if (!$) {
        return;
    }

    var prefix = '/' + (window.admin_prefix || 'nosay') + '/';

    var state = {
        modules: [],
        fields: [],
        records: [],
        translated: {},
        previewMeta: {},
        batchRunning: false,
        batchStop: false,
        logCount: 0
    };

    function uiMsg(text) {
        if (window.layui && layui.layer) {
            layui.layer.msg(text);
        } else {
            alert(text);
        }
    }

    function uiConfirm(text, onOk) {
        if (window.layui && layui.layer) {
            layui.layer.confirm(text, { icon: 3, title: '请确认' }, function (index) {
                layui.layer.close(index);
                onOk();
            });
        } else if (window.confirm(text)) {
            onOk();
        }
    }

    function uiLoading() {
        if (window.layui && layui.layer) {
            return layui.layer.load(2);
        }
        return null;
    }

    function uiCloseLoading(index) {
        if (window.layui && layui.layer && index) {
            layui.layer.close(index);
        }
    }

    function setStatus(text, loading) {
        $('#tw-status-text').text(text || '就绪');
        $('#tw-status-dot').toggleClass('loading', !!loading);
    }

    function clearLogEmpty() {
        $('#tw-log .tw-log-empty').remove();
    }

    function log(html, type) {
        clearLogEmpty();
        var color = type === 'error' ? '#ff6b6b' : (type === 'success' ? '#6ee7b7' : '#d4d4d4');
        var time = new Date().toLocaleTimeString();
        state.logCount++;
        $('#tw-status-count').text('共 ' + state.logCount + ' 条');
        $('#tw-log').prepend(
            '<div class="tw-log-item" style="color:' + color + '">' +
            '<div class="tw-log-time">' + time + '</div>' + html + '</div>'
        );
    }

    function apiGet(url, params) {
        return $.getJSON(prefix + url, params || {});
    }

    function apiPost(url, data) {
        data = data || {};
        data._token = $('#tw-token').val();
        return $.ajax({
            url: prefix + url,
            type: 'POST',
            data: data,
            dataType: 'json'
        });
    }

    function selectedModule() {
        return $('#tw-module').val();
    }

    function selectedLocale() {
        return $('#tw-locale').val();
    }

    function selectedRecordId() {
        var manual = $('#tw-record-manual').val();
        if (manual) {
            return manual;
        }
        return $('#tw-record').val();
    }

    function selectedFields() {
        var fields = [];
        $('#tw-fields input[name="tw-field"]:checked').each(function () {
            fields.push($(this).val());
        });
        return fields;
    }

    function escapeHtml(text) {
        return $('<div>').text(text || '').html();
    }

    function updateSaveButtonState() {
        var hasPreview = Object.keys(state.translated).length > 0;
        $('#tw-save-one').prop('disabled', !hasPreview);
        if (hasPreview) {
            $('#tw-save-one').removeClass('layui-btn-disabled');
        } else {
            $('#tw-save-one').addClass('layui-btn-disabled');
        }
    }

    function renderPreviewPanel() {
        var keys = Object.keys(state.translated);
        if (!keys.length) {
            $('#tw-preview-panel').hide();
            $('#tw-preview-body').empty();
            updateSaveButtonState();
            return;
        }

        var html = '<div class="tw-preview-tip">请检查下方翻译结果，可手动修改后再点击「确认写入数据库」。</div>';
        keys.forEach(function (name) {
            var meta = state.previewMeta[name] || { label: name, value: '', existing: '', is_rich: false };
            html += '<div class="tw-preview-item" data-field="' + escapeHtml(name) + '">';
            html += '<div class="tw-preview-title"><strong>' + escapeHtml(meta.label) + '</strong> (' + escapeHtml(name) + ')</div>';
            html += '<div class="tw-preview-grid">';
            html += '<div class="tw-preview-col"><div class="tw-preview-label">英文原文</div><pre class="tw-preview-box tw-preview-source">' + escapeHtml(meta.value) + '</pre></div>';
            html += '<div class="tw-preview-col"><div class="tw-preview-label">翻译预览（可编辑）</div>';
            html += '<textarea class="tw-preview-editor" data-field="' + escapeHtml(name) + '" rows="' + (meta.is_rich ? 8 : 3) + '">' + escapeHtml(state.translated[name]) + '</textarea>';
            if (meta.existing) {
                html += '<div class="tw-preview-existing">当前库中内容：' + escapeHtml(meta.existing) + '</div>';
            }
            html += '</div></div></div>';
        });

        $('#tw-preview-body').html(html);
        $('#tw-preview-panel').show();
        updateSaveButtonState();
    }

    function collectPreviewValues() {
        var result = {};
        $('#tw-preview-body .tw-preview-editor').each(function () {
            var field = $(this).data('field');
            result[field] = $(this).val();
        });
        state.translated = result;
        return result;
    }

    function ensureSelection(overrideId) {
        var module = selectedModule();
        var locale = selectedLocale();
        var id = overrideId || selectedRecordId();
        var fields = selectedFields();
        if (!module) {
            uiMsg('请选择数据表');
            return null;
        }
        if (!locale) {
            uiMsg('请选择目标语言');
            return null;
        }
        if (!id) {
            uiMsg('请选择或输入记录 ID');
            return null;
        }
        if (!fields.length) {
            uiMsg('请至少选择一个字段');
            return null;
        }
        return { module: module, locale: locale, id: id, fields: fields };
    }

    function translateField(field, target) {
        if (!field.value || !String(field.value).trim()) {
            return Promise.resolve('');
        }
        return apiPost('translateWorkbench/translate', {
            text: field.value,
            locale: target,
            type: field.type || 'text',
            is_rich: field.is_rich ? 1 : 0
        }).then(function (res) {
            if (res.code !== 0) {
                throw new Error(res.message || '翻译失败');
            }
            return res.data.text || '';
        });
    }

    function fetchSource(module, id, fields, locale) {
        return apiGet('translateWorkbench/source', {
            module: module,
            id: id,
            fields: fields,
            locale: locale || ''
        });
    }

    function saveTranslation(module, id, locale, fields) {
        return apiPost('translateWorkbench/save', {
            module: module,
            id: id,
            locale: locale,
            fields: fields
        });
    }

    function translateCurrent(autoSave, overrideId) {
        var sel = ensureSelection(overrideId);
        if (!sel) {
            return Promise.resolve();
        }

        state.translated = {};
        state.previewMeta = {};
        renderPreviewPanel();

        setStatus('翻译中 #' + sel.id + '...', true);
        log('<strong>开始预览翻译 #' + sel.id + '</strong>（不会自动写入数据库）');

        return fetchSource(sel.module, sel.id, sel.fields, sel.locale).then(function (res) {
            if (res.code !== 0) {
                setStatus('翻译失败', false);
                log('读取原文失败：' + (res.message || ''), 'error');
                return;
            }

            var data = res.data;
            var jobs = [];
            Object.keys(data.fields).forEach(function (fieldName) {
                jobs.push({ name: fieldName, meta: data.fields[fieldName] });
            });

            return jobs.reduce(function (chain, job) {
                return chain.then(function () {
                    if ($('#tw-skip-existing').prop('checked') && job.meta.existing && String(job.meta.existing).trim()) {
                        log('<div><strong>' + job.meta.label + '</strong> (' + job.name + ') — 已有翻译，已跳过</div>', 'success');
                        return;
                    }

                    state.previewMeta[job.name] = job.meta;
                    log('正在翻译字段：<strong>' + job.meta.label + '</strong> (' + job.name + ')');

                    return translateField(job.meta, sel.locale).then(function (translated) {
                        state.translated[job.name] = translated;
                        log('✓ 字段 <strong>' + job.name + '</strong> 翻译完成', 'success');
                        if (autoSave) {
                            return saveTranslation(sel.module, sel.id, sel.locale, state.translated).then(function (saveRes) {
                                if (saveRes.code === 0) {
                                    log('✓ 字段 <strong>' + job.name + '</strong> 已入库', 'success');
                                } else {
                                    log('✗ 字段 ' + job.name + ' 入库失败：' + (saveRes.message || ''), 'error');
                                }
                            });
                        }
                    }).catch(function (err) {
                        log('✗ 字段 ' + job.name + ' 翻译失败：' + (err.message || err), 'error');
                    });
                });
            }, Promise.resolve()).then(function () {
                setStatus('预览就绪', false);
                if (!autoSave) {
                    renderPreviewPanel();
                    log('翻译预览已生成，请检查预览区，确认后点击「确认写入数据库」', 'success');
                } else {
                    log('当前记录翻译并入库完成', 'success');
                }
            });
        }).catch(function (err) {
            setStatus('翻译失败', false);
            log('翻译过程异常：' + (err.message || err), 'error');
        });
    }

    function confirmAndSave() {
        var sel = ensureSelection();
        if (!sel) {
            return;
        }
        collectPreviewValues();
        if (!Object.keys(state.translated).length) {
            uiMsg('请先点击「预览翻译」生成结果');
            return;
        }

        var fieldList = Object.keys(state.translated).join('、');
        uiConfirm('确认将 #' + sel.id + ' 的以下字段写入数据库？<br><br>' + fieldList + '<br><br>此操作会覆盖目标语言对应字段。', function () {
            var loading = uiLoading();
            saveTranslation(sel.module, sel.id, sel.locale, state.translated).done(function (res) {
                uiCloseLoading(loading);
                if (res.code === 0) {
                    log('✓ 已确认写入数据库（记录 #' + sel.id + '）', 'success');
                    setStatus('已入库', false);
                } else {
                    log('保存失败：' + (res.message || ''), 'error');
                }
            }).fail(function (xhr) {
                uiCloseLoading(loading);
                log('保存失败（' + xhr.status + '）', 'error');
            });
        });
    }

    function runBatch() {
        var module = selectedModule();
        var locale = selectedLocale();
        var fields = selectedFields();
        if (!module || !locale || !fields.length) {
            uiMsg('请先选择数据表、目标语言和字段');
            return;
        }

        uiConfirm('批量模式将翻译后<strong>直接写入数据库</strong>，不会逐步预览。是否继续？', function () {
            state.batchRunning = true;
            state.batchStop = false;
            $('#tw-stop-batch').show();
            setStatus('批量翻译中...', true);

            apiGet('translateWorkbench/all-ids', { module: module }).done(function (res) {
                if (res.code !== 0) {
                    state.batchRunning = false;
                    $('#tw-stop-batch').hide();
                    setStatus('批量失败', false);
                    return log('加载批量 ID 失败', 'error');
                }
                var ids = res.data || [];
                if (!ids.length) {
                    state.batchRunning = false;
                    $('#tw-stop-batch').hide();
                    setStatus('就绪', false);
                    return uiMsg('没有可批量翻译的记录');
                }
                log('<strong>开始批量翻译，共 ' + ids.length + ' 条（自动入库）</strong>');
                var chain = Promise.resolve();
                ids.forEach(function (id) {
                    chain = chain.then(function () {
                        if (state.batchStop) {
                            return;
                        }
                        $('#tw-record').val(id);
                        $('#tw-record-manual').val('');
                        return translateCurrent(true, id);
                    });
                });
                chain.finally(function () {
                    state.batchRunning = false;
                    $('#tw-stop-batch').hide();
                    setStatus('就绪', false);
                    log(state.batchStop ? '批量翻译已停止' : '批量翻译全部完成', 'success');
                });
            });
        });
    }

    function bindEvents() {
        $('#tw-translate-one').off('click.tw').on('click.tw', function () {
            var loading = uiLoading();
            translateCurrent(false).finally(function () {
                uiCloseLoading(loading);
            });
        });

        $('#tw-save-one').off('click.tw').on('click.tw', confirmAndSave);

        $('#tw-batch').off('click.tw').on('click.tw', runBatch);

        $('#tw-stop-batch').off('click.tw').on('click.tw', function () {
            state.batchStop = true;
            setStatus('正在停止...', true);
        });

        $('#tw-clear-log').off('click.tw').on('click.tw', function () {
            state.logCount = 0;
            $('#tw-status-count').text('');
            $('#tw-log').html('<div class="tw-log-empty">选择数据后开始翻译，过程将显示在这里</div>');
        });

        $('#tw-fields-all').off('click.tw').on('click.tw', function () {
            $('#tw-fields input[name="tw-field"]').prop('checked', true);
        });

        $('#tw-fields-none').off('click.tw').on('click.tw', function () {
            $('#tw-fields input[name="tw-field"]').prop('checked', false);
        });
    }

    window.twWorkbench = {
        translateCurrent: translateCurrent,
        confirmAndSave: confirmAndSave,
        log: log,
        setStatus: setStatus,
        state: state
    };

    $(function () {
        bindEvents();
        updateSaveButtonState();
        log('翻译工作台已就绪：先预览翻译，确认后再写入数据库', 'success');
    });
})(window.jQuery);
