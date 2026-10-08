{{-- 水印设置 --}}
<div class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-update-form-submit" 
                       id="layuiadmin-app-update-form-submit" value="确认添加">
            </div>

            <div class="layui-form-item">
                <x-admin.layui-upload label="{{ __('水印上传') }}" watermark="0" 
                                      pathName="watermark" :path="$setting->watermark"></x-admin.layui-upload>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label slide-width">{{ __('水印位置') }}</label>
                <div class="layui-input-block">
                    <select name="watermark_location" lay-verify="required">
                        @php
                            $watermark_locations = [
                                'top-left' => __('左上'),
                                'top-right' => __('右上'),
                                'bottom' => __('底部'),
                                'bottom-left' => __('左下角'),
                                'bottom-right' => __('右下角'),
                                'left' => __('左'),
                                'center' => __('中间'),
                                'right' => __('右'),
                            ];
                        @endphp
                        @foreach ($watermark_locations as $key => $value)
                            <option @if ($key == $setting->watermark_location) selected @endif value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('Setting.Views.setting.tabs._input-field', [
                'name' => 'watermark_x',
                'label' => __('新图像在当前图像 x 轴上的可选相对偏移量。偏移量将相对于位置参数计算'),
                'value' => $setting->watermark_x,
                'placeholder' => '请输入水印偏移量x'
            ])

            @include('Setting.Views.setting.tabs._input-field', [
                'name' => 'watermark_y',
                'label' => __('新图像在当前图像 y 轴上的可选相对偏移量。偏移量将相对于位置参数计算'),
                'value' => $setting->watermark_y,
                'placeholder' => '请输入水印偏移量y'
            ])

            @php
                $watermark_fields = [
                    'product_watermark' => __('产品水印是否开启'),
                    'blog_watermark' => __('博客相关水印是否开启'),
                    'article_watermark' => __('文章相关水印是否开启'),
                    'page_watermark' => __('单页面相关水印是否开启'),
                    'download_watermark' => __('下载相关水印是否开启'),
                ];
            @endphp
            @foreach ($watermark_fields as $field => $label)
                @include('Setting.Views.setting.tabs._radio-field', [
                    'label' => $label,
                    'name' => $field,
                    'value' => $setting->$field,
                    'options' => ['1' => __('开启'), '0' => __('关闭')],
                    'blockClass' => 'layui-input-inline',
                ])
            @endforeach

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

