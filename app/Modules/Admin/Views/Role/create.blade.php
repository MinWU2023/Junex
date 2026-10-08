<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:25px 25px 0 25px;">
        <form id="app">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('角色') }}</label>
                <div class="layui-input-block">
                    <input type="text" value="" name="name" lay-verify="required" placeholder="{{ __('请输入角色名') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('具体描述') }}</label>
                <div class="layui-input-block">
                    <textarea type="text" name="info" lay-verify="required" autocomplete="off"
                              class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('权限分配') }}</label>
                <div style="margin-left: 110px;">
                    <permission-component role_id="0"></permission-component>
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                       id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
            </div>
        </form>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.role.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
