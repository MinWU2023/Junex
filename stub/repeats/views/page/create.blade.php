<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px;">
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
                        <form>
                            @csrf
                            <x-admin.multilingualism
                                :translateField="config('multilingual.page.value.translateField')"
                                value=""
                            >
                            </x-admin.multilingualism>
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                                       id="layuiadmin-app-create-form-submit" value="确认添加">
                            </div>
                        </form>
                    </div>
                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">上级分类</label>
                        <div class="layui-input-block">
                            <x-admin.form-category  name="parent_id" model="" :modelName="\App\Modules\Page\Models\Page::class">

                            </x-admin.form-category>
                        </div>
                    </div>
                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">排序（数字越大越靠前）</label>
                        <div class="layui-input-block">
                            <input type="number" value="0" name="sort" lay-verify="required" placeholder="请输入排序数字"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <x-admin.layui-upload label="分类封面上传" pathName="img_path" path=""></x-admin.layui-upload>
                    <x-admin.layui-upload-file-table></x-admin.layui-upload-file-table>
                </div>
                @role('超级管理员')
                <div class="layui-tab-item">
                    <x-admin.multilingualism
                        :translateField="config('multilingual.page.value.seoTranslateField')"
                        value=""
                    >
                    </x-admin.multilingualism>
                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">自定义url</label>
                        <div class="layui-input-block">
                            <input type="text" value="" name="url_key"  placeholder="请输入自定义url"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>

        @section('scripts')
            <script src="{{ mix('/js/admin/admin.page.js') }}"></script>
        @endsection

        @section('css')
            <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
        @endsection
    </body>
</x-layui-layout>
