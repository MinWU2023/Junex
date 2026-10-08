<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card">
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
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
                        <x-admin.layui-upload label="{{ __('图片上传') }}" pathName="path" :path="$model->path"></x-admin.layui-upload>
                    </div>


                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">{{ __('名称') }}</label>
                        <div class="layui-input-block">
                            <input type="text" value="{{$model->name}}" name="name" lay-verify="required" placeholder="{{ __('请输入名称') }}"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item add-space-20">
                        <label class="layui-form-label">{{ __('类型') }}</label>
                        <div class="layui-input-block">
                            <select name="type" lay-verify="required">
                                <option value="1" @if($model->type===1) selected @endif>{{ __('友情链接') }}</option>
                                <option value="2" @if($model->type===2) selected @endif>{{ __('社交媒体') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">{{ __('链接') }}</label>
                        <div class="layui-input-block">
                            <input type="text" value="{{$model->url}}" name="url" lay-verify="required" placeholder="{{ __('请输入链接') }}"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <?
                        $current_locales = $model->locales??[];
                    ?>
                    <div class="layui-form-item add-space-30">
                        <label class="layui-form-label">{{ __('绑定语种') }}</label>
                        <div class="layui-input-block">
                            @foreach(app('settings')['locales'] as $locale)
                                <input type="checkbox" name="locales[{{ $locale['language_code'] }}]" title="{{ $locale['language_code'] }}" @if(in_array($locale['language_code'],$current_locales)) checked @endif >
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @section('scripts')
            <script src="{{ asset('/js/admin/admin.friendlink.js') }}"></script>
        @endsection
        @section('css')
            <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
