<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:15px 25px 0 25px;">
        <form>
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('姓名') }}</label>
                <div class="layui-input-block">
                    <input type="text" value="" name="name" lay-verify="required" placeholder="{{ __('请输入名称') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('邮箱') }}</label>
                <div class="layui-input-block">
                    <input type="text" value="" name="email" lay-verify="email" placeholder="{{ __('请输入邮箱') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-item">
                    <label class="layui-form-label">{{ __('所属职称') }}：</label>
                    <div class="layui-input-block">
                        @php(
    $roles = \Spatie\Permission\Models\Role::query()->where('id','>',2)->get()
)
                        @foreach($roles as $key => $role)
                            <input type="radio" name="role" value="{{ $role['id'] }}" title="{{ $role['name'] }}">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('密码') }}</label>
                <div class="layui-input-block">
                    <input type="password" value="" name="password" lay-verify="required" placeholder="{{ __('请输入密码') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('确认密码') }}</label>
                <div class="layui-input-block">
                    <input type="password" value="" name="password_confirmation" lay-verify="required" placeholder="{{ __('请输入密码') }}"
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
        <script src="{{ asset('/js/admin/admin.manager.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
