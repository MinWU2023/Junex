<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding:25px 25px 0 25px; ">
        <div class="layui-form-item">
            <input type="hidden" id="id" value="{{ $model->id }}">
            <form>
                @csrf
                @if(in_array('Translate',app('myAddons')) && auth()->user()->hasRole('超级管理员'))
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                        <div class="layui-input-block">
                            @if($model->is_translate === 1)
                                <input type="checkbox"   name="is_translate"  lay-skin="switch" lay-text="开启|关闭">
                                <span class="help-block">
    <i class="fa fa-info-circle"></i>&nbsp;翻译成功 (最近翻译时间{{ $tr_success_at }})
</span>
                            @elseif($model->is_translate === 2)
                                <input type="checkbox"  checked name="is_translate" value="1"   lay-skin="switch" lay-text="开启|关闭">
                                <span class="help-block">
    <i class="fa fa-info-circle"></i>&nbsp;翻译任务失败,请重新翻译
                                            @elseif($model->is_translate === 3)
                                        <input type="checkbox" disabled checked  lay-skin="switch" lay-text="开启|关闭">
                                        <span class="help-block">
    <i class="fa fa-info-circle"></i>&nbsp;正在进行翻译，请稍候...
                                            @else
                                                <input type="checkbox" name="is_translate" value="1"  lay-skin="switch" lay-text="开启|关闭">
                            @endif
                        </div>
                    </div>
                @endif
                <x-admin.multilingualism
                    :translateField="config('multilingual.blog_tag.value.translateField')"
                    :value="$model">
                </x-admin.multilingualism>
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit" id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
            <div class="layui-input-block">
                <input type="number" value="{{ $model->sort }}" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('自定义链接') }}<x-admin.form-required /></label>
            <div class="layui-input-block">
                <input name="url_key" value="{{ $model->url_key }}" lay-verify="required" placeholder="{{ __('请输入自定义链接') }}" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.blog.tag.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
