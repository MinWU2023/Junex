<x-layui-layout>
    <body>
    <div id="app" class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
                <div class="layui-tab layui-tab-card">
                    <ul class="layui-tab-title">
                        <li class="layui-this">基本信息</li>
                        <li>产品属性</li>
                        <li>图片上传</li>
                        @role('超级管理员')
                        <li>SEO设置</li>
                        @endrole
                        <li>Tag设置</li>
                    </ul>
                    <div class="layui-tab-content">
                        <input type="hidden" id="id" value="{{ $model->id }}">
                        <div class="layui-tab-item layui-show">
                            <div class="layui-form-item">
                                <form>
                                    @csrf
                                    <x-admin.multilingualism
                                        :translateField="config('multilingual.product.value.translateField')"
                                        :value="$model"
                                    >
                                    </x-admin.multilingualism>
                                    <div class="layui-form-item layui-hide">
                                        <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                                               id="layuiadmin-app-create-form-submit" value="确认添加">
                                    </div>
                                </form>
                            </div>
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">排序（数字越大越靠前）</label>
                                <div class="layui-input-block">
                                    <input type="number" value="{{ $model->sort }}" name="sort" lay-verify="required"
                                           placeholder="请输入排序数字" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">分类</label>
                                <div class="layui-input-block">
                                    <category-component :id="{{$model->id}}" type="product"></category-component>
                                </div>
                            </div>


                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">文章</label>
                                <div class="layui-input-block">
                                    <product-article-component :id="{{$model->id}}" ></product-article-component>
                                </div>
                            </div>

                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">品牌</label>
                                <div class="layui-input-block">
                                    <x-admin.form-select-brand verify="" :brand="$model->productBrand"></x-admin.form-select-brand>
                                </div>
                            </div>
                        </div>
                        <div class="layui-tab-item">
                            <div class="layui-form-item add-space-20">
                                <label class="layui-form-label">属性分类选择</label>
                                <div class="layui-input-block">
                                    <select lay-filter="categorySelect" name="attribute_category_id" id="categorySelect">
                                        <option value="0">请选择</option>
                                        @foreach($attribute_categories as  $attribute_category)
                                            <option value="{{ $attribute_category->id }}" @if($model->attribute_category_id===$attribute_category->id) selected @endif>{{ $attribute_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="productAttributeEle">
                                <x-admin.product-attribute
                                    :value="$model"  :attributeCategoryId="$model->attribute_category_id"
                                ></x-admin.product-attribute>
                            </div>
                        </div>
                        <div class="layui-tab-item">
                            <x-admin.layui-upload-table :product="$model"></x-admin.layui-upload-table>
                            <x-admin.layui-upload-file-table :product="$model"></x-admin.layui-upload-file-table>
                        </div>
                        @role('超级管理员')
                        <div class="layui-tab-item">
                            <x-admin.multilingualism
                                :translateField="config('multilingual.product.value.seoTranslateField')"
                                :value="$model"
                            ></x-admin.multilingualism>
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">产品图片标签</label>
                                <div class="layui-input-block">
                                    <input name="img_alt" value="{{ $model->img_alt }}" placeholder="请输入产品图片标签" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">自定义url</label>
                                <div class="layui-input-block">
                                    <input name="url_key" value=""  placeholder="请输入自定义url" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div>


                        </div>
                        @endrole
                        <div class="layui-tab-item">
                            <tag-component :tag="{{ $tags }}" type="product"></tag-component>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ mix('/js/admin/admin.product.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection

    </body>
</x-layui-layout>
