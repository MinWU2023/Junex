<x-layui-layout>
    <body>
    <div class="layui-fluid tw-workbench">
        <style>
            .tw-workbench { padding-bottom: 20px; }
            .tw-workbench .tw-tip {
                background: linear-gradient(135deg, #f0f9ff 0%, #f6fffe 100%);
                border: 1px solid #d4edea;
                border-radius: 8px;
                padding: 14px 18px;
                color: #4a5568;
                font-size: 13px;
                line-height: 1.7;
                margin-bottom: 16px;
            }
            .tw-workbench .tw-tip strong { color: #16a291; }
            .tw-workbench .tw-panel { border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 16px; }
            .tw-workbench .tw-panel .layui-card-header {
                font-weight: 600;
                border-bottom: 1px solid #f0f0f0;
                background: #fafbfc;
            }
            .tw-workbench .tw-form-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px 20px;
            }
            @media (max-width: 992px) {
                .tw-workbench .tw-form-grid { grid-template-columns: 1fr; }
            }
            .tw-workbench .tw-form-group label {
                display: block;
                font-size: 13px;
                color: #666;
                margin-bottom: 8px;
                font-weight: 500;
            }
            .tw-workbench .tw-form-group label .tw-required { color: #ff5722; margin-right: 2px; }
            .tw-workbench .tw-form-group .layui-input,
            .tw-workbench .tw-form-group select { width: 100%; }
            /* 必须覆盖 layui-form select{display:none}，下拉框不能放在 .layui-form 内 */
            .tw-workbench select.tw-select,
            .tw-workbench .tw-form-group select.tw-select {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: 38px !important;
                min-height: 38px !important;
                line-height: 38px !important;
                padding: 0 12px !important;
                border: 1px solid #e6e6e6 !important;
                border-radius: 2px !important;
                background: #fff !important;
                color: #333 !important;
                box-sizing: border-box !important;
                appearance: auto !important;
                -webkit-appearance: menulist !important;
                cursor: pointer !important;
            }
            .tw-workbench .tw-form-group select.tw-select:focus {
                border-color: #16a291 !important;
                outline: none !important;
            }
            .tw-workbench .tw-search-row { display: flex; gap: 8px; }
            .tw-workbench .tw-search-row .layui-input { flex: 1; }
            .tw-workbench .tw-fields-box {
                min-height: 72px;
                padding: 12px 14px;
                background: #fafbfc;
                border: 1px dashed #e2e8f0;
                border-radius: 6px;
            }
            .tw-workbench .tw-fields-box .tw-field-check { margin: 6px 16px 6px 0; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13px; color: #333; }
            .tw-workbench .tw-fields-box .tw-field-check input { width: 16px; height: 16px; cursor: pointer; }
            .tw-workbench .tw-native-check { display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: #555; margin-top: 14px; }
            .tw-workbench .tw-native-check input { width: 16px; height: 16px; cursor: pointer; }
            .tw-workbench .tw-empty-hint { color: #999; font-size: 13px; padding: 8px 0; }
            .tw-workbench .tw-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                padding-top: 4px;
            }
            .tw-workbench .tw-preview-tip {
                background: #fffbe6;
                border: 1px solid #ffe58f;
                color: #8c6d1f;
                padding: 10px 12px;
                border-radius: 6px;
                margin-bottom: 14px;
                font-size: 13px;
            }
            .tw-workbench .tw-preview-item {
                border: 1px solid #e8e8e8;
                border-radius: 8px;
                padding: 12px;
                margin-bottom: 12px;
                background: #fff;
            }
            .tw-workbench .tw-preview-title { margin-bottom: 10px; font-size: 14px; }
            .tw-workbench .tw-preview-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            @media (max-width: 992px) {
                .tw-workbench .tw-preview-grid { grid-template-columns: 1fr; }
            }
            .tw-workbench .tw-preview-label {
                font-size: 12px;
                color: #888;
                margin-bottom: 6px;
            }
            .tw-workbench .tw-preview-box,
            .tw-workbench .tw-preview-editor {
                width: 100%;
                box-sizing: border-box;
                border: 1px solid #e6e6e6;
                border-radius: 4px;
                padding: 10px;
                font-size: 13px;
                line-height: 1.6;
                background: #fafbfc;
            }
            .tw-workbench .tw-preview-source {
                white-space: pre-wrap;
                word-break: break-word;
                margin: 0;
                min-height: 80px;
                max-height: 240px;
                overflow: auto;
            }
            .tw-workbench .tw-preview-editor {
                background: #f6fffe;
                border-color: #b7eb8f;
                resize: vertical;
            }
            .tw-workbench .tw-preview-existing {
                margin-top: 8px;
                font-size: 12px;
                color: #999;
                word-break: break-word;
            }
            .tw-workbench #tw-save-one.layui-btn-disabled {
                opacity: .55;
                cursor: not-allowed;
            }
            .tw-workbench .tw-log-panel .layui-card-body { padding: 0; }
            .tw-workbench #tw-log {
                min-height: 420px;
                max-height: calc(100vh - 220px);
                overflow: auto;
                padding: 14px 16px;
                font-size: 13px;
                line-height: 1.65;
                background: #1e1e1e;
                color: #d4d4d4;
                border-radius: 0 0 8px 8px;
            }
            .tw-workbench #tw-log .tw-log-empty {
                color: #888;
                text-align: center;
                padding: 60px 20px;
            }
            .tw-workbench #tw-log pre {
                white-space: pre-wrap;
                word-break: break-word;
                margin: 6px 0;
                padding: 8px 10px;
                border-radius: 4px;
                font-size: 12px;
                line-height: 1.5;
            }
            .tw-workbench .tw-log-item { margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #333; }
            .tw-workbench .tw-log-time { color: #888; font-size: 11px; margin-bottom: 4px; }
            .tw-workbench .tw-status-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 16px;
                background: #2d2d2d;
                border-bottom: 1px solid #404040;
                font-size: 12px;
                color: #aaa;
            }
            .tw-workbench .tw-status-dot {
                display: inline-block;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #52c41a;
                margin-right: 6px;
            }
            .tw-workbench .tw-status-dot.loading { background: #faad14; animation: tw-pulse 1s infinite; }
            @keyframes tw-pulse { 50% { opacity: .4; } }
        </style>

        <input type="hidden" id="tw-token" value="{{ csrf_token() }}">

        <div class="tw-tip">
            <strong>{{ __('使用说明') }}：</strong>
            {{ __('原文固定为英语(en)；目标语言来自多语言设置。纯文本直接翻译；富文本会提取 alt/title/placeholder 及标签文案后翻译并还原。同语言同记录同字段存在则更新，不存在则创建。') }}
        </div>

        <div class="layui-row layui-col-space16">
            <div class="layui-col-md7">
                <div class="layui-card tw-panel">
                    <div class="layui-card-header">{{ __('① 选择数据源') }}</div>
                    <div class="layui-card-body">
                        <div class="tw-form" id="translate-workbench-form">
                            <div class="tw-form-grid">
                                <div class="tw-form-group">
                                    <label for="tw-module"><span class="tw-required">*</span>{{ __('数据表') }}</label>
                                    <select id="tw-module" class="tw-select" style="display:block!important;width:100%;height:38px;">
                                        <option value="">{{ __('请选择数据表') }}</option>
                                        @foreach($modules ?? [] as $module)
                                            <option value="{{ $module['key'] }}" @selected(($selectedModule ?? '') === $module['key'])>{{ $module['label'] }} ({{ $module['main_table'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="tw-form-group">
                                    <label for="tw-locale"><span class="tw-required">*</span>{{ __('目标语言') }}</label>
                                    <select id="tw-locale" class="tw-select" style="display:block!important;width:100%;height:38px;">
                                        <option value="">{{ __('请选择目标语言') }}</option>
                                        @foreach($locales ?? [] as $locale)
                                            <option value="{{ $locale['code'] }}">{{ $locale['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="tw-form-group">
                                    <label for="tw-record">{{ __('记录') }} <span style="color:#999;font-weight:normal;">({{ __('下拉或手动输入ID，二选一') }})</span></label>
                                    <select id="tw-record" class="tw-select" style="display:block!important;width:100%;height:38px;">
                                        <option value="">{{ __('选择数据表后自动加载，或下方手动输入ID') }}</option>
                                    </select>
                                    <input type="number" id="tw-record-manual" class="layui-input" style="margin-top:8px;" placeholder="{{ __('手动输入记录 ID（知道ID时可直接填）') }}">
                                </div>
                                <div class="tw-form-group">
                                    <label for="tw-keyword">{{ __('搜索记录') }}</label>
                                    <div class="tw-search-row">
                                        <input type="text" id="tw-keyword" class="layui-input" placeholder="{{ __('ID 或名称') }}">
                                        <button type="button" class="layui-btn layui-btn-primary" id="tw-reload-records">
                                            <i class="layui-icon layui-icon-refresh"></i> {{ __('刷新') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-card tw-panel">
                    <div class="layui-card-header">{{ __('② 选择翻译字段') }}</div>
                    <div class="layui-card-body">
                        <div class="tw-fields-toolbar" style="margin-bottom:8px;display:none;" id="tw-fields-toolbar">
                            <button type="button" class="layui-btn layui-btn-xs layui-btn-primary" id="tw-fields-all">{{ __('全选') }}</button>
                            <button type="button" class="layui-btn layui-btn-xs layui-btn-primary" id="tw-fields-none">{{ __('全不选') }}</button>
                        </div>
                        <div class="tw-fields-box" id="tw-fields">
                            <div class="tw-empty-hint">{{ __('请先选择数据表，系统将自动加载可翻译字段') }}</div>
                        </div>
                        <label class="tw-native-check" for="tw-skip-existing">
                            <input type="checkbox" id="tw-skip-existing" name="tw-skip-existing" checked>
                            <span>{{ __('跳过目标语言已有内容的字段') }}</span>
                        </label>
                    </div>
                </div>

                <div class="layui-card tw-panel" id="tw-preview-panel" style="display:none;">
                    <div class="layui-card-header">{{ __('③ 翻译预览') }}</div>
                    <div class="layui-card-body" id="tw-preview-body"></div>
                </div>

                <div class="layui-card tw-panel">
                    <div class="layui-card-header">{{ __('④ 执行操作') }}</div>
                    <div class="layui-card-body">
                        <div class="tw-actions">
                            <button type="button" class="layui-btn" id="tw-translate-one">
                                <i class="layui-icon layui-icon-fonts-i"></i> {{ __('预览翻译') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-normal layui-btn-disabled" id="tw-save-one" disabled>
                                <i class="layui-icon layui-icon-ok"></i> {{ __('确认写入数据库') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-warm" id="tw-batch">
                                <i class="layui-icon layui-icon-play"></i> {{ __('批量翻译并入库') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-primary" id="tw-stop-batch" style="display:none;">
                                <i class="layui-icon layui-icon-pause"></i> {{ __('停止批量') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" id="tw-clear-log" style="margin-left:auto;">
                                <i class="layui-icon layui-icon-delete"></i> {{ __('清空日志') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md5">
                <div class="layui-card tw-panel tw-log-panel">
                    <div class="layui-card-header">{{ __('翻译过程') }}</div>
                    <div class="tw-status-bar">
                        <span><span class="tw-status-dot" id="tw-status-dot"></span><span id="tw-status-text">{{ __('就绪') }}</span></span>
                        <span id="tw-status-count"></span>
                    </div>
                    <div class="layui-card-body">
                        <div id="tw-log">
                            <div class="tw-log-empty">{{ __('选择数据后开始翻译，过程将显示在这里') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
        (function ($) {
            if (!$) return;
            var apiPrefix = '/' + (window.admin_prefix || '{{ config('app.admin_prefix') }}') + '/';

            function twBootLog(msg, isError) {
                var $log = $('#tw-log');
                if (!$log.length) return;
                $log.find('.tw-log-empty').remove();
                var color = isError ? '#ff6b6b' : '#6ee7b7';
                $log.prepend('<div class="tw-log-item" style="color:' + color + '"><div class="tw-log-time">' + new Date().toLocaleTimeString() + '</div>' + msg + '</div>');
            }

            function renderRecordOptions(items, total) {
                var html = '<option value="">请选择记录' + (total ? '（共' + total + '条）' : '') + '</option>';
                (items || []).forEach(function (row) {
                    html += '<option value="' + row.id + '">#' + row.id + ' - ' + row.label + '</option>';
                });
                $('#tw-record').html(html);
                if (!items || !items.length) {
                    twBootLog('未找到记录，可直接在下方手动输入 ID', true);
                } else {
                    twBootLog('已加载 <strong>' + items.length + '</strong> 条记录');
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
                    return '<label class="tw-field-check"><input type="checkbox" name="tw-field" value="' + field.name + '" checked> ' +
                        field.label + ' (' + field.name + ')</label>';
                }).join('');
                $('#tw-fields').html(html);
            }

            window.twLoadModuleData = function (module) {
                if (!module) {
                    $('#tw-fields-toolbar').hide();
                    $('#tw-fields').html('<div class="tw-empty-hint">请先选择数据表，系统将自动加载可翻译字段</div>');
                    $('#tw-record').html('<option value="">选择数据表后自动加载，或下方手动输入ID</option>');
                    return;
                }
                $.getJSON(apiPrefix + 'translateWorkbench/records', { module: module, limit: 100 })
                    .done(function (res) {
                        if (res.code === 0) {
                            renderRecordOptions(res.data && res.data.items, res.data && res.data.total);
                        } else {
                            twBootLog('加载记录失败：' + (res.message || '未知错误'), true);
                        }
                    })
                    .fail(function (xhr) {
                        twBootLog('加载记录接口失败（' + xhr.status + '），可手动输入 ID', true);
                    });
                $.getJSON(apiPrefix + 'translateWorkbench/fields', { module: module })
                    .done(function (res) {
                        if (res.code === 0) {
                            renderFieldOptions(res.data || []);
                        } else {
                            twBootLog('加载字段失败：' + (res.message || '未知错误'), true);
                        }
                    })
                    .fail(function (xhr) {
                        twBootLog('加载字段接口失败（' + xhr.status + '）', true);
                    });
            };

            $(function () {
                $('#tw-module').on('change', function () {
                    window.twLoadModuleData($(this).val());
                });
                $('#tw-reload-records').on('click', function () {
                    var module = $('#tw-module').val();
                    if (!module) return;
                    var keyword = $('#tw-keyword').val();
                    $.getJSON(apiPrefix + 'translateWorkbench/records', {
                        module: module,
                        keyword: keyword,
                        limit: 100
                    }, function (res) {
                        if (res.code === 0) {
                            renderRecordOptions(res.data && res.data.items, res.data && res.data.total);
                        }
                    });
                });
                var initialModule = $('#tw-module').val();
                if (initialModule) {
                    window.twLoadModuleData(initialModule);
                }
            });
        })(window.jQuery);
        </script>
        <script src="{{ asset('/js/admin/admin.translate.workbench.js') }}?v=2026101421"></script>
    @endsection
    </body>
</x-layui-layout>
