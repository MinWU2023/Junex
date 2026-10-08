<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding:25px 25px 0 25px;">
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
                    :translateField="config('multilingual.slogan.value.translateField')"
                    value=""
                >
                </x-admin.multilingualism>

                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-create-slogan-form-submit" id="layuiadmin-app-create-slogan-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>

        <div class="layui-form-itempadding-bottom: 25px;">
            <label class="layui-form-label">{{ __('类型') }}</label>
            <div class="layui-input-block">
                <input type="text" value="" name="type" lay-verify="required" placeholder="{{ __('请输入类型') }}" autocomplete="off" class="layui-input">
            </div>
        </div>



    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.setting.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
