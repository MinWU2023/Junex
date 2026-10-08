<x-layui-layout>
    <body>
    <div class="layui-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px;">
        <div class="layui-form-item">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-login-form-submit"
                           id="layuiadmin-app-login-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label form-title">{{ __('用户名') }}</label>
            <div class="layui-input-block">
                <input name="username" lay-verify="required" placeholder="{{ __('请输入用户名') }}"
                       autocomplete="off" class="layui-input form-text">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label form-title">{{ __('密码') }}</label>
            <div class="layui-input-block">
                <input name="password" type="password" lay-verify="required" placeholder="{{ __('请输入密码') }}"
                       autocomplete="off" class="layui-input form-text">
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.addonsMarket.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
