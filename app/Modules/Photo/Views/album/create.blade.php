<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card" >
            <div class="layui-tab-content"  style="padding:0px;">
                <div class="layui-form-item">
                    <form>
                        @csrf
                        <div class="layui-form-item layui-hide">
                            <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                                   id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                        </div>
                    </form>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">{{ __('名称') }}</label>
                    <div class="layui-input-block">
                        <input type="text" value="" name="name" placeholder="{{ __('请输入名称') }}"
                               class="layui-input">
                    </div>
                </div>

                {{--                <x-admin.layui-upload label="封面上传" pathName="path" path=""></x-admin.layui-upload>--}}

                <div class="layui-form-item">
                    <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}</label>
                    <div class="layui-input-block">
                        <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('/js/admin/admin.album.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
