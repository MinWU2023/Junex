<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-header">{{ __('翻译工作台') }}</div>
            <div class="layui-card-body">
                <blockquote class="layui-elem-quote">
                    {{ __('原文固定为英语(en)；目标语言来自多语言设置。纯文本直接翻译；富文本会提取 alt/title/placeholder 及标签文案后翻译并还原。同语言同记录同字段存在则更新，不存在则创建。') }}
                </blockquote>
                <input type="hidden" id="tw-token" value="{{ csrf_token() }}">
                <form class="layui-form" lay-filter="translate-workbench-form">
                    <div class="layui-row layui-col-space15">
                        <div class="layui-col-md3">
                            <label class="layui-form-label">{{ __('数据表') }}</label>
                            <div class="layui-input-block">
                                <select id="tw-module" lay-filter="tw-module">
                                    <option value="">{{ __('请选择') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-col-md3">
                            <label class="layui-form-label">{{ __('目标语言') }}</label>
                            <div class="layui-input-block">
                                <select id="tw-locale" lay-filter="tw-locale">
                                    <option value="">{{ __('请选择') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-col-md3">
                            <label class="layui-form-label">{{ __('记录ID') }}</label>
                            <div class="layui-input-block">
                                <select id="tw-record" lay-search>
                                    <option value="">{{ __('请先选择数据表') }}</option>
                                </select>
                                <input type="number" id="tw-record-manual" class="layui-input" style="margin-top:8px;" placeholder="{{ __('或手动输入ID') }}">
                            </div>
                        </div>
                        <div class="layui-col-md3">
                            <label class="layui-form-label">{{ __('搜索') }}</label>
                            <div class="layui-input-block" style="display:flex;gap:8px;">
                                <input type="text" id="tw-keyword" class="layui-input" placeholder="{{ __('ID或名称') }}">
                                <button type="button" class="layui-btn" id="tw-reload-records">{{ __('刷新') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item" style="margin-top:10px;">
                        <label class="layui-form-label">{{ __('翻译字段') }}</label>
                        <div class="layui-input-block" id="tw-fields"></div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('选项') }}</label>
                        <div class="layui-input-block">
                            <input type="checkbox" id="tw-skip-existing" title="{{ __('跳过目标语言已有内容的字段') }}" lay-skin="primary">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn" id="tw-translate-one">{{ __('翻译当前记录') }}</button>
                            <button type="button" class="layui-btn layui-btn-normal" id="tw-save-one">{{ __('保存当前翻译') }}</button>
                            <button type="button" class="layui-btn layui-btn-warm" id="tw-batch">{{ __('批量轮询翻译并入库') }}</button>
                            <button type="button" class="layui-btn layui-btn-primary" id="tw-stop-batch" style="display:none;">{{ __('停止批量') }}</button>
                        </div>
                    </div>
                </form>

                <fieldset class="layui-elem-field">
                    <legend>{{ __('翻译过程') }}</legend>
                    <div class="layui-field-box" id="tw-log" style="max-height:520px;overflow:auto;font-size:13px;line-height:1.6;"></div>
                </fieldset>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.translate.workbench.js') }}?v=2026101414"></script>
    @endsection
    </body>
</x-layui-layout>
