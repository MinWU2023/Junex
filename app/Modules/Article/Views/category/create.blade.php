<x-layui-layout>
    <body>
    <div class="layui-form base-form tips-to-help" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
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
                                :translateField="config('multilingual.article_category.value.translateField')"
                                uploadType="article"
                                value=""
                            >
                            </x-admin.multilingualism>
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                                       id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                            </div>
                        </form>
                    </div>
                    <div class="layui-form-item ">
                        <label class="layui-form-label">{{ __('上级分类') }}</label>
                        <div class="layui-input-block">
                            <x-admin.form-category  name="parent_id" model="" :modelName="\App\Modules\Article\Models\ArticleCategory::class">

                            </x-admin.form-category>
                        </div>
                    </div>
                    <div class="layui-form-item ">
                        <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
                        <div class="layui-input-block">
                            <input type="number" value="0" name="sort" lay-verify="required" placeholder="请输入排序数字"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>


                </div>
                <div class="layui-tab-item" style="margin-top:15px">
                    <x-admin.layui-upload label="{{ __('分类封面上传') }}" pathName="path" path="" uploadType="article"></x-admin.layui-upload>
                </div>
                @role('超级管理员')
                <div class="layui-tab-item">
                    <x-admin.multilingualism
                        :translateField="config('multilingual.article_category.value.seoTranslateField')"
                        value=""
                    >
                    </x-admin.multilingualism>


                    <div class="layui-form-item ">
                        <label class="layui-form-label">{{ __('自定义url') }}</label>
                        <div class="layui-input-block">
                            <input type="text" value="" name="url_key"  placeholder="{{ __('请输入自定义url') }}"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.article.category.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
