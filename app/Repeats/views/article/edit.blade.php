<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">基本设置</li>
                <li>图片上传</li>
                @role('超级管理员')
                <li>SEO设置</li>
                @endrole
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <input type="hidden" id="id" value="{{ $model->id }}">
                        <form>
                            @csrf
                            <x-admin.multilingualism
                                :translateField="config('multilingual.article.value.translateField')"
                                :value="$model">
                            </x-admin.multilingualism>
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                                       id="layuiadmin-app-edit-form-submit" value="确认添加">
                            </div>
                        </form>
                    </div>
                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">文章分类</label>
                        <div class="layui-input-block">
                            <x-admin.form-base-category verify="required" name="article_category_id" :model="$model" :modelName="\App\Modules\Article\Models\ArticleCategory::class">

                            </x-admin.form-base-category>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">自定义时间</label>
                        <div class="layui-input-block">
                            <input type="text"  name="customer_at" id="customer_at" value="{{ $model->customer_at }}"  placeholder="请选择自定义时间"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">排序（数字越大越靠前）</label>
                        <div class="layui-input-block">
                            <input type="number" value="{{ $model->sort }}" name="sort" lay-verify="required"
                                   placeholder="请输入排序数字" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <x-admin.layui-upload label="分类封面上传" pathName="path" :path="$model->path"></x-admin.layui-upload>
                    <x-admin.layui-upload-file-table :files="$model->articleFiles"></x-admin.layui-upload-file-table>
                </div>
                @role('超级管理员')
                <div class="layui-tab-item">
                    <x-admin.multilingualism
                        :translateField="config('multilingual.article.value.seoTranslateField')"
                        :value="$model"
                    >
                    </x-admin.multilingualism>

                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">自定义url</label>
                        <div class="layui-input-block">
                            <input name="url_key" value="{{ $model->url_key }}"  placeholder="请输入自定义url" autocomplete="off"
                                   class="layui-input">
                        </div>
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>

        @section('scripts')
            <script src="{{ mix('/js/admin/admin.article.js') }}"></script>
        @endsection
        @section('css')
            <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
