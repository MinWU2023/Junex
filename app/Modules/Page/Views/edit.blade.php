<x-layui-layout>

    <body>
        <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
            <input type="hidden" id="switch_editor" value="{{ app('settings')['setting']->switch_editor }}">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">{{ __('基本设置') }}</li>
                    <li>{{ __('图片上传') }}</li>
                    @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->setting_seo_show)
                        <li>{{ __('SEO设置') }}</li>
                    @endif
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <div class="layui-form-item">
                            <input type="hidden" id="id" value="{{ $model->id }}">
                            <form>
                                <input id="temp_model_id" name="temp_model_id" value="0" type="hidden">
                                @csrf
                                <div style="display:flex;align-items: center;margin-bottom:10px;gap:10px">
                                    @if (in_array('Translate', app('myAddons')) && auth()->user()->hasRole('超级管理员'))
                                        <div class="layui-form-item" style="margin-bottom:0">
                                            <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                                            <div class="layui-input-block">
                                                @if ($model->is_translate === 1)
                                                    <input type="checkbox" name="is_translate" lay-skin="switch"
                                                        lay-text="开启|关闭">
                                                    <span class="help-block">
                                                        <i
                                                            class="fa fa-info-circle"></i>&nbsp;{{ __('翻译成功 (最近翻译时间') }}{{ $tr_success_at }})
                                                    </span>
                                                @elseif($model->is_translate === 2)
                                                    <input type="checkbox" checked name="is_translate" value="1"
                                                        lay-skin="switch" lay-text="开启|关闭">
                                                    <span class="help-block">
                                                        <i class="fa fa-info-circle"></i>&nbsp;{{ __('翻译任务失败,请重新翻译') }}
                                                    @elseif($model->is_translate === 3)
                                                        <input type="checkbox" disabled checked lay-skin="switch"
                                                            lay-text="开启|关闭">
                                                        <span class="help-block">
                                                            <i
                                                                class="fa fa-info-circle"></i>&nbsp;{{ __('正在进行翻译，请稍候...') }}
                                                        @else
                                                            <input type="checkbox" name="is_translate" value="1"
                                                                lay-skin="switch" lay-text="开启|关闭">
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <a class="layui-btn layuiadmin-btn-list" id="preview_model"
                                        href="javascript:void(0)"
                                        style="color:#fff;display:flex;align-items: center;background-color: #16A291;">
                                        <svg t="1727406574231" class="icon" viewBox="0 0 1024 1024" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" p-id="7831" width="20"
                                            height="20">
                                            <path
                                                d="M512 731.428571c162.377143 0 289.938286-64 386.194286-161.206857l2.486857-2.486857c30.939429-31.158857 42.130286-43.739429 48.64-55.222857-6.436571-12.214857-18.139429-25.526857-44.982857-52.662857l-6.070857-6.070857C802.157714 356.790857 674.084571 292.571429 512 292.571429c-160.914286 0-290.377143 64.658286-387.145143 161.426285C86.454857 492.397714 73.142857 510.171429 73.142857 512c0 1.828571 13.312 19.602286 51.712 58.002286C222.354286 667.428571 350.134857 731.428571 512 731.428571z m0 73.142858c-220.16 0-365.714286-109.714286-438.857143-182.857143C36.571429 585.142857 0 548.571429 0 512s36.571429-73.142857 73.142857-109.714286C146.285714 329.142857 293.156571 219.428571 512 219.428571c220.452571 0 365.714286 109.714286 438.125714 182.857143 35.84 36.059429 73.874286 73.142857 73.874286 109.714286s-37.302857 72.923429-73.874286 109.714286C877.714286 694.857143 732.891429 804.571429 512 804.571429z m0-219.428572a73.142857 73.142857 0 1 0 0-146.285714 73.142857 73.142857 0 0 0 0 146.285714z m0 73.142857a146.285714 146.285714 0 1 1 0-292.571428 146.285714 146.285714 0 0 1 0 292.571428z"
                                                p-id="7832" fill="#fff"></path>
                                        </svg>
                                        <span style="padding-left:5px">{{ __('预览详情') }}</span></a>
                                </div>
                                <x-admin.multilingualism :translateField="config('multilingual.page.value.translateField')" uploadType="page" :value="$model">
                                </x-admin.multilingualism>
                                <div class="layui-form-item layui-hide">
                                    <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                                        id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }}">
                                </div>
                            </form>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('上级分类') }}</label>
                            <div class="layui-input-block">

                                <x-admin.form-category name="parent_id" :model="$model" :modelName="\App\Modules\Page\Models\Page::class">

                                </x-admin.form-category>

                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
                            <div class="layui-input-block">
                                <input type="number" value="{{ $model->sort }}" name="sort" lay-verify="required"
                                    placeholder="{{ __('请输入排序数字') }}" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                    </div>
                    <div class="layui-tab-item" style="margin-top:15px;">
                        <x-admin.layui-upload label="{{ __('分类封面上传') }}" pathName="img_path" :path="$model->img_path"
                            uploadType="page"></x-admin.layui-upload>
                        <x-admin.layui-upload-file-table :files="$model->pageFiles"></x-admin.layui-upload-file-table>
                    </div>
                    @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->setting_seo_show)
                        <div class="layui-tab-item">
                            <x-admin.multilingualism :translateField="config('seo.seo')" :value="$model">
                            </x-admin.multilingualism>

                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('自定义url') }}<x-admin.form-required /></label>
                                <div class="layui-input-block">
                                    <input type="text" value="{{ $model->url_key }}" name="url_key"
                                        lay-verify="required" placeholder="{{ __('请输入自定义url') }}" autocomplete="off"
                                        class="layui-input">
                                </div>
                            </div>

                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">Schema.org</label>
                                <div class="layui-input-block">
                                    <textarea name="schema" class="layui-textarea" rows="10" placeholder='{"@context":"https://schema.org",...}'>{{ old('schema', $model->schema) }}</textarea>
                                    <div class="layui-form-mid layui-word-aux">
                                        {{ __('填写 JSON-LD 内容即可；前台按 url_key 匹配后用') }} &lt;script type="application/ld+json"&gt; {{ __('包裹输出到 head') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @section('scripts')
            <script src="{{ mix('/js/admin/admin.page.js') }}"></script>
        @endsection
        @section('css')
            <link rel="stylesheet" href="{{ mix('/css/admin/admin.form.css') }}" media="all">
        @endsection
    </body>
</x-layui-layout>
