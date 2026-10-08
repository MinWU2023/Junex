<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags"
         style="padding-top: 30px;">
        <div class="layui-form-item">
            <input type="hidden" id="id" value="{{ $model->id }}">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                           id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>

        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('名称') }}<x-admin.form-required /></label>
            <div class="layui-input-block">
                <input type="text" value="{{ $model->name }}" name="name" lay-verify="required" placeholder="{{ __('请输入属性分类名称') }}"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item add-space-30">
            <label class="layui-form-label">{{ __('绑定属性') }}</label>
            <div class="layui-input-block">

                @foreach($attributes as $attribute)
                <div>
                <input type="checkbox" name="categories[{{$attribute->id}}]" @if(in_array($attribute->id,$checkIds)) checked @endif title="{{$attribute->name}}">
                <div class="layui-unselect layui-form-checkbox"><span>{{$attribute->name}}</span><i class="layui-icon layui-icon-ok"></i>
                </div>
                </div>
                @endforeach
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
