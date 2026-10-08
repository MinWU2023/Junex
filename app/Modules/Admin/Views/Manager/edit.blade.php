<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:15px 25px 0 25px;">
        <form>
            <input type="hidden" id="id" value="{{ $model->id }}">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('姓名') }}</label>
                <div class="layui-input-block">
                    <input type="text"   value="{{ $model->name }}" name="name" lay-verify="required" placeholder="{{ __('请输入名称') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('邮箱') }}</label>
                <div class="layui-input-block">
                    <input type="text"  value="{{ $model->email }}" name="email" lay-verify="email" placeholder="{{ __('请输入邮箱') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                @php(
$roles = \Spatie\Permission\Models\Role::query()->where('id','>',2)->get()
)

                <div class="layui-form-item">
                    <label class="layui-form-label">{{ __('所属职称') }}：</label>
                    <div class="layui-input-block">
                        @foreach($roles as $role)
                            <input type="radio" name="role" value="{{ $role['id'] }}" title="{{ $role['name'] }}" @if(isset($model->roles[0]) && $role['id'] === $model->roles[0]->id) checked @endif>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('密码') }}</label>
                <div class="layui-input-block">
                    <input type="password" value="" name="password" placeholder="{{ __('请输入密码') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('确认密码') }}</label>
                <div class="layui-input-block">
                    <input type="password" value="" name="password_confirmation" placeholder="{{ __('请输入密码') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                       id="layuiadmin-app-edit-form-submit" value="确认修改">
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
