<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding:15px 25px 0 25px;">
        <div class="layui-form-item">
            <input type="hidden" id="id" value="{{ $model->id }}">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-edit-locale-form-submit" id="layuiadmin-app-edit-locale-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <x-admin.layui-upload label="{{ __('多语言图片上传') }}" pathName="path" :path="$model->path"></x-admin.layui-upload>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('跳转链接') }}</label>
            <div class="layui-input-block">
                <input type="text" value="{{ $model->url }}" name="url" lay-verify="required" placeholder="{{ __('请输入跳转链接') }}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('语言') }}</label>
            <div class="layui-input-block">
                <input type="text" value="{{ $model->language }}" name="language" lay-verify="required" placeholder="{{ __('请输入语言') }}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('语言代码') }}</label>
            <div class="layui-input-block">
                <select name="language_code" lay-verify="required" lay-search>
                    @foreach($locales as $locale_k=>$locale_v)
                        <option @if($model->language_code == $locale_k) selected @endif  value="{{ $locale_k }}">{{ $locale_v }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('排序') }}</label>
            <div class="layui-input-block">
                <input type="text" value="{{ $model->sort }}" name="sort" placeholder="{{ __('请输入排序') }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.setting.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
