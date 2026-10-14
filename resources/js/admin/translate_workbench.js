layui.config({
    base: '/ui/'
}).extend({
    index: 'lib/index'
}).use(['index', 'form', 'layer'], function () {
    var $ = layui.$;
    var form = layui.form;
    var layer = layui.layer;
    var prefix = layui.setter.prefix;

    var state = {
        modules: [],
        fields: [],
        records: [],
        translated: {},
        batchRunning: false,
        batchStop: false
    };

    function log(html, type) {
        var color = type === 'error' ? '#c00' : (type === 'success' ? '#16a291' : '#333');
        var time = new Date().toLocaleTimeString();
        $('#tw-log').prepend('<div style="margin-bottom:10px;border-bottom:1px dashed #eee;padding-bottom:8px;color:' + color + '"><div style="color:#999;font-size:12px;">' + time + '</div>' + html + '</div>');
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

    function renderSelect($el, items, valueKey, labelKey, placeholder) {
        var html = '<option value="">' + (placeholder || '请选择') + '</option>';
        items.forEach(function (item) {
            html += '<option value="' + item[valueKey] + '">' + item[labelKey] + '</option>';
        });
        $el.html(html);
        form.render('select');
    }

    function renderFields(fields) {
        if (!fields.length) {
            $('#tw-fields').html('<span style="color:#999;">暂无字段</span>');
            return;
        }
        var html = fields.map(function (field) {
            return '<input type="checkbox" name="tw-field" value="' + field.name + '" title="' + field.label + ' (' + field.name + ')" lay-skin="primary" checked>';
        }).join('');
        $('#tw-fields').html(html);
        form.render('checkbox');
    }

    function loadModules() {
        apiGet('translateWorkbench/modules').done(function (res) {
            if (res.code !== 0) {
                return log('加载数据表失败', 'error');
            }
            state.modules = res.data || [];
            renderSelect($('#tw-module'), state.modules.map(function (m) {
                return { key: m.key, label: m.label + ' (' + m.main_table + ')' };
            }), 'key', 'label', '请选择数据表');
        });
    }

    function loadLocales() {
        apiGet('translateWorkbench/locales').done(function (res) {
            if (res.code !== 0) {
                return log('加载语言失败', 'error');
            }
            renderSelect($('#tw-locale'), res.data || [], 'code', 'label', '请选择目标语言');
        });
    }

    function loadRecords() {
        var module = selectedModule();
        if (!module) {
            return;
        }
        apiGet('translateWorkbench/records', {
            module: module,
            keyword: $('#tw-keyword').val(),
            limit: 100
        }).done(function (res) {
            if (res.code !== 0) {
                return log('加载记录失败', 'error');
            }
            state.records = (res.data && res.data.items) || [];
            var html = '<option value="">请选择记录</option>';
            state.records.forEach(function (row) {
                html += '<option value="' + row.id + '">#' + row.id + ' - ' + row.label + '</option>';
            });
            $('#tw-record').html(html);
            form.render('select');
        });
    }

    function loadFields(module) {
        apiGet('translateWorkbench/fields', { module: module }).done(function (res) {
            if (res.code !== 0) {
                return log('加载字段失败', 'error');
            }
            state.fields = res.data || [];
            renderFields(state.fields);
        });
    }

    var TranslateEngine = {
        translateField: function (field, target) {
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
    };

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

    function ensureSelection(overrideId) {
        var module = selectedModule();
        var locale = selectedLocale();
        var id = overrideId || selectedRecordId();
        var fields = selectedFields();
        if (!module) {
            layer.msg('请选择数据表');
            return null;
        }
        if (!locale) {
            layer.msg('请选择目标语言');
            return null;
        }
        if (!id) {
            layer.msg('请选择记录ID');
            return null;
        }
        if (!fields.length) {
            layer.msg('请至少选择一个字段');
            return null;
        }
        return { module: module, locale: locale, id: id, fields: fields };
    }

    function translateCurrent(autoSave, overrideId) {
        var sel = ensureSelection(overrideId);
        if (!sel) {
            return Promise.resolve();
        }
        return fetchSource(sel.module, sel.id, sel.fields, sel.locale).then(function (res) {
            if (res.code !== 0) {
                log('读取原文失败：' + (res.message || ''), 'error');
                return;
            }
            var data = res.data;
            log('<strong>开始翻译 #' + data.id + ' ' + data.label + '</strong>');
            var jobs = [];
            Object.keys(data.fields).forEach(function (fieldName) {
                jobs.push({ name: fieldName, meta: data.fields[fieldName] });
            });
            return jobs.reduce(function (chain, job) {
                return chain.then(function () {
                    if ($('#tw-skip-existing').prop('checked') && job.meta.existing && String(job.meta.existing).trim()) {
                        log('<div><strong>字段：' + job.meta.label + ' (' + job.name + ')</strong> — 已有翻译，已跳过</div>', 'success');
                        return;
                    }
                    var existingHtml = job.meta.existing
                        ? '<div style="margin-top:6px;color:#888;">当前目标语言已有内容：</div><pre style="white-space:pre-wrap;background:#fff7e6;padding:8px;">' + $('<div>').text(job.meta.existing).html() + '</pre>'
                        : '<div style="margin-top:6px;color:#888;">当前目标语言暂无该字段内容</div>';
                    log('<div><strong>字段：' + job.meta.label + ' (' + job.name + ')</strong><br>类型：' + (job.meta.is_rich ? '富文本' : '纯文本') + '</div><div>英文原文：</div><pre style="white-space:pre-wrap;background:#f7f8fa;padding:8px;">' + $('<div>').text(job.meta.value).html() + '</pre>' + existingHtml);
                    return TranslateEngine.translateField(job.meta, sel.locale).then(function (translated) {
                        state.translated[job.name] = translated;
                        log('<div>翻译结果：</div><pre style="white-space:pre-wrap;background:#eefaf7;padding:8px;">' + $('<div>').text(translated).html() + '</pre>', 'success');
                        if (autoSave) {
                            return saveTranslation(sel.module, sel.id, sel.locale, state.translated).then(function (saveRes) {
                                if (saveRes.code === 0) {
                                    log('字段 ' + job.name + ' 已入库', 'success');
                                } else {
                                    log('字段 ' + job.name + ' 入库失败：' + (saveRes.message || ''), 'error');
                                }
                            });
                        }
                    }).catch(function (err) {
                        log('字段 ' + job.name + ' 翻译失败：' + (err.message || err), 'error');
                    });
                });
            }, Promise.resolve()).then(function () {
                if (!autoSave) {
                    log('当前记录翻译完成，可点击“保存当前翻译”入库', 'success');
                } else {
                    log('当前记录翻译并入库完成', 'success');
                }
            });
        });
    }

    function runBatch() {
        var module = selectedModule();
        var locale = selectedLocale();
        var fields = selectedFields();
        if (!module || !locale || !fields.length) {
            layer.msg('请先选择数据表、目标语言和字段');
            return;
        }
        state.batchRunning = true;
        state.batchStop = false;
        $('#tw-stop-batch').show();
        apiGet('translateWorkbench/all-ids', { module: module }).done(function (res) {
            if (res.code !== 0) {
                state.batchRunning = false;
                $('#tw-stop-batch').hide();
                return log('加载批量ID失败', 'error');
            }
            var ids = res.data || [];
            if (!ids.length) {
                state.batchRunning = false;
                $('#tw-stop-batch').hide();
                return layer.msg('没有可批量翻译的记录');
            }
            log('<strong>开始批量翻译，共 ' + ids.length + ' 条</strong>');
            var chain = Promise.resolve();
            ids.forEach(function (id) {
                chain = chain.then(function () {
                    if (state.batchStop) {
                        return;
                    }
                    $('#tw-record').val(id);
                    form.render('select');
                    state.translated = {};
                    return translateCurrent(true, id);
                });
            });
            chain.finally(function () {
                state.batchRunning = false;
                $('#tw-stop-batch').hide();
                log(state.batchStop ? '批量翻译已停止' : '批量翻译全部完成', 'success');
            });
        });
    }

    form.on('select(tw-module)', function (obj) {
        if (!obj.value) {
            $('#tw-fields').empty();
            $('#tw-record').html('<option value="">请先选择数据表</option>');
            form.render('select');
            return;
        }
        loadFields(obj.value);
        loadRecords();
    });

    $('#tw-reload-records').on('click', loadRecords);
    $('#tw-translate-one').on('click', function () {
        state.translated = {};
        var loading = layer.load(2);
        translateCurrent(false).finally(function () {
            layer.close(loading);
        });
    });
    $('#tw-save-one').on('click', function () {
        var sel = ensureSelection();
        if (!sel) {
            return;
        }
        if (!Object.keys(state.translated).length) {
            layer.msg('请先执行翻译');
            return;
        }
        saveTranslation(sel.module, sel.id, sel.locale, state.translated).done(function (res) {
            if (res.code === 0) {
                log('保存成功', 'success');
            } else {
                log('保存失败：' + (res.message || ''), 'error');
            }
        });
    });
    $('#tw-batch').on('click', function () {
        layer.confirm('确认按当前所选数据表、语言和字段批量翻译全部记录？', function (index) {
            layer.close(index);
            runBatch();
        });
    });
    $('#tw-stop-batch').on('click', function () {
        state.batchStop = true;
    });

    loadModules();
    loadLocales();
});
