<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">{{ __('基本设置') }}</li>
                <li>{{ __('图片上传') }}</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <form>
                            @csrf
                            @if(in_array('Translate',app('myAddons')) && auth()->user()->hasRole('超级管理员'))
                                <div class="layui-form-item">
                                    <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                                    <div class="layui-input-block">
                                        <input type="checkbox" name="is_translate"  lay-skin="switch">
                                    </div>
                                </div>
                            @endif
                            <x-admin.multilingualism
                                :translateField="config('multilingual.download.value.translateField')"
                                uploadType="download"
                                value=""
                            >
                            </x-admin.multilingualism>
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                                       id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                            </div>
                        </form>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('下载分类') }}</label>
                        <div class="layui-input-block">
                            <x-admin.form-base-category verify="required" :isSingle="true" name="download_category_id" model="" :modelName="\App\Modules\Download\Models\DownloadCategory::class">

                            </x-admin.form-base-category>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}</label>
                        <div class="layui-input-block">
                            <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item"  style="margin-top:15px;">
                    <x-admin.layui-upload label="{{ __('下载封面上传') }}" pathName="img" path=""  uploadType="download"></x-admin.layui-upload>
                    <x-admin.layui-upload-file label="{{ __('文件上传') }}" pathName="filepath" path=""></x-admin.layui-upload-file>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('请输入url链接') }}</label>
                        <div class="layui-input-block">
                            <input name="url"  placeholder="{{ __('请输入url链接') }}" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

        @section('scripts')
            <script src="{{ mix('/js/admin/admin.download.js') }}"></script>
        @endsection

        @section('css')
            <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
        @endsection
    </body>
</x-layui-layout>
