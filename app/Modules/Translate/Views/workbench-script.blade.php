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
        logCount: 0
    };

    function twBootLog(msg, isError) {
        var $log = $('#tw-log');
        if (!$log.length) return;
        $log.find('.tw-log-empty').remove();
        state.logCount++;
        $('#tw-status-count').text('共 ' + state.logCount + ' 条');
        var color = isError ? '#ff6b6b' : (isError === false ? '#6ee7b7' : '#d4d4d4');
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

    function ensureSelection() {
        var module = selectedModule();
        var locale = selectedLocale();
        var id = selectedRecordId();
        var fields = selectedFields();
        if (!module) { uiMsg('请选择数据表'); return null; }
        if (!locale) { uiMsg('请选择目标语言'); return null; }
        if (!id) { uiMsg('请选择或输入记录 ID'); return null; }
        if (!fields.length) { uiMsg('请至少选择一个字段'); return null; }
        return { module: module, locale: locale, id: id, fields: fields };
    }

    function updateSaveButtonState() {
        var has = Object.keys(state.translated).length > 0;
        $('#tw-save-one').prop('disabled', !has).toggleClass('layui-btn-disabled', !has);
    }

    function renderPreviewPanel() {
        var keys = Object.keys(state.translated);
        if (!keys.length) {
            $('#tw-preview-panel').hide();
            $('#tw-preview-body').empty();
            updateSaveButtonState();
            return;
        }
        var html = '<div class="tw-preview-tip">请检查翻译结果，可修改后再点「确认写入数据库」。</div>';
        keys.forEach(function (name) {
            var meta = state.previewMeta[name] || { label: name, value: '', existing: '', is_rich: false };
            html += '<div class="tw-preview-item"><div class="tw-preview-title"><strong>' + escapeHtml(meta.label) + '</strong> (' + escapeHtml(name) + ')</div>';
            html += '<div class="tw-preview-grid"><div class="tw-preview-col"><div class="tw-preview-label">英文原文</div>';
            html += '<pre class="tw-preview-box tw-preview-source">' + escapeHtml(meta.value) + '</pre></div>';
            html += '<div class="tw-preview-col"><div class="tw-preview-label">翻译预览（可编辑）</div>';
            html += '<textarea class="tw-preview-editor" data-field="' + escapeHtml(name) + '" rows="' + (meta.is_rich ? 8 : 3) + '">' + escapeHtml(state.translated[name]) + '</textarea>';
            if (meta.existing) html += '<div class="tw-preview-existing">库中已有：' + escapeHtml(meta.existing) + '</div>';
            html += '</div></div></div>';
        });
        $('#tw-preview-body').html(html);
        $('#tw-preview-panel').show();
        updateSaveButtonState();
    }

    function collectPreviewValues() {
        var result = {};
        $('#tw-preview-body .tw-preview-editor').each(function () {
            result[$(this).data('field')] = $(this).val();
        });
        state.translated = result;
        return result;
    }

    function renderRecordOptions(items, total) {
        var html = '<option value="">请选择记录' + (total ? '（共' + total + '条）' : '') + '</option>';
        (items || []).forEach(function (row) {
            html += '<option value="' + row.id + '">#' + row.id + ' - ' + row.label + '</option>';
        });
        $('#tw-record').html(html);
        if (!items || !items.length) twBootLog('未找到记录，可手动输入 ID', true);
        else twBootLog('已加载 <strong>' + items.length + '</strong> 条记录', false);
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

    window.twLoadModuleData = function (module) {
        if (!module) {
            $('#tw-fields-toolbar').hide();
            $('#tw-fields').html('<div class="tw-empty-hint">请先选择数据表</div>');
            $('#tw-record').html('<option value="">选择数据表后自动加载</option>');
            return;
        }
        $.getJSON(apiPrefix + 'translateWorkbench/records', { module: module, limit: 100 })
            .done(function (res) { if (res.code === 0) renderRecordOptions(res.data && res.data.items, res.data && res.data.total); else twBootLog('加载记录失败：' + (res.message || ''), true); })
            .fail(function (xhr) { twBootLog('加载记录失败（' + xhr.status + '）', true); });
        $.getJSON(apiPrefix + 'translateWorkbench/fields', { module: module })
            .done(function (res) { if (res.code === 0) renderFieldOptions(res.data || []); else twBootLog('加载字段失败：' + (res.message || ''), true); })
            .fail(function (xhr) { twBootLog('加载字段失败（' + xhr.status + '）', true); });
    };

    function translateOneField(field, locale) {
        var d = $.Deferred();
        if (!field.value || !String(field.value).trim()) {
            d.resolve('');
            return d.promise();
        }
        $.ajax({
            url: apiPrefix + 'translateWorkbench/translate',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: csrfToken,
                text: field.value,
                locale: locale,
                type: field.type || 'text',
                is_rich: field.is_rich ? 1 : 0
            }
        }).done(function (res) {
            if (res.code === 0) d.resolve(res.data.text || '');
            else d.reject(res.message || '翻译失败');
        }).fail(function (xhr) {
            d.reject('翻译接口失败(' + xhr.status + ')');
        });
        return d.promise();
    }

    function runJobsSequentially(jobs, locale, index) {
        if (index >= jobs.length) {
            setStatus('预览就绪', false);
            renderPreviewPanel();
            twBootLog('预览完成，请检查后点「确认写入数据库」', false);
            return;
        }
        var job = jobs[index];
        if ($('#tw-skip-existing').prop('checked') && job.meta.existing && String(job.meta.existing).trim()) {
            twBootLog(job.meta.label + ' (' + job.name + ') 已有翻译，已跳过', false);
            runJobsSequentially(jobs, locale, index + 1);
            return;
        }
        state.previewMeta[job.name] = job.meta;
        twBootLog('正在翻译：<strong>' + job.meta.label + '</strong> (' + job.name + ')');
        translateOneField(job.meta, locale).done(function (text) {
            state.translated[job.name] = text;
            twBootLog('✓ ' + job.name + ' 翻译完成', false);
            runJobsSequentially(jobs, locale, index + 1);
        }).fail(function (err) {
            twBootLog('✗ ' + job.name + ' 失败：' + err, true);
            runJobsSequentially(jobs, locale, index + 1);
        });
    }

    window.twPreviewTranslate = function () {
        twBootLog('点击预览翻译...');
        var sel = ensureSelection();
        if (!sel) return;

        state.translated = {};
        state.previewMeta = {};
        $('#tw-preview-panel').hide();
        updateSaveButtonState();
        setStatus('翻译中 #' + sel.id + '...', true);
        twBootLog('<strong>开始预览 #' + sel.id + '</strong>（不写入数据库）');

        $.getJSON(apiPrefix + 'translateWorkbench/source', {
            module: sel.module,
            id: sel.id,
            locale: sel.locale,
            fields: sel.fields
        }).done(function (res) {
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
            runJobsSequentially(jobs, sel.locale, 0);
        }).fail(function (xhr) {
            setStatus('失败', false);
            twBootLog('读取原文接口失败（' + xhr.status + '）', true);
        });
    };

    window.twConfirmSave = function () {
        var sel = ensureSelection();
        if (!sel) return;
        collectPreviewValues();
        if (!Object.keys(state.translated).length) {
            uiMsg('请先点「预览翻译」');
            return;
        }
        var fields = Object.keys(state.translated).join('、');
        var doSave = function () {
            setStatus('保存中...', true);
            $.ajax({
                url: apiPrefix + 'translateWorkbench/save',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: csrfToken,
                    module: sel.module,
                    id: sel.id,
                    locale: sel.locale,
                    fields: state.translated
                }
            }).done(function (res) {
                setStatus('已入库', false);
                if (res.code === 0) twBootLog('✓ 已写入数据库（#' + sel.id + '）', false);
                else twBootLog('保存失败：' + (res.message || ''), true);
            }).fail(function (xhr) {
                setStatus('失败', false);
                twBootLog('保存失败（' + xhr.status + '）', true);
            });
        };
        if (window.layui && layui.layer) {
            layui.layer.confirm('确认将 #' + sel.id + ' 的 [' + fields + '] 写入数据库？', { icon: 3, title: '确认入库' }, function (i) {
                layui.layer.close(i);
                doSave();
            });
        } else if (confirm('确认写入数据库？字段：' + fields)) {
            doSave();
        }
    };

    $(function () {
        $('#tw-module').on('change', function () { window.twLoadModuleData($(this).val()); });
        $('#tw-reload-records').on('click', function () {
            var module = selectedModule();
            if (!module) return uiMsg('请先选择数据表');
            $.getJSON(apiPrefix + 'translateWorkbench/records', {
                module: module,
                keyword: $('#tw-keyword').val(),
                limit: 100
            }).done(function (res) {
                if (res.code === 0) renderRecordOptions(res.data && res.data.items, res.data && res.data.total);
            });
        });
        $('#tw-translate-one').on('click', function () { window.twPreviewTranslate(); });
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

        twBootLog('工作台已就绪：先预览翻译，确认后再入库', false);
        updateSaveButtonState();
    });
})(window.jQuery);
</script>
