<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:25px 25px 0 25px;">
        <form>
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('名称') }}</label>
                <div class="layui-input-block">
                    <input type="text" value="" name="name" lay-verify="required" placeholder="{{ __('请输入名称') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                       id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
            </div>
        </form>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.permissionGroup.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
