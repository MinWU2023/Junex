<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('添加视频分类') }}</div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="layui-bg-red" style="padding:10px;margin-bottom:10px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form class="layui-form tips-to-help" method="post" action="{{ route('admin.productVideoCategory.store') }}">
                    @csrf
                    <div class="layui-tab layui-tab-card">
                        <ul class="layui-tab-title">
                            <li class="layui-this">{{ __('基本设置') }}</li>
                            <li>{{ __('图片上传') }}</li>
                            @role('超级管理员')
                            <li>{{ __('SEO设置') }}</li>
                            @endrole
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <x-admin.multilingualism
                                    :translateField="config('multilingual.productVideoCategory.value.translateField')"
                                    value=""
                                ></x-admin.multilingualism>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">{{ __('自定义URL') }}</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="url_key" value="{{ old('url_key') }}" class="layui-input" placeholder="{{ __('留空则按名称自动生成') }}">
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
                                            <option value="1" selected>{{ __('启用') }}</option>
                                            <option value="0">{{ __('禁用') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-tab-item" style="margin-top:10px;">
                                <x-admin.layui-upload :label="__('分类封面')" pathName="path" :path="old('path')" uploadType="system"/>
                            </div>
                            @role('超级管理员')
                            <div class="layui-tab-item">
                                <x-admin.multilingualism
                                    :translateField="config('multilingual.productVideoCategory.value.seoTranslateField')"
                                    value=""
                                ></x-admin.multilingualism>
                            </div>
                            @endrole
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top:15px;">
                        <div class="layui-input-block">
                            <button class="layui-btn layuiadmin-btn-list" type="submit" style="background:#656EE6!important;color:#fff!important;border:none!important;">{{ __('保存') }}</button>
                            <a class="layui-btn layui-btn-primary" href="{{ route('admin.productVideoCategory.index') }}">{{ __('返回') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            layui.config({
                base: '/ui/'
            }).extend({
                index: 'lib/index'
            }).use(['index', 'form', 'element', 'upload', 'uploadLaravel'], function () {
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
