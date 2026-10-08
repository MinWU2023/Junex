<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top:20px;">
        <div class="layui-form-item">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                           id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('名称') }}</label>
            <div class="layui-input-block">
                <input name="name" lay-verify="required" placeholder="{{ __('请输入名称') }}"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('上级分类') }}</label>
            <div class="layui-input-block">
                <x-admin.form-select-menu verify="required" menu=""
                                          showLevel0="1"></x-admin.form-select-menu>
            </div>
        </div>
        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('路由') }}</label>
            <div class="layui-input-block">
                <input name="route" lay-verify="required" placeholder="{{ __('请输入路由') }}"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('图标') }}</label>
            <div class="layui-input-block">
                <input name="icon" placeholder="{{ __('请输入图标') }}"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}</label>
            <div class="layui-input-block">
                <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.menu.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
