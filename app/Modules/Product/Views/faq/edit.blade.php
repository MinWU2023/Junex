<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('编辑Faq') }}</div>
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
                    <form class="test-table-reload-btn layui-form" method="post" action="{{ route('admin.faq.update', $model->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('分组') }}<x-admin.form-required /></label>
                            <div class="layui-input-block">
                                <select name="faq_group_id">
                                    <option value="">{{ __('请选择') }}</option>
                                    @foreach(($groups ?? []) as $g)
                                        <option value="{{ $g->id }}" @if((int)old('faq_group_id', $model->faq_group_id)===(int)$g->id) selected @endif>{{ $g->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="sort" value="{{ old('sort', $model->sort ?? 0) }}" class="layui-input" autocomplete="off" style="max-width:200px;" min="0" step="1">
                                <div class="layui-form-mid layui-word-aux">{{ __('数值越大越靠前') }}</div>
                            </div>
                        </div>

                        <x-admin.multilingualism
                            :translateField="config('multilingual.faq.value.translateField')"
                            :value="$model"
                        >
                        </x-admin.multilingualism>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layuiadmin-btn-list" type="submit" style="background:#656EE6!important;color:#fff!important;border:none!important;">{{ __('保存') }}</button>
                                <a class="layui-btn layui-btn-primary" href="{{ route('admin.faq.index') }}">{{ __('返回') }}</a>
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
        </script>
    @endsection
    </body>
</x-layui-layout>
