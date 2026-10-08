<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                @if(session('success') || session('error') || $errors->any())
                    <div style="padding:10px 16px;margin-bottom:16px;border-radius:4px;font-size:14px;@if(session('success'))background:#f0f9eb;color:#67c23a;border:1px solid #e1f3d8;@else background:#fef0f0;color:#f56c6c;border:1px solid #fde2e2;@endif">
                        {{ session('success') ?: (session('error') ?: $errors->first()) }}
                    </div>
                @endif

                <div style="padding-bottom:15px;">
                    <form class="layui-form" method="get" action="{{ route('admin.frontPageList.index') }}">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        {{ __('名称 / 链接') }}：
                        <div class="layui-inline">
                            <input type="text" name="keyword" value="{{ $keyword }}" placeholder="{{ __('搜索名称或链接') }}" class="layui-input">
                        </div>
                        <button class="layui-btn" type="submit">{{ __('搜索') }}</button>
                        <a class="layui-btn layui-btn-primary" href="{{ route('admin.frontPageList.index', ['tab' => $tab]) }}">{{ __('重置') }}</a>
                    </form>
                </div>

                <div class="layui-tab layui-tab-brief">
                    <ul class="layui-tab-title">
                        @foreach($tabs as $tabKey => $tabLabel)
                            <li class="{{ $tab === $tabKey ? 'layui-this' : '' }}">
                                <a href="{{ route('admin.frontPageList.index', ['tab' => $tabKey, 'keyword' => $keyword]) }}">{{ $tabLabel }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <form method="post" action="{{ route('admin.frontPageList.batch') }}" id="front-page-batch-form">
                    @csrf
                    <input type="hidden" name="batch_action" id="front-page-batch-action" value="">
                    <div style="padding:12px 0;">
                        <button type="button" class="layui-btn layui-btn-sm" id="front-page-select-all">{{ __('全选') }}</button>
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" id="front-page-unselect-all">{{ __('取消全选') }}</button>
                        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" data-batch="sitemap_on">{{ __('批量开启 sitemap') }}</button>
                        <button type="button" class="layui-btn layui-btn-warm layui-btn-sm" data-batch="sitemap_off">{{ __('批量关闭 sitemap') }}</button>
                        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" data-batch="access_on">{{ __('批量开启访问') }}</button>
                        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" data-batch="access_off">{{ __('批量关闭访问') }}</button>
                        <button type="submit" class="layui-btn layui-btn-sm" form="front-page-sitemap-form">{{ __('生成 sitemap') }}</button>
                    </div>

                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th style="width:48px;"><input type="checkbox" id="front-page-check-head"></th>
                            <th>{{ __('名称') }}</th>
                            <th>{{ __('链接') }}</th>
                            <th>{{ __('来源') }}</th>
                            <th>{{ __('分类') }}</th>
                            <th>{{ __('Sitemap') }}</th>
                            <th>{{ __('访问') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $row)
                            @php $pathToken = $row['path'] === '' ? '/' : $row['path']; @endphp
                            <tr>
                                <td><input type="checkbox" class="front-page-check" name="paths[]" value="{{ $pathToken }}"></td>
                                <td>{{ $row['name'] }}</td>
                                <td><a href="{{ $row['url'] }}" target="_blank" rel="noopener">{{ $row['url'] }}</a></td>
                                <td>{{ $row['source_label'] }}</td>
                                <td>{{ $tabs[$row['tab']] ?? $row['tab'] }}</td>
                                <td>
                                    <button type="submit"
                                            class="layui-btn layui-btn-xs {{ $row['sitemap_on'] ? '' : 'layui-btn-primary' }}"
                                            form="front-page-toggle-form"
                                            formaction="{{ route('admin.frontPageList.toggle') }}"
                                            name="toggle_payload"
                                            value="sitemap_on|{{ (int)!$row['sitemap_on'] }}|{{ $pathToken }}">
                                        {{ $row['sitemap_on'] ? __('关闭 sitemap') : __('开启 sitemap') }}
                                    </button>
                                </td>
                                <td>
                                    @if($row['access_on'])
                                        <span class="layui-badge layui-bg-green" style="margin-right:6px;">{{ __('可访问') }}</span>
                                    @else
                                        <span class="layui-badge" style="margin-right:6px;">{{ __('已关闭') }}</span>
                                    @endif
                                    <button type="submit"
                                            class="layui-btn layui-btn-xs {{ $row['access_on'] ? 'layui-btn-danger' : 'layui-btn-normal' }}"
                                            form="front-page-toggle-form"
                                            formaction="{{ route('admin.frontPageList.toggle') }}"
                                            name="toggle_payload"
                                            value="access_on|{{ (int)!$row['access_on'] }}|{{ $pathToken }}">
                                        {{ $row['access_on'] ? __('关闭访问') : __('开启访问') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" style="text-align:center;color:#999;">{{ __('暂无页面') }}</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </form>

                <form id="front-page-toggle-form" method="post" action="{{ route('admin.frontPageList.toggle') }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="field" id="front-page-toggle-field">
                    <input type="hidden" name="value" id="front-page-toggle-value">
                    <input type="hidden" name="path" id="front-page-toggle-path">
                </form>
                <form id="front-page-sitemap-form" method="post" action="{{ route('admin.frontPageList.sitemap') }}" style="display:none;">
                    @csrf
                </form>

                <div style="text-align:right;">
                    {{ $items->links('pagination.front') }}
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            (function () {
                var checks = function () {
                    return Array.prototype.slice.call(document.querySelectorAll('.front-page-check'));
                };
                var head = document.getElementById('front-page-check-head');
                var selectAll = document.getElementById('front-page-select-all');
                var unselectAll = document.getElementById('front-page-unselect-all');
                function setAll(on) {
                    checks().forEach(function (el) { el.checked = on; });
                    if (head) head.checked = on && checks().length > 0;
                }
                if (head) head.addEventListener('change', function () { setAll(head.checked); });
                if (selectAll) selectAll.addEventListener('click', function () { setAll(true); });
                if (unselectAll) unselectAll.addEventListener('click', function () { setAll(false); });

                document.querySelectorAll('[data-batch]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        if (!checks().some(function (el) { return el.checked; })) {
                            alert('请先勾选页面');
                            return;
                        }
                        document.getElementById('front-page-batch-action').value = btn.getAttribute('data-batch');
                        document.getElementById('front-page-batch-form').submit();
                    });
                });

                document.querySelectorAll('button[name="toggle_payload"]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var parts = (btn.value || '').split('|');
                        document.getElementById('front-page-toggle-field').value = parts[0] || '';
                        document.getElementById('front-page-toggle-value').value = parts[1] || '0';
                        document.getElementById('front-page-toggle-path').value = parts.slice(2).join('|');
                    });
                });
            })();
        </script>
    @endsection
    </body>
</x-layui-layout>
