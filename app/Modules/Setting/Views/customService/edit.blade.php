<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="font-size:16px;font-weight:bold;margin-bottom:16px;">{{ __('编辑定制服务列（一级）') }}</div>
                @if ($errors->any())
                    <div class="layui-bg-red" style="padding:10px;margin-bottom:10px;">
                        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                @endif

                <form class="layui-form" method="post" action="{{ route('admin.customService.update', $model->id) }}" id="cs-form">
                    @csrf
                    @method('PUT')
                    <x-admin.multilingualism
                        :translateField="config('multilingual.customService.value.translateField')"
                        :value="$model"
                    ></x-admin.multilingualism>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('标识 code') }}<span style="color:#FF5722;">*</span></label>
                        <div class="layui-input-block">
                            <input type="text" name="code" value="{{ old('code', $model->code) }}" class="layui-input" required>
                        </div>
                    </div>

                    <x-admin.image-upload :label="__('列背景图')" name="bg_image" :value="old('bg_image', $model->bg_image)" :required="false"/>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('布局') }}</label>
                        <div class="layui-input-block">
                            <select name="layout">
                                <option value="grid" @if(old('layout', $model->layout)==='grid') selected @endif>{{ __('网格（左侧ODM）') }}</option>
                                <option value="list" @if(old('layout', $model->layout)==='list') selected @endif>{{ __('列表（右侧OEM）') }}</option>
                            </select>
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

                    <fieldset class="layui-elem-field" style="margin-top:20px;">
                        <legend>{{ __('二级服务项') }}</legend>
                        <div class="layui-field-box">
                            <div id="cs-items">
                                @foreach($model->items as $i => $item)
                                    @include('Setting.Views.customService._item_row', [
                                        'index' => $i,
                                        'item' => $item,
                                        'locales' => $locales,
                                    ])
                                @endforeach
                            </div>
                            <button type="button" class="layui-btn layui-btn-primary" id="cs-item-add">{{ __('添加二级项') }}</button>
                        </div>
                    </fieldset>

                    <div class="layui-form-item" style="margin-top:20px;">
                        <div class="layui-input-block">
                            <button class="layui-btn" type="submit">{{ __('保存') }}</button>
                            <a class="layui-btn layui-btn-primary" href="{{ route('admin.customService.index') }}">{{ __('返回') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 用数字占位，避免 __INDEX__ 触发非数字运算 --}}
    <template id="cs-item-tpl">
        @include('Setting.Views.customService._item_row', ['index' => 9999, 'item' => null, 'locales' => $locales])
    </template>

    @section('scripts')
        <script>
            layui.use(['form', 'element'], function () {
                layui.form.render();
                layui.element.render();
            });

            (function () {
                var box = document.getElementById('cs-items');
                var tpl = document.getElementById('cs-item-tpl').innerHTML;
                var idx = {{ (int)$model->items->count() }};

                function bindRemove(scope) {
                    (scope || document).querySelectorAll('.cs-item-remove').forEach(function (btn) {
                        btn.onclick = function () {
                            var row = btn.closest('.cs-item-row');
                            if (row) row.remove();
                        };
                    });
                }
                bindRemove(box);

                document.getElementById('cs-item-add').addEventListener('click', function () {
                    var html = tpl.split('items[9999]').join('items[' + idx + ']');
                    html = html.split('cs-item-tabs-9999').join('cs-item-tabs-' + idx);
                    var wrap = document.createElement('div');
                    wrap.innerHTML = html;
                    var row = wrap.firstElementChild;
                    box.appendChild(row);
                    idx++;
                    bindRemove(row);
                    if (window.layui && layui.element) {
                        layui.element.render('tab');
                    }
                });
            })();
        </script>
    @endsection
    </body>
</x-layui-layout>
