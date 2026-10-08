<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px;">
        <div class="layui-form-item">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit" id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <div class="layui-form-item add-space-30">
                <label class="layui-form-label">{{ __('名称') }}<x-admin.form-required /></label>
            <div class="layui-input-block">
                <input type="text"  name="name" lay-verify="required" placeholder="{{ __('请输入属性分类名称') }}" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.attributeCategory.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
