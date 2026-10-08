{{-- SEO权限设置 --}}
<div class="layui-tab-item">
    <div class="layui-card-body" style="padding: 15px;">
        <form class="layui-form set-form base-form" action="" lay-filter="component-form-group">
            @csrf
            <div class="layui-form-item layui-hide">
                <input type="button" lay-submit lay-filter="layuiadmin-app-update-form-submit" 
                       id="layuiadmin-app-update-form-submit" value="{{ __('确认添加') }}">
            </div>

            @php
                $seo_shows = [
                    'setting_seo_show' => __('是否显示系统seo设置'),
                    'product_list_seo_show' => __('是否显示产品列表seo设置'),
                    'product_category_seo_show' => __('是否显示产品分类seo设置'),
                    'product_detail_seo_show' => __('是否显示产品详情seo设置'),
                    'product_tag_seo_show' => __('是否显示产品tag seo设置'),
                    'article_category_seo_show' => __('是否显示文章分类seo设置'),
                    'article_detail_seo_show' => __('是否显示文章详情seo设置'),
                    'blog_category_seo_show' => __('是否显示博客分类seo设置'),
                    'blog_detail_seo_show' => __('是否显示博客详情seo设置'),
                    'blog_tag_seo_show' => __('是否显示博客tag seo设置'),
                ];
            @endphp

            @foreach ($seo_shows as $seo_name => $seo_label)
                @include('Setting.Views.setting.tabs._radio-field', [
                    'label' => $seo_label,
                    'name' => $seo_name,
                    'value' => $setting->$seo_name,
                    'options' => ['1' => __('是'), '0' => __('否')]
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

