<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('编辑品牌解决方案') }}</div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="layui-bg-red" style="padding:10px;margin-bottom:10px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="table-reload-btn">
                    <form class="test-table-reload-btn layui-form" method="post" action="{{ route('admin.brandSolution.update', $model->id) }}">
                        @csrf
                        @method('PUT')

                        <x-admin.multilingualism
                            :translateField="config('multilingual.brandSolution.value.translateField')"
                            :value="$model"
                        >
                        </x-admin.multilingualism>

                        <x-admin.image-upload :label="__('图片')" name="path" :value="old('path', $model->path)" :required="true"/>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('按钮链接') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="button_url" value="{{ old('button_url', $model->button_url) }}" class="layui-input" placeholder="https://...">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="sort" value="{{ old('sort', $model->sort) }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('启用') }}</label>
                            <div class="layui-input-block">
                                <select name="active">
                                    <option value="1" @if((string)old('active', (string)$model->active)==='1') selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if((string)old('active', (string)$model->active)==='0') selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('保存') }}</button>
                                <a class="layui-btn layui-btn-primary" href="{{ route('admin.brandSolution.index') }}">{{ __('返回') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            layui.use(['form', 'element'], function () {
                var form = layui.form;
                var element = layui.element;
                form.render();
                element.render();
            });

            (function () {
                document.querySelectorAll('.translate-list-field').forEach(function (wrap) {
                    if (wrap.dataset.bound === '1') return;
                    wrap.dataset.bound = '1';
                    var locale = wrap.getAttribute('data-locale');
                    var field = wrap.getAttribute('data-field');
                    var rows = wrap.querySelector('.translate-list-rows');
                    var addBtn = wrap.querySelector('.translate-list-add');
                    if (!rows || !addBtn) return;

                    addBtn.addEventListener('click', function () {
                        var row = document.createElement('div');
                        row.className = 'translate-list-row';
                        row.style.cssText = 'display:flex;gap:8px;margin-bottom:8px;align-items:center;';
                        row.innerHTML = '<input type="text" name="translate[' + locale + '][' + field + '][]" value="" placeholder="请输入列表文案" autocomplete="off" class="layui-input">' +
                            '<button type="button" class="layui-btn layui-btn-danger layui-btn-sm translate-list-remove">删除</button>';
                        rows.appendChild(row);
                    });

                    wrap.addEventListener('click', function (e) {
                        var btn = e.target.closest('.translate-list-remove');
                        if (!btn || !wrap.contains(btn)) return;
                        var row = btn.closest('.translate-list-row');
                        if (!row) return;
                        if (rows.querySelectorAll('.translate-list-row').length <= 1) {
                            var input = row.querySelector('input');
                            if (input) input.value = '';
                            return;
                        }
                        row.remove();
                    });
                });
            })();
        </script>
    @endsection
    </body>
</x-layui-layout>
