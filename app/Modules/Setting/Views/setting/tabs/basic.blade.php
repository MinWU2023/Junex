{{-- 基本设置 --}}
<div class="layui-tab-item layui-show">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-update-form-submit" 
                       id="layuiadmin-app-update-form-submit" value="{{ __('确认添加') }}">
            </div>

            {{-- 翻译设置 --}}
            @if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->setting_seo_show)
                @if (in_array('Translate', app('myAddons')))
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
                        <div class="layui-input-block">
                            @if ($setting->is_translate === 1)
                                <input type="checkbox" name="is_translate" lay-skin="switch" lay-text="开启|关闭">
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>&nbsp;翻译成功 (最近翻译时间{{ $tr_success_at }})
                                </span>
                            @elseif($setting->is_translate === 2)
                                <input type="checkbox" checked name="is_translate" value="1" lay-skin="switch" lay-text="开启|关闭">
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>&nbsp;翻译任务失败,请重新翻译
                                </span>
                            @elseif($setting->is_translate === 3)
                                <input type="checkbox" disabled checked lay-skin="switch" lay-text="开启|关闭">
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>&nbsp;正在进行翻译，请稍候...
                                </span>
                            @else
                                <input type="checkbox" name="is_translate" value="1" lay-skin="switch" lay-text="开启|关闭">
                            @endif
                        </div>
                    </div>
                @endif
            @endif

            <x-admin.multilingualism :translateField="config('multilingual.setting.value.translateField')" :value="$setting"></x-admin.multilingualism>

            {{-- 图片上传 --}}
            @php
                $uploads = [
                    ['label' => __('logo图片上传'), 'name' => 'logo', 'path' => $setting->logo],
                    ['label' => __('底部logo图片'), 'name' => 'bottom_logo', 'path' => $setting->bottom_logo],
                    ['label' => __('内页logo图片'), 'name' => 'inner_logo', 'path' => $setting->inner_logo],
                    ['label' => __('ico图片上传'), 'name' => 'ico', 'path' => $setting->ico],
                    ['label' => __('二维码上传(Wechat)'), 'name' => 'qr_code', 'path' => $setting->qr_code],
                    ['label' => __('二维码上传(Whatsapp)'), 'name' => 'qr_code_whatsapp', 'path' => $setting->qr_code_whatsapp],
                ];
            @endphp
            @foreach((array) $uploads as $upload)
                <div class="layui-form-item">
                    <x-admin.layui-upload label="{{ $upload['label'] }}" watermark="0" 
                                          pathName="{{ $upload['name'] }}" :path="$upload['path']"></x-admin.layui-upload>
                </div>
            @endforeach

            {{-- 暂时隐藏：系统SEO设置 (TDK) --}}
            @if (false && (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->setting_seo_show))
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>{{ __('系统SEO设置 (TDK)') }}</legend>
                </fieldset>
                @php
                    $seoFields = [
                        ['name' => 'title', 'label' => __('网站标题'), 'value' => $setting->title],
                        ['name' => 'keywords', 'label' => __('网站关键词'), 'value' => $setting->keywords],
                        ['name' => 'description', 'label' => __('网站描述'), 'value' => $setting->description],
                    ];
                @endphp
                @foreach($seoFields as $field)
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ $field['label'] }}</label>
                        <div class="layui-input-block">
                            @if($field['name'] === 'description')
                                <textarea name="{{ $field['name'] }}" placeholder="{{ __('请输入') . $field['label'] }}" class="layui-textarea">{{ $field['value'] }}</textarea>
                            @else
                                <input type="text" name="{{ $field['name'] }}" value="{{ $field['value'] }}" autocomplete="off" placeholder="{{ __('请输入') . $field['label'] }}" class="layui-input">
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            @hasanyrole('超级管理员')
                <div class="layui-form-item">
                    <x-admin.layui-upload-file label="{{ __('操作指南') }}" pathName="operation_guide" :path="$setting->operation_guide"></x-admin.layui-upload-file>
                </div>

                @include('Setting.Views.setting.tabs._radio-field', [
                    'label' => __('编辑框'),
                    'name' => 'switch_editor',
                    'value' => $setting->switch_editor,
                    'options' => ['1' => 'tinymce', '2' => 'kindeditor', '3' => 'ueditor']
                ])

                @include('Setting.Views.setting.tabs._radio-field', [
                    'label' => __('是否显示所有语种'),
                    'name' => 'all_locale_active',
                    'value' => $setting->all_locale_active,
                    'options' => ['1' => '是', '0' => '否']
                ])

                @include('Setting.Views.setting.tabs._radio-field', [
                    'label' => __('分类勾选时上下级是否关联'),
                    'name' => 'tree_strictly',
                    'value' => $setting->tree_strictly,
                    'options' => ['1' => '是', '0' => '否']
                ])
            @endhasrole

            {{-- 文本输入字段 --}}
            @php
                $textFields = [
                    ['name' => 'company_address', 'label' => __('公司地址'), 'value' => $setting->company_address],
                    ['name' => 'postal_code', 'label' => __('邮政编码'), 'value' => $setting->postal_code],
                    ['name' => 'company_brief', 'label' => __('公司简介'), 'value' => $setting->company_brief],
                    ['name' => 'contract_email', 'label' => __('联系邮箱'), 'value' => $setting->contract_email, 'required' => true, 'help' => '多个邮箱请用逗号隔开，否则转发询盘失败！'],
                    ['name' => 'contract_mobile', 'label' => __('联系电话'), 'value' => $setting->contract_mobile, 'required' => true],
                    ['name' => 'whatsapp', 'label' => __('whatsapp'), 'value' => $setting->whatsapp],
                    ['name' => 'skype', 'label' => __('teams'), 'value' => $setting->skype],
                    ['name' => 'teams_link', 'label' => __('teams链接'), 'value' => $setting->teams_link],
                ];
            @endphp
            @foreach((array) $textFields as $field)
                @include('Setting.Views.setting.tabs._input-field', $field)
            @endforeach

            @role('超级管理员')
                <div class="layui-form-item">
                    <label class="layui-form-label slide-width">{{ __('facebook messenger代码') }}</label>
                    <div class="layui-input-block main-width" style="display: flex;align-items: center;">
                        <div style="width: calc(100% - 130px);">
                            <textarea name="facebook_code" autocomplete="off" placeholder="请输入facebook messenger代码" class="layui-textarea">{{ $setting->facebook_code }}</textarea>
                        </div>
                        <div style="width: 125px;text-align: right;">
                            <a href="http://m.sht.dyyseo.com/uploadfile/attachment/facebook%20messenger.doc" target="_blank" style="color: #fa5661;">操作文档下载</a>
                        </div>
                    </div>
                </div>

                @php
                    $textareaFields = [
                        ['name' => 'adwords_token', 'label' => __('adwords token'), 'value' => $setting->adwords_token],
                        ['name' => 'head_code', 'label' => __('GTM代码'), 'value' => $setting->head_code, 'placeholder' => '请输入统计代码'],
                        ['name' => 'body_code', 'label' => __('Body代码(google noscript)'), 'value' => $setting->body_code, 'placeholder' => '请输入body区域的统计代码'],
                        ['name' => 'gsg_code', 'label' => __('GSC代码'), 'value' => $setting->gsg_code, 'placeholder' => '请输入gsc代码'],
                        ['name' => 'robots', 'label' => __('robots设置'), 'value' => $robots, 'placeholder' => 'robots设置'],
                    ];
                @endphp
                @foreach((array) $textareaFields as $field)
                    <div class="layui-form-item">
                        <label class="layui-form-label slide-width">{{ $field['label'] }}</label>
                        <div class="layui-input-block main-width">
                            <textarea name="{{ $field['name'] }}" autocomplete="off" placeholder="{{ $field['placeholder'] ?? '请输入' . $field['label'] }}" class="layui-textarea">{{ $field['value'] }}</textarea>
                        </div>
                    </div>
                @endforeach
            @endrole

            <div class="layui-form-item layui-layout-admin">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">{{ __('立即提交') }}</button>
                        <button type="reset" class="layui-btn layui-btn-primary">{{ __('重置') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
