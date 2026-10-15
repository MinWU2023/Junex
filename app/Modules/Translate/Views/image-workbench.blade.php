<x-layui-layout>
    <body>
    <div class="layui-fluid iw-workbench">
        <style>
            .iw-workbench { padding-bottom: 20px; }
            .iw-workbench .iw-tip {
                background: linear-gradient(135deg, #fff7f0 0%, #fffaf6 100%);
                border: 1px solid #f0d9c4;
                border-radius: 8px;
                padding: 14px 18px;
                color: #4a5568;
                font-size: 13px;
                line-height: 1.7;
                margin-bottom: 16px;
            }
            .iw-workbench .iw-tip strong { color: #d46b08; }
            .iw-workbench .iw-panel { border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 16px; }
            .iw-workbench .iw-panel .layui-card-header {
                font-weight: 600;
                border-bottom: 1px solid #f0f0f0;
                background: #fafbfc;
            }
            .iw-workbench .iw-form-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px 20px;
            }
            @media (max-width: 992px) {
                .iw-workbench .iw-form-grid { grid-template-columns: 1fr; }
            }
            .iw-workbench .iw-form-group label {
                display: block;
                font-size: 13px;
                color: #666;
                margin-bottom: 8px;
                font-weight: 500;
            }
            .iw-workbench .iw-form-group label .iw-required { color: #ff5722; margin-right: 2px; }
            .iw-workbench .iw-form-group .layui-input,
            .iw-workbench .iw-form-group select { width: 100%; }
            .iw-workbench select.iw-select,
            .iw-workbench .iw-form-group select.iw-select {
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
            .iw-workbench .iw-form-group select.iw-select:focus {
                border-color: #d46b08 !important;
                outline: none !important;
            }
            .iw-workbench .iw-search-row { display: flex; gap: 8px; }
            .iw-workbench .iw-search-row .layui-input { flex: 1; }
            .iw-workbench .iw-fields-box {
                min-height: 72px;
                padding: 12px 14px;
                background: #fafbfc;
                border: 1px dashed #e2e8f0;
                border-radius: 6px;
            }
            .iw-workbench .iw-fields-box .iw-field-check {
                margin: 6px 16px 6px 0;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                cursor: pointer;
                font-size: 13px;
                color: #333;
            }
            .iw-workbench .iw-fields-box .iw-field-check input { width: 16px; height: 16px; cursor: pointer; }
            .iw-workbench .iw-empty-hint { color: #999; font-size: 13px; padding: 8px 0; }
            .iw-workbench .iw-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                padding-top: 4px;
            }
            .iw-workbench .iw-preview-switch {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 10px;
                margin-bottom: 14px;
                padding: 10px 12px;
                background: #fff7e6;
                border: 1px solid #ffd591;
                border-radius: 6px;
            }
            .iw-workbench .iw-preview-switch label { font-size: 13px; color: #555; white-space: nowrap; }
            .iw-workbench .iw-preview-switch select {
                flex: 1;
                min-width: 180px;
                height: 36px;
                padding: 0 10px;
                border: 1px solid #e6e6e6;
                border-radius: 2px;
                background: #fff;
            }
            .iw-workbench .iw-preview-switch .iw-preview-count { font-size: 12px; color: #888; }
            .iw-workbench .iw-locale-block {
                border: 1px solid #e8e8e8;
                border-radius: 8px;
                margin-bottom: 14px;
                overflow: hidden;
            }
            .iw-workbench .iw-locale-head {
                padding: 10px 12px;
                background: #fafbfc;
                border-bottom: 1px solid #eee;
                font-size: 13px;
                font-weight: 600;
            }
            .iw-workbench .iw-locale-head .iw-badge {
                display: inline-block;
                margin-left: 8px;
                padding: 1px 8px;
                border-radius: 10px;
                background: #fff7e6;
                color: #d46b08;
                font-size: 12px;
                font-weight: 500;
            }
            .iw-workbench .iw-preview-item {
                border-top: 1px solid #f0f0f0;
                padding: 12px;
                background: #fff;
            }
            .iw-workbench .iw-preview-title { margin-bottom: 10px; font-size: 14px; }
            .iw-workbench .iw-preview-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            @media (max-width: 992px) {
                .iw-workbench .iw-preview-grid { grid-template-columns: 1fr; }
            }
            .iw-workbench .iw-preview-label { font-size: 12px; color: #888; margin-bottom: 6px; }
            .iw-workbench .iw-preview-box,
            .iw-workbench .iw-preview-editor {
                width: 100%;
                box-sizing: border-box;
                border: 1px solid #e6e6e6;
                border-radius: 4px;
                padding: 10px;
                font-size: 13px;
                line-height: 1.6;
                background: #fafbfc;
            }
            .iw-workbench .iw-preview-source {
                white-space: pre-wrap;
                word-break: break-word;
                margin: 0;
                min-height: 80px;
                max-height: 240px;
                overflow: auto;
            }
            .iw-workbench .iw-preview-editor {
                background: #fffaf0;
                border-color: #ffd591;
                resize: vertical;
            }
            .iw-workbench .iw-unchanged { opacity: .65; }
            .iw-workbench #iw-save-one.layui-btn-disabled { opacity: .55; cursor: not-allowed; }
            .iw-workbench .iw-log-panel .layui-card-body { padding: 0; }
            .iw-workbench #iw-log {
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
            .iw-workbench #iw-log .iw-log-empty { color: #888; text-align: center; padding: 60px 20px; }
            .iw-workbench .iw-log-item { margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #333; }
            .iw-workbench .iw-log-time { color: #888; font-size: 11px; margin-bottom: 4px; }
            .iw-workbench .iw-status-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 16px;
                background: #2d2d2d;
                border-bottom: 1px solid #404040;
                font-size: 12px;
                color: #aaa;
            }
            .iw-workbench .iw-status-dot {
                display: inline-block;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #52c41a;
                margin-right: 6px;
            }
            .iw-workbench .iw-status-dot.loading { background: #faad14; animation: iw-pulse 1s infinite; }
            @keyframes iw-pulse { 50% { opacity: .4; } }
            .iw-workbench .iw-save-progress {
                display: none;
                margin-top: 14px;
                padding: 12px 14px;
                border: 1px solid #e6e6e6;
                border-radius: 6px;
                background: #fafafa;
            }
            .iw-workbench .iw-save-progress.is-active { display: block; }
            .iw-workbench .iw-save-progress-title { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 8px; }
            .iw-workbench .iw-save-progress-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 10px 16px;
                font-size: 12px;
                color: #666;
                margin-bottom: 10px;
            }
            .iw-workbench .iw-save-progress-meta strong { color: #d46b08; }
            .iw-workbench .iw-save-progress-meta .iw-ok { color: #52c41a; }
            .iw-workbench .iw-save-progress-meta .iw-fail { color: #ff4d4f; }
            .iw-workbench .iw-progress-track {
                height: 10px;
                background: #ececec;
                border-radius: 999px;
                overflow: hidden;
            }
            .iw-workbench .iw-progress-bar {
                height: 100%;
                width: 0;
                background: linear-gradient(90deg, #d46b08, #fa8c16);
                border-radius: 999px;
                transition: width .25s ease;
            }
            .iw-workbench .iw-progress-bar.is-fail { background: linear-gradient(90deg, #fa8c16, #ff4d4f); }
            .iw-workbench .iw-progress-bar.is-done { background: linear-gradient(90deg, #52c41a, #73d13d); }
            .iw-workbench .iw-save-progress-result { margin-top: 8px; font-size: 12px; color: #555; }
        </style>

        <div class="iw-tip">
            <strong>{{ __('使用说明') }}：</strong>
            {{ __('选择数据表与记录后，系统会处理该记录下「全部语言」的翻译表字段：将 src / style 中 background(url) 引用的图片地址，若匹配你填写的域名，则改为以 / 开头的相对路径（去掉域名，并避免开头出现 //）。先预览，确认后再回写。') }}
        </div>

        <div class="layui-row layui-col-space16">
            <div class="layui-col-md7">
                <div class="layui-card iw-panel">
                    <div class="layui-card-header">{{ __('① 选择数据源') }}</div>
                    <div class="layui-card-body">
                        <div class="iw-form">
                            <div class="iw-form-grid">
                                <div class="iw-form-group">
                                    <label for="iw-module"><span class="iw-required">*</span>{{ __('数据表') }}</label>
                                    <select id="iw-module" class="iw-select" style="display:block!important;width:100%;height:38px;" onchange="window.iwLoadModuleData&&window.iwLoadModuleData(this.value);">
                                        <option value="">{{ __('请选择数据表') }}</option>
                                        @foreach($modules ?? [] as $module)
                                            <option value="{{ $module['key'] }}" @selected(($selectedModule ?? '') === $module['key'])>{{ $module['label'] }} ({{ $module['main_table'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="iw-form-group">
                                    <label for="iw-domain"><span class="iw-required">*</span>{{ __('要剥离的域名') }}</label>
                                    <input type="text" id="iw-domain" class="layui-input" value="{{ $defaultDomain ?? 'https://minge2601.dyyweb.com' }}" placeholder="https://minge2601.dyyweb.com">
                                </div>
                                <div class="iw-form-group">
                                    <label for="iw-record">{{ __('记录') }} <span style="color:#999;font-weight:normal;">({{ __('下拉或手动输入ID') }})</span></label>
                                    <select id="iw-record" class="iw-select" style="display:block!important;width:100%;height:38px;">
                                        <option value="">{{ __('选择数据表后自动加载，或下方手动输入ID') }}</option>
                                    </select>
                                    <input type="number" id="iw-record-manual" class="layui-input" style="margin-top:8px;" placeholder="{{ __('手动输入记录 ID') }}">
                                </div>
                                <div class="iw-form-group">
                                    <label for="iw-keyword">{{ __('搜索记录') }}</label>
                                    <div class="iw-search-row">
                                        <input type="text" id="iw-keyword" class="layui-input" placeholder="{{ __('ID 或名称') }}">
                                        <button type="button" class="layui-btn layui-btn-primary" id="iw-reload-records">
                                            <i class="layui-icon layui-icon-refresh"></i> {{ __('刷新') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-card iw-panel">
                    <div class="layui-card-header">{{ __('② 选择翻译字段') }}</div>
                    <div class="layui-card-body">
                        <div class="iw-fields-toolbar" style="margin-bottom:8px;display:none;" id="iw-fields-toolbar">
                            <button type="button" class="layui-btn layui-btn-xs layui-btn-primary" id="iw-fields-all">{{ __('全选') }}</button>
                            <button type="button" class="layui-btn layui-btn-xs layui-btn-primary" id="iw-fields-none">{{ __('全不选') }}</button>
                        </div>
                        <div class="iw-fields-box" id="iw-fields">
                            <div class="iw-empty-hint">{{ __('请先选择数据表，系统将自动加载可翻译字段') }}</div>
                        </div>
                    </div>
                </div>

                <div class="layui-card iw-panel" id="iw-preview-panel" style="display:none;">
                    <div class="layui-card-header">{{ __('③ 替换预览') }}</div>
                    <div class="layui-card-body">
                        <div class="iw-preview-switch" id="iw-preview-switch" style="display:none;">
                            <label for="iw-preview-record">{{ __('切换预览记录') }}</label>
                            <select id="iw-preview-record" class="iw-select" style="display:block!important;"></select>
                            <span class="iw-preview-count" id="iw-preview-count"></span>
                        </div>
                        <div id="iw-preview-body"></div>
                    </div>
                </div>

                <div class="layui-card iw-panel">
                    <div class="layui-card-header">{{ __('④ 执行操作') }}</div>
                    <div class="layui-card-body">
                        <div class="iw-actions">
                            <button type="button" class="layui-btn" id="iw-preview-one" onclick="window.iwPreviewOne&&window.iwPreviewOne();return false;">
                                <i class="layui-icon layui-icon-search"></i> {{ __('预览当前记录') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-warm" id="iw-batch" onclick="window.iwBatchPreview&&window.iwBatchPreview();return false;">
                                <i class="layui-icon layui-icon-play"></i> {{ __('批量预览') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-primary" id="iw-stop-batch" style="display:none;" onclick="window.iwStopBatch&&window.iwStopBatch();return false;">
                                <i class="layui-icon layui-icon-pause"></i> {{ __('停止批量') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-normal layui-btn-disabled" id="iw-save-one" disabled onclick="window.iwConfirmSave&&window.iwConfirmSave();return false;">
                                <i class="layui-icon layui-icon-ok"></i> {{ __('确认写入数据库') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" id="iw-clear-log" style="margin-left:auto;">
                                <i class="layui-icon layui-icon-delete"></i> {{ __('清空日志') }}
                            </button>
                        </div>
                        <div class="iw-save-progress" id="iw-save-progress" aria-live="polite">
                            <div class="iw-save-progress-title" id="iw-save-progress-title">{{ __('写入数据库进度') }}</div>
                            <div class="iw-save-progress-meta">
                                <span>{{ __('共') }} <strong id="iw-save-total">0</strong> {{ __('条') }}</span>
                                <span>{{ __('已处理') }} <strong id="iw-save-done">0</strong> {{ __('条') }}</span>
                                <span class="iw-ok">{{ __('成功') }} <strong id="iw-save-ok">0</strong></span>
                                <span class="iw-fail">{{ __('失败') }} <strong id="iw-save-fail">0</strong></span>
                            </div>
                            <div class="iw-progress-track">
                                <div class="iw-progress-bar" id="iw-save-progress-bar"></div>
                            </div>
                            <div class="iw-save-progress-result" id="iw-save-progress-result"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md5">
                <div class="layui-card iw-panel iw-log-panel">
                    <div class="layui-card-header">{{ __('处理过程') }}</div>
                    <div class="iw-status-bar">
                        <span><span class="iw-status-dot" id="iw-status-dot"></span><span id="iw-status-text">{{ __('就绪') }}</span></span>
                        <span id="iw-status-count"></span>
                    </div>
                    <div class="layui-card-body">
                        <div id="iw-log">
                            <div class="iw-log-empty">{{ __('选择数据后开始处理，过程将显示在这里') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        @include('Translate.Views.image-workbench-script')
    @endsection
    </body>
</x-layui-layout>
