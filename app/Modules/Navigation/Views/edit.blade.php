<x-layui-layout>
    <body>
    <div id="app" class="layui-card">
        <div class="layui-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
            <div class="layui-tab layui-tab-card">
                <div class="layui-tab-content">
                    <div class="layui-form-item">
                        <input type="hidden" id="id" value="{{ $model->id }}">
                        <form>
                            @csrf
                            <input type="hidden" name="area" value="{{ $model->area ?: ($area ?? '头部') }}">
                            @if(in_array('Translate',app('myAddons')) && auth()->user()->hasRole('超级管理员'))
                                <div class="layui-form-item">
                                    <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                                    <div class="layui-input-block">
                                        @if($model->is_translate === 1)
                                            <input type="checkbox" name="is_translate" lay-skin="switch" lay-text="开启|关闭">
                                        @elseif($model->is_translate === 2)
                                            <input type="checkbox" checked name="is_translate" value="1" lay-skin="switch" lay-text="开启|关闭">
                                        @elseif($model->is_translate === 3)
                                            <input type="checkbox" disabled checked lay-skin="switch" lay-text="开启|关闭">
                                        @else
                                            <input type="checkbox" name="is_translate" value="1" lay-skin="switch" lay-text="开启|关闭">
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <x-admin.multilingualism
                                :translateField="config('multilingual.navigation.value.translateField')"
                                :value="$model"
                            >
                            </x-admin.multilingualism>
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                                       id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }}">
                            </div>
                        </form>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('Type') }}</label>
                        <div class="layui-input-block">
                            <input type="text" class="layui-input" value="{{ ($model->area === '底部') ? __('底部导航') : __('头部导航') }}" disabled>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('上级导航') }}</label>
                        <div class="layui-input-block">
                            <x-admin.form-select-navigation :model="$model" :area="$model->area ?: '头部'"></x-admin.form-select-navigation>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('链接类型') }}</label>
                        <div class="layui-input-block">
                            <input type="radio" name="link_type" value="normal" title="{{ __('普通导航') }}" lay-filter="nav-link-type" @if(($model->link_type ?: 'normal') !== 'category') checked @endif>
                            <input type="radio" name="link_type" value="category" title="{{ __('关联分类') }}" lay-filter="nav-link-type" @if(($model->link_type ?: 'normal') === 'category') checked @endif>
                        </div>
                    </div>

                    <div class="layui-form-item" id="nav-category-box" @if(($model->link_type ?: 'normal') !== 'category') style="display:none;" @endif>
                        <label class="layui-form-label">{{ __('关联分类') }}</label>
                        <div class="layui-input-block">
                            @include('Navigation.Views._category_tree', [
                                'categoryTree' => $categoryTree ?? [],
                                'selectedCategoryIds' => $selectedCategoryIds ?? [],
                            ])
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('url') }}</label>
                        <div class="layui-input-block">
                            <input type="text" value="{{ $model->url }}" name="url" placeholder="{{ __('请输入url') }}" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否显示') }}</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_show" value="1" lay-skin="switch" lay-text="显示|隐藏" @if((int)$model->is_show === 1) checked @endif>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否新窗口') }}</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_new" value="1" lay-skin="switch" lay-text="是|否" @if((int)$model->is_new === 1) checked @endif>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否nofollow') }}</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_nofollow" value="1" lay-skin="switch" lay-text="是|否" @if((int)$model->is_nofollow === 1) checked @endif>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}</label>
                        <div class="layui-input-block">
                            <input type="number" value="{{ $model->sort }}" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.navigation.js') }}?v=20260814"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{ asset('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
