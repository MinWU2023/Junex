<x-layui-layout>

    <body>
        <div class="layui-form base-form tips-to-help" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">{{ __('基本设置') }}</li>
                    <li>{{ __('图片上传') }}</li>
                    @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->product_category_seo_show)
                        <li>{{ __('SEO设置') }}</li>
                    @endif
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <div class="layui-form-item">
                            <input type="hidden" id="id" value="{{ $model->id }}">
                            <form>
                                @csrf
                                @if (in_array('Translate', app('myAddons')) && auth()->user()->hasRole('超级管理员'))
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                                        <div class="layui-input-block">
                                            @if ($model->is_translate === 1)
                                                <input type="checkbox" name="is_translate" lay-skin="switch"
                                                    lay-text="开启|关闭">
                                                <span class="help-block">
                                                    <i class="fa fa-info-circle"></i>&nbsp;翻译成功
                                                    (最近翻译时间{{ $tr_success_at }})
                                                </span>
                                            @elseif($model->is_translate === 2)
                                                <input type="checkbox" checked name="is_translate" value="1"
                                                    lay-skin="switch" lay-text="开启|关闭">
                                                <span class="help-block">
                                                    <i class="fa fa-info-circle"></i>&nbsp;翻译任务失败,请重新翻译
                                                @elseif($model->is_translate === 3)
                                                    <input type="checkbox" disabled checked lay-skin="switch"
                                                        lay-text="开启|关闭">
                                                    <span class="help-block">
                                                        <i class="fa fa-info-circle"></i>&nbsp;正在进行翻译，请稍候...
                                                    @else
                                                        <input type="checkbox" name="is_translate" value="1"
                                                            lay-skin="switch" lay-text="开启|关闭">
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <x-admin.multilingualism :translateField="config('multilingual.product_category.value.translateField')" uploadType="system" :value="$model">
                                </x-admin.multilingualism>
                                <div class="layui-form-item layui-hide">
                                    <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                                        id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }}">
                                </div>
                            </form>
                        </div>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">{{ __('上级分类') }}</label>
                            <div class="layui-input-block">
                                <x-admin.form-category name="parent_id" :model="$model" :modelName="\App\Modules\Product\Models\ProductCategory::class">

                                </x-admin.form-category>

                            </div>
                        </div>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
                            <div class="layui-input-block">
                                <input type="number" value="{{ $model->sort }}" name="sort" lay-verify="required"
                                    placeholder="{{ __('请输入排序数字') }}" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">{{ __('是否显示') }}</label>
                            <div class="layui-input-block">
                                <div class="layui-col-md12">
                                    <input type="radio" name="is_show" value="1" title="{{ __('显示') }}"
                                        @if ($model->is_show === 1) checked @endif>
                                    <input type="radio" name="is_show" value="0" title="{{ __('不显示') }}"
                                        @if ($model->is_show === 0) checked @endif>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">{{ __('是否显示导航') }}</label>
                            <div class="layui-input-block">
                                <div class="layui-col-md12">
                                    <input type="radio" name="is_menu" value="1" title="{{ __('显示') }}"
                                        @if ($model->is_menu === 1) checked @endif>
                                    <input type="radio" name="is_menu" value="0" title="{{ __('不显示') }}"
                                        @if ($model->is_menu === 0) checked @endif>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">{{ __('展现形式') }}</label>
                            <div class="layui-input-block">
                                @php $currentDisplayMode = old('display_mode', $model->display_mode ?: \App\Modules\Product\Models\ProductCategory::DISPLAY_PRODUCT_LIST); @endphp
                                @foreach(\App\Modules\Product\Models\ProductCategory::displayModeOptions() as $modeValue => $modeLabel)
                                    <input type="radio" name="display_mode" value="{{ $modeValue }}" title="{{ __($modeLabel) }}"
                                        @if((string)$currentDisplayMode === (string)$modeValue) checked @endif>
                                @endforeach
                                <div class="layui-word-aux" style="margin-top: 8px; clear: both; line-height: 1.6;">{{ __('产品列表形式：左侧分类栏+右侧产品列表；分类&产品形式：左侧分类栏+右侧按子分类展示产品（一行三个）') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item" style="margin-top:10px;">
                        <x-admin.layui-upload label="{{ __('分类封面上传') }}" pathName="path" :path="$model->path"
                            uploadType="system"></x-admin.layui-upload>
                        <x-admin.layui-upload label="{{ __('分类banner上传') }}" pathName="logo" :path="$model->logo"
                            uploadType="system"></x-admin.layui-upload>
                    </div>

                    @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->product_category_seo_show)
                        <div class="layui-tab-item">
                            <x-admin.multilingualism :translateField="config('multilingual.product_category.value.seoTranslateField')" :value="$model">
                            </x-admin.multilingualism>
                            <div class="layui-form-item ">
                                <label class="layui-form-label">{{ __('自定义url') }}<x-admin.form-required /></label>
                                <div class="layui-input-block">
                                    <input name="url_key" value="{{ $model->url_key }}"
                                        placeholder="{{ __('请输入自定义url') }}" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @section('scripts')
            <script src="{{ mix('/js/admin/admin.category.js') }}"></script>
        @endsection
        @section('css')
            <link rel="stylesheet" href="{{ mix('/css/admin/admin.form.css') }}" media="all">
        @endsection
    </body>
</x-layui-layout>
