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
            .tw-workbench .tw-search-row { display: flex; gap: 8px; }
            .tw-workbench .tw-search-row .layui-input { flex: 1; }
            .tw-workbench .tw-fields-box {
                min-height: 72px;
                padding: 12px 14px;
                background: #fafbfc;
                border: 1px dashed #e2e8f0;
                border-radius: 6px;
            }
            .tw-workbench .tw-fields-box .layui-form-checkbox { margin: 6px 16px 6px 0; }
            .tw-workbench .tw-empty-hint { color: #999; font-size: 13px; padding: 8px 0; }
            .tw-workbench .tw-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                padding-top: 4px;
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
                        <form class="layui-form" lay-filter="translate-workbench-form">
                            <div class="tw-form-grid">
                                <div class="tw-form-group">
                                    <label><span class="tw-required">*</span>{{ __('数据表') }}</label>
                                    <select id="tw-module" lay-filter="tw-module">
                                        <option value="">{{ __('请选择数据表') }}</option>
                                    </select>
                                </div>
                                <div class="tw-form-group">
                                    <label><span class="tw-required">*</span>{{ __('目标语言') }}</label>
                                    <select id="tw-locale" lay-filter="tw-locale">
                                        <option value="">{{ __('请选择目标语言') }}</option>
                                    </select>
                                </div>
                                <div class="tw-form-group">
                                    <label><span class="tw-required">*</span>{{ __('记录') }}</label>
                                    <select id="tw-record" lay-search>
                                        <option value="">{{ __('请先选择数据表') }}</option>
                                    </select>
                                    <input type="number" id="tw-record-manual" class="layui-input" style="margin-top:8px;" placeholder="{{ __('或手动输入 ID') }}">
                                </div>
                                <div class="tw-form-group">
                                    <label>{{ __('搜索记录') }}</label>
                                    <div class="tw-search-row">
                                        <input type="text" id="tw-keyword" class="layui-input" placeholder="{{ __('ID 或名称') }}">
                                        <button type="button" class="layui-btn layui-btn-primary" id="tw-reload-records">
                                            <i class="layui-icon layui-icon-refresh"></i> {{ __('刷新') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="layui-card tw-panel">
                    <div class="layui-card-header">{{ __('② 选择翻译字段') }}</div>
                    <div class="layui-card-body">
                        <div class="tw-fields-box" id="tw-fields">
                            <div class="tw-empty-hint">{{ __('请先选择数据表，系统将自动加载可翻译字段') }}</div>
                        </div>
                        <div class="layui-form" style="margin-top:14px;">
                            <input type="checkbox" id="tw-skip-existing" title="{{ __('跳过目标语言已有内容的字段') }}" lay-skin="primary">
                        </div>
                    </div>
                </div>

                <div class="layui-card tw-panel">
                    <div class="layui-card-header">{{ __('③ 执行翻译') }}</div>
                    <div class="layui-card-body">
                        <div class="tw-actions">
                            <button type="button" class="layui-btn" id="tw-translate-one">
                                <i class="layui-icon layui-icon-fonts-i"></i> {{ __('翻译当前记录') }}
                            </button>
                            <button type="button" class="layui-btn layui-btn-normal" id="tw-save-one">
                                <i class="layui-icon layui-icon-ok"></i> {{ __('保存当前翻译') }}
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
        <script src="{{ asset('/js/admin/admin.translate.workbench.js') }}?v=2026101415"></script>
    @endsection
    </body>
</x-layui-layout>
