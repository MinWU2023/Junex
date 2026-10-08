<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">{{ __('基本信息') }}</li>
                @role('超级管理员')
                <li>{{ __('SEO设置') }}</li>
                @endrole
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <form>
                            @csrf
                            <x-admin.multilingualism
                                :translateField="config('multilingual.product_tag.value.translateField')"
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
                        <label class="layui-form-label">{{ __('自定义链接') }}</label>
                        <div class="layui-input-block">
                            <input name="url_key" placeholder="{{ __('请输入自定义链接') }}" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
                        <div class="layui-input-block">
                            <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                @role('超级管理员')
                <div class="layui-tab-item">
                    <x-admin.multilingualism
                        :translateField="config('seo.seo')"
                        value=""
                    ></x-admin.multilingualism>
                </div>
                @endrole
            </div>


        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.tag.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
