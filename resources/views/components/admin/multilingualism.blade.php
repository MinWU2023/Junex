<div class="layui-card">
    <div class="layui-card-body">
        <div class="layui-tab layui-tab-brief" lay-filter="component-tabs-brief">
            <input type="hidden" value="{{ @csrf_token() }}" id="token">
            <ul class="layui-tab-title">
                @foreach($theLocales as $key => $value)
                    @if($loop->first)
                        <li class="layui-this">{{ $value }}</li>
                    @else
                        <li>{{ $value }}</li>
                    @endif
                @endforeach
            </ul>
            <div class="layui-tab-content" id="moreUedit">
                @foreach($theLocales as $key => $value)
                    @if($loop->first)
                        <div class="layui-tab-item layui-show">
                            @else
                                <div class="layui-tab-item">
                                    @endif
                                    @foreach($theTranslateField as $k => $v)
                                        @if(!empty($v['hidden']))
                                            @continue
                                        @endif
                                        <div class="clearfix">
                                            <label class="layui-form-label">
                                                {{ $v['label'] }}({{ $value }})
                                                @if (!empty($v['require']))
                                                    <span class="admin-form-required" style="color:#FF5722;">*</span>
                                                @endif
                                                @if (isset($v['tip']))
                                                    <i class="layui-icon layui-icon-tips" lay-tips="{{ $v['tip'] }}" lay-offset="5"></i>
                                                @endif
                                            </label>
                                            <div class="layui-input-block" style="margin-top:20px;">
                                                <?php $name = $v['name'];?>
                                                @if($v['type'] === 'text')
                                                    <input type="text"
                                                           @if($theValue && $theValue->translate($value)) value="{{ ($theValue->translate($value))->$name }}"
                                                           @endif name="translate[{{$value}}][{{$v['name']}}]"
                                                           @if( $key === 0 && $v['require'] ) lay-verify="required"
                                                           @endif placeholder="{{ __('请输入...') }}" autocomplete="off"
                                                           class="layui-input">
                                                @endif
                                                @if($v['type'] === 'textarea')
                                                    <textarea name="translate[{{$value}}][{{$v['name']}}]"
                                                              @if( $key === 0 && $v['require'] ) lay-verify="required" @endif
                                                              placeholder="{{ __('请输入...') }}"
                                                              class="layui-textarea"
                                                              rows="4">@if($theValue && $theValue->translate($value)){{ ($theValue->translate($value))->$name }}@endif</textarea>
                                                @endif
                                                @if($v['type'] === 'list')
                                                    @php
                                                        $listItems = [];
                                                        if ($theValue && $theValue->translate($value)) {
                                                            $rawList = ($theValue->translate($value))->$name;
                                                            if (is_string($rawList)) {
                                                                $rawList = json_decode($rawList, true) ?: [];
                                                            }
                                                            if (is_array($rawList)) {
                                                                foreach ($rawList as $row) {
                                                                    $listItems[] = is_array($row) ? (string)($row['text'] ?? '') : (string)$row;
                                                                }
                                                            }
                                                        }
                                                        if (empty($listItems)) {
                                                            $listItems = [''];
                                                        }
                                                    @endphp
                                                    <div class="translate-list-field" data-locale="{{ $value }}" data-field="{{ $v['name'] }}">
                                                        <div class="translate-list-rows">
                                                            @foreach($listItems as $listItem)
                                                                <div class="translate-list-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center;">
                                                                    <input type="text"
                                                                           name="translate[{{$value}}][{{$v['name']}}][]"
                                                                           value="{{ $listItem }}"
                                                                           placeholder="{{ __('请输入列表文案') }}"
                                                                           autocomplete="off"
                                                                           class="layui-input">
                                                                    <button type="button" class="layui-btn layui-btn-danger layui-btn-sm translate-list-remove">{{ __('删除') }}</button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button type="button"
                                                                class="layui-btn layui-btn-primary layui-btn-sm translate-list-add"
                                                                data-locale="{{ $value }}"
                                                                data-field="{{ $v['name'] }}">{{ __('新增列表项') }}</button>
                                                    </div>
                                                @endif
                                                @if($v['type'] === 'uedit')
                                                    @php
                                                        $ueditContent = '';
                                                        if ($theValue && $theValue->translate($value)) {
                                                            $ueditContent = (string)(($theValue->translate($value))->$name ?? '');
                                                        }
                                                    @endphp
                                                    @if(app('settings')['setting']->switch_editor == 3)
                                                        <script id="translate[{{$value}}][{{$v['name']}}]"
                                                                name="translate[{{$value}}][{{$v['name']}}]"
                                                                @if( $key === 0 && $v['require'] ) lay-verify="required" @endif
                                                                type="text/plain">{!! str_ireplace('</script>', '&lt;/script&gt;', $ueditContent) !!}</script>
                                                    @else
                                                        <textarea class="tinymce_content layui-textarea"
                                                                  id="translate-{{$value}}-{{$v['name']}}"
                                                                  uploadType="{{ $uploadType }}_editor"
                                                                  name="translate[{{$value}}][{{$v['name']}}]"
                                                                  autocomplete="off"
                                                                  placeholder="{{ __('请输入内容') }}"
                                                                  @if( $key === 0 && $v['require'] ) lay-verify="required" @endif>{{ $ueditContent }}</textarea>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endforeach
                        </div>
            </div>
        </div>
    </div>

    @section('ext')
        @if(app('settings')['setting']->switch_editor == 1)
            <script charset="utf-8" src="{{ asset('tinymce/js/tinymce/tinymce.js') }}"></script>
            <script charset="utf-8" src="{{ asset('tinymce/js/tinymce/content.js') }}"></script>
        @elseif(app('settings')['setting']->switch_editor == 2)
            <script charset="utf-8" src="{{ asset('/kindeditor/kindeditor-all.js') }}"></script>
            <script charset="utf-8" src="{{ asset('/kindeditor/lang/zh-CN.js') }}"></script>
            <script>
                layui.use(['jquery', 'layer'], function () {
                    var $ = layui.$ //重点处
                    var moreUedit = $('.tinymce_content');
                    moreUedit.each(function () {
                        var id = $(this).attr('id');
                        // var token = $('#token').val()
                        KindEditor.ready(function (K) {
                            window.editor = K.create('#' + id, {
                                items: ['source', '|', 'undo', 'redo', '|', 'print', 'template', 'code', 'cut', 'copy', 'paste',
                                    'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
                                    'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                                    'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
                                    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                                    'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
                                    'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
                                    'anchor', 'link', 'unlink', '|', 'about'],
                                height: '400',
                                width:'100%',
                                uploadJson: '/nosay/upload',
                                allowFileManager: true,
                                afterBlur: function () {
                                    this.sync();
                                }
                            });
                        });
                    });
                })
            </script>
@else
    @include('layouts.admin.uedit')
@endif
@endsection
