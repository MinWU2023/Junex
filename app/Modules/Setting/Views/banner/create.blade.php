<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding:15px 25px 0 25px;">
        <div class="layui-form-item">
            <form>
                @csrf
                @if(in_array('Translate',app('myAddons')) && auth()->user()->hasRole('超级管理员'))
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="is_translate"  lay-skin="switch">
                        </div>
                    </div>
                @endif
                <x-admin.multilingualism
                    :translateField="config('multilingual.banner.value.translateField')"
                    value=""
                >
                </x-admin.multilingualism>
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit" id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <div class="layui-form-item">
            <x-admin.layui-upload label="{{ __('banner图上传') }}" pathName="path" path="" limit="0"></x-admin.layui-upload>
        </div>
        <div class="layui-form-item">
            <x-admin.layui-upload label="{{ __('手机端banner图上传') }}" pathName="path_mobile" path="" limit="0"></x-admin.layui-upload>
            <div class="layui-form-mid layui-word-aux" style="margin-left:110px;">{{ __('非必传；小于768px时使用，未上传则沿用PC端图逻辑') }}</div>
        </div>
        {{--        <div class="layui-form-item">--}}
        {{--            <label class="layui-form-label">标题</label>--}}
        {{--            <div class="layui-input-block">--}}
        {{--                <input type="text" value="" name="name" placeholder="请输入标题" autocomplete="off" class="layui-input">--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('跳转链接') }}</label>
            <div class="layui-input-block">
                <input type="text" value="" name="url" placeholder="{{ __('请输入跳转链接') }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}</label>
            <div class="layui-input-block">
                <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('Banner显示区域') }}</label>
            <div class="layui-input-block">
                <select name="area" lay-verify="required">
                    @foreach($areas as $key => $value)
                        <option value="{{ $value }}" @if(!$key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{--        <div class="layui-form-item">--}}
        {{--            <label class="layui-form-label">描述</label>--}}
        {{--            <div class="layui-input-block">--}}
        {{--                <input type="text" value="" name="description" placeholder="请输入描述" autocomplete="off" class="layui-input">--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.setting.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
