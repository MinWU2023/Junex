<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding:25px 25px 0 25px;">
        <form id="app">
            <input type="hidden" id="id" value="{{ $id }}">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('管理员分配') }}</label>
                <div class="layui-input-block">
                    @foreach($allUsers as  $user)
                        <input type="checkbox" name="users[{{$user->id}}]" title="{{$user->email}}" @if(in_array($user->id,$inquiryUsers)) checked="" @endif><div class="layui-unselect layui-form-checkbox @if(in_array($user->id,$inquiryUsers)) layui-form-checked @endif"><span>{{$user->email}}</span><i class="layui-icon layui-icon-ok"></i></div>
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                       id="layuiadmin-app-edit-form-submit" value="{{ __('确认修改') }}">
            </div>
        </form>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.inquiry.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
