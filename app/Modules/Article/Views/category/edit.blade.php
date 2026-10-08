<x-layui-layout>

    <body>
        <div class="layui-form base-form tips-to-help" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">{{ __('基本设置') }}</li>
                    <li>{{ __('图片上传') }}</li>
                    @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->article_category_seo_show)
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
                                <x-admin.multilingualism :translateField="config('multilingual.article_category.value.translateField')" uploadType="article" :value="$model">
                                </x-admin.multilingualism>
                                <div class="layui-form-item layui-hide">
                                    <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                                        id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }} ">
                                </div>
                            </form>
                        </div>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">{{ __('上级分类') }}</label>
                            <div class="layui-input-block">
                                <x-admin.form-category name="parent_id" :model="$model" :modelName="\App\Modules\Article\Models\ArticleCategory::class">

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
                    </div>
                    <div class="layui-tab-item" style="margin-top:15px">
                        <x-admin.layui-upload label="{{ __('分类封面上传') }}" pathName="path" :path="$model->path"
                            uploadType="article"></x-admin.layui-upload>
                    </div>
                    @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->article_category_seo_show)
                        <div class="layui-tab-item">
                            <x-admin.multilingualism :translateField="config('multilingual.article_category.value.seoTranslateField')" :value="$model">
                            </x-admin.multilingualism>
                            <div class="layui-form-item ">
                                <label class="layui-form-label">{{ __('自定义url') }}</label>
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
            <script src="{{ mix('/js/admin/admin.article.category.js') }}"></script>
        @endsection
        @section('css')
            <link rel="stylesheet" href="{{ mix('/css/admin/admin.form.css') }}" media="all">
        @endsection
    </body>
</x-layui-layout>
