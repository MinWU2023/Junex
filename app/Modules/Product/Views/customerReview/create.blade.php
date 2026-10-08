<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('添加评论') }}</div>
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
                    <form class="test-table-reload-btn layui-form" method="post" action="{{ route('admin.customerReview.store') }}">
                        @csrf

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('产品') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="product" value="{{ old('product') }}" class="layui-input">
                            </div>
                        </div>

                        <x-admin.multilingualism
                            :translateField="config('multilingual.customerReview.value.translateField')"
                            value=""
                        >
                        </x-admin.multilingualism>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('邮箱') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="email" value="{{ old('email') }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('用户名') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="username" value="{{ old('username') }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('评分') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="score" value="{{ old('score', 0) }}" class="layui-input" min="0" max="5">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('图片') }}</label>
                            <div class="layui-input-block" style="overflow:hidden;">
                                <x-admin.multiple-image
                                    name="imgs"
                                    display_name=""
                                    :images="[]"
                                />
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('保存') }}</button>
                                <a class="layui-btn layui-btn-primary" href="{{ route('admin.customerReview.index') }}">{{ __('返回') }}</a>
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
