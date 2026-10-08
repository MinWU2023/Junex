<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('添加SNS图标') }}</div>
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
                    <form class="test-table-reload-btn layui-form" method="post" action="{{ route('admin.snsIcon.store') }}">
                        @csrf

                        <div class="layui-form-item">
                            <label class="layui-form-label"><x-admin.form-required />{{ __('标识') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="sign" value="{{ old('sign') }}" class="layui-input" placeholder="twitter / linkedin / youtube ..." required>
                                <div class="layui-form-mid layui-word-aux">{{ __('用于前台分享识别，建议小写英文，如 twitter、pinterest') }}</div>
                            </div>
                        </div>

                        <x-admin.image-upload :label="__('图标')" name="path" :value="old('path')" :required="true"/>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('链接') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="link" value="{{ old('link') }}" class="layui-input" placeholder="https://...">
                                <div class="layui-form-mid layui-word-aux">{{ __('页脚等场景跳转链接；产品分享无专用分享接口时也会回退到此链接') }}</div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="sort" value="{{ old('sort', 0) }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('静态链接') }}</label>
                            <div class="layui-input-block">
                                <select name="link_active">
                                    <option value="1" @if((string)old('link_active','1')==='1') selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if((string)old('link_active')==='0') selected @endif>{{ __('禁用') }}</option>
                                </select>
                                <div class="layui-form-mid layui-word-aux">{{ __('页脚等静态 SNS 链接展示') }}</div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('分享') }}</label>
                            <div class="layui-input-block">
                                <select name="share_active">
                                    <option value="1" @if((string)old('share_active','1')==='1') selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if((string)old('share_active')==='0') selected @endif>{{ __('禁用') }}</option>
                                </select>
                                <div class="layui-form-mid layui-word-aux">{{ __('产品/博客详情 Share 展示') }}</div>
                            </div>
                        </div>

                        <x-admin.multilingualism
                            :translateField="config('multilingual.snsIcon.value.translateField')"
                            value=""
                        />

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('保存') }}</button>
                                <a class="layui-btn layui-btn-primary" href="{{ route('admin.snsIcon.index') }}">{{ __('返回') }}</a>
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
                layui.form.render();
                layui.element.render();
            });
        </script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{ mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
