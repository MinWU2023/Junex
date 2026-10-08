<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card tips-to-help">
            <ul class="layui-tab-title">
                <li class="layui-this">{{ __('基本设置') }}</li>
                <li>{{ __('图片上传') }}</li>
                @role('超级管理员')
                <li>{{ __('SEO设置') }}</li>
                @endrole
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
                                :translateField="config('multilingual.product_category.value.translateField')"
                                uploadType="system"
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
                        <label class="layui-form-label">{{ __('上级分类') }}</label>
                        <div class="layui-input-block">
                            <x-admin.form-category  name="parent_id" model="" :modelName="\App\Modules\Product\Models\ProductCategory::class">

                            </x-admin.form-category>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
                        <div class="layui-input-block">
                            <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否显示') }}</label>
                        <div class="layui-input-block">
                            <div class="layui-col-md12">
                                <input type="radio" name="is_show" value="1" title="{{ __('显示') }}" checked>
                                <input type="radio" name="is_show" value="0" title="{{ __('不显示') }}">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否显示导航') }}</label>
                        <div class="layui-input-block">
                            <div class="layui-col-md12">
                                <input type="radio" name="is_menu" value="1" title="{{ __('显示') }}">
                                <input type="radio" name="is_menu" value="0" title="{{ __('不显示') }}" checked>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('展现形式') }}</label>
                        <div class="layui-input-block">
                            @foreach(\App\Modules\Product\Models\ProductCategory::displayModeOptions() as $modeValue => $modeLabel)
                                <input type="radio" name="display_mode" value="{{ $modeValue }}" title="{{ __($modeLabel) }}" @if($modeValue === \App\Modules\Product\Models\ProductCategory::DISPLAY_PRODUCT_LIST) checked @endif>
                            @endforeach
                            <div class="layui-word-aux" style="margin-top: 8px; clear: both; line-height: 1.6;">{{ __('产品列表形式：左侧分类栏+右侧产品列表；分类&产品形式：左侧分类栏+右侧按子分类展示产品（一行三个）') }}</div>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item" style="margin-top:10px;">
                    <x-admin.layui-upload label="{{ __('分类封面上传') }}" pathName="path" path="" uploadType="system"></x-admin.layui-upload>
                    <x-admin.layui-upload label="{{ __('分类banner上传') }}" pathName="logo" path="" uploadType="system"></x-admin.layui-upload>
                </div>

                @role('超级管理员')
                <div class="layui-tab-item">
                    <x-admin.multilingualism
                        :translateField="config('multilingual.product_category.value.seoTranslateField')"
                        value=""
                    >
                    </x-admin.multilingualism>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('自定义url') }}</label>
                        <div class="layui-input-block">
                            <input name="url_key" placeholder="{{ __('留空则按分类名称自动生成') }}" autocomplete="off"
                                   class="layui-input" disabled>
                            <div class="layui-form-mid layui-word-aux">{{ __('新建分类将根据名称自动生成 slug，无需填写') }}</div>
                        </div>
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.category.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
