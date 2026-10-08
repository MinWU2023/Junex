<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('添加静态块') }}</div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="layui-bg-red" style="padding:10px;margin-bottom:10px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form class="layui-form" method="post" action="{{ route('admin.staticBlock.store') }}">
                    @csrf

                    <x-admin.multilingualism
                        :translateField="config('multilingual.staticBlock.value.translateField')"
                        value=""
                    >
                    </x-admin.multilingualism>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('标识') }}</label>
                        <div class="layui-input-block">
                            <input type="text" name="sign" value="{{ old('sign') }}" class="layui-input" lay-verify="required" placeholder="footer_about">
                            <div class="layui-word-aux">{{ __('前台调用用，唯一；仅字母数字下划线中划线') }}</div>
                        </div>
                    </div>

                    @include('Page.Views.staticBlock._page_fields')

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('备注') }}</label>
                        <div class="layui-input-block">
                            <input type="text" name="remark" value="{{ old('remark') }}" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('排序') }}</label>
                        <div class="layui-input-block">
                            <input type="number" name="sort" value="{{ old('sort', 0) }}" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('启用') }}</label>
                        <div class="layui-input-block">
                            <select name="active">
                                <option value="1" @if((string)old('active','1')==='1') selected @endif>{{ __('启用') }}</option>
                                <option value="0" @if((string)old('active')==='0') selected @endif>{{ __('禁用') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" type="submit">{{ __('保存') }}</button>
                            <a class="layui-btn layui-btn-primary" href="{{ route('admin.staticBlock.index') }}">{{ __('返回') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            layui.use(['form', 'element'], function () {
                layui.form.render();
                layui.element.render();
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
