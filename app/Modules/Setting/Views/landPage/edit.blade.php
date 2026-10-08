<?php

use \App\Modules\Setting\Models\LandPage;

?>
<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card">
            <input type="hidden" name="area_name" value="{{ $model->area_name }}">
            <ul class="layui-tab-title">
                <li class="layui-this">{{ __('基本设置') }}</li>
                @for($i=1;$i<LandPage::MAX;$i++)
                    @if($model['plate_content_'.$i])
                        <li>{{ __('板块') }}{{ $i }}</li>
                    @endif
                @endfor
            </ul>
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

                    <?php
                    $base_fields = [
                        __('着陆页名称') => 'name',
                        'title' => 'title',
                        'keywords' => 'keywords',
                        'description' => 'description',
                        'url_key'  =>'url_key'
                    ];
                    ?>
                    @foreach($base_fields as $k=>$base_field)
                        <div class="layui-form-item add-space-30">
                            <label class="layui-form-label">{{ $k }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="{{ $base_field }}" lay-verify="required"
                                       placeholder="{{ __('请输入') }}{{ $k }}" value="{{ $model->$base_field }}"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    @endforeach


                </div>
                @for($i=1;$i<=LandPage::MAX;$i++)
                    <div class="layui-tab-item">

                            <?php
                            $images = [];
                            if (isset($model['plate_content_' . $i]['images'])) {
                                $images = $model['plate_content_' . $i]['images'];
                            }
                            ?>
                        @foreach($images as $image_k=>$image)
                            <x-admin.multiple-image name="plate_content_{{ $i }}[images][{{ $image_k }}]" :displayName="$image_k" :images="$image"></x-admin.multiple-image>
                        @endforeach


                            <?php
                            $imgs = [];
                            if (isset($model['plate_content_' . $i]['imgs'])) {
                                $imgs = $model['plate_content_' . $i]['imgs'];
                            }
                            ?>
                        @foreach($imgs as $img_k=>$img)
                            <div class="layui-form-item add-space-30">
                                <x-admin.layui-upload label="图片{{ $img_k }}"
                                                      pathName="plate_content_{{ $i }}[imgs][{{ $img_k }}]"
                                                      watermark="0" :path="$img"></x-admin.layui-upload>
                            </div>
                        @endforeach

                            <?php
                            $names = [];
                            if (isset($model['plate_content_' . $i]['names'])) {
                                $names = $model['plate_content_' . $i]['names'];
                            }
                            ?>
                        @foreach($names as $name_k=>$name)
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">{{ __('名称') }}{{ $name_k }}</label>
                                <div class="layui-input-block">
                                    <input type="text" name="plate_content_{{ $i }}[names][{{ $name_k }}]"
                                           placeholder="{{ __('请输入名称') }}{{ $name_k }}" value="{{ $name }}"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        @endforeach

                            <?php
                            $urls = [];
                            if (isset($model['plate_content_' . $i]['urls'])) {
                                $urls = $model['plate_content_' . $i]['urls'];
                            }
                            ?>
                        @foreach($urls as $url_k=>$url)
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">{{ __('url') }}{{ $url_k }}</label>
                                <div class="layui-input-block">
                                    <input type="text" name="plate_content_{{ $i }}[urls][{{ $url_k }}]"
                                           placeholder="{{ __('请输入url') }}{{ $name_k }}" value="{{ $url }}"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        @endforeach

                            <?php
                            $contents = [];
                            if (isset($model['plate_content_' . $i]['contents'])) {
                                $contents = $model['plate_content_' . $i]['contents'];
                            }
                            ?>
                        @foreach($contents as $content_k=>$content)
                            <div class="layui-form-item add-space-30">
                                <label class="layui-form-label">{{ __('内容') }}{{ $content_k }}</label>
                                <div class="layui-input-block">
                                <textarea type="text" class='tinymce_content layui-textarea'
                                          id="contents-{{$i}}-{{$content_k}}"
                                          name="plate_content_{{ $i }}[contents][{{ $content_k }}]"
                                          autocomplete="off" placeholder="{{ __('请输入内容') }}"
                                          class="layui-textarea">{!! $content !!}</textarea>
                                </div>
                            </div>

                        @endforeach
                        {{--                    <x-admin.layui-upload-file-table :files="$model->pageFiles"></x-admin.layui-upload-file-table>--}}
                    </div>
                @endfor
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('/js/admin/admin.landpage.js') }}"></script>
        <script charset="utf-8" src="{{ asset('tinymce/js/tinymce/tinymce.js') }}"></script>
        <script charset="utf-8" src="{{ asset('tinymce/js/tinymce/content.js') }}"></script>
    @endsection
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
