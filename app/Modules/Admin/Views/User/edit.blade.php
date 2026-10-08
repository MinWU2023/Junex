<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:25px 25px 0 25px;">
        <form>
            <input type="hidden" id="id" value="{{ $model->id }}">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('姓名') }}</label>
                <div class="layui-input-block">
                    <input type="text" readonly disabled="disabled" value="{{ $model->name }}" name="name" lay-verify="required" placeholder="{{ __('请输入名称') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('邮箱') }}</label>
                <div class="layui-input-block">
                    <input type="text" readonly disabled="disabled" value="{{ $model->email }}" name="email" lay-verify="email" placeholder="{{ __('请输入名称') }}"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <x-admin.form-radio-role :role="$model->roles"></x-admin.form-radio-role>
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


            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('接收询盘邮件') }}</label>
                <div class="layui-input-block">
                    <select name="is_send" lay-verify="required">
                        <option  @if($model->is_send) selected @endif value="1">{{ __('是') }}</option>
                        <option  @if(!$model->is_send) selected @endif value="0">{{ __('否') }}</option>
                    </select>
                </div>
            </div>


            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                       id="layuiadmin-app-edit-form-submit" value="{{ __('确认修改') }} ">
            </div>
        </form>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.user.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
