{{-- SEO模板设置 --}}
<div class="layui-tab-item" style="width: calc(100% - 180px);">
    <div class="layui-card-body" style="padding: 15px;">
        <blockquote class="layui-elem-quote seo-template layui-elem-quotetag" style="position: fixed;z-index: 100;right:0px">
            @php
                $seoTags = [
                    '首页' => ['{site_name}' => '网站名称'],
                    '产品列表' => ['{site_name}' => '网站名称'],
                    '博客列表' => ['{site_name}' => '网站名称'],
                    '产品详情' => ['{1101}' => '产品名称', '{1102}' => '产品tag'],
                    '产品分类' => ['{1103}' => '当前产类名称', '{1105}' => '上级分类名称', '{1106}' => '下级分类名称'],
                    '产品TAG' => ['{1107}' => 'tag名称'],
                    '文章分类' => ['{1108}' => '当前分类名称'],
                    '文章' => ['{1109}' => '文章名称'],
                    '博客分类' => ['{1110}' => '当前分类名称'],
                    '博客' => ['{1112}' => '博客名称', '{1113}' => '博客tag'],
                    '博客TAG' => ['{1113}' => '当前tag名称'],
                ];
            @endphp
            @foreach($seoTags as $title => $tags)
                <div class="layui-tag">
                    <div class="layui-fl">{{ __($title) }}：</div>
                    <div class="layui-fr">
                        @foreach($tags as $code => $desc)
                            <span>{{ $code }}: {{ __($desc) }}</span><br />
                        @endforeach
                    </div>
                </div>
            @endforeach
        </blockquote>
        <form class="layui-form base-form" action="" lay-filter="component-form-group">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <x-admin.multilingualism-seo></x-admin.multilingualism-seo>
            <div class="layui-form-item layui-layout-admin">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="component-form-seo-template">{{ __('立即提交') }}</button>
                        <button type="reset" class="layui-btn layui-btn-primary">{{ __('重置') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
