{{-- 多语言设置 --}}
<div class="layui-tab-item">
    <div class="layui-card1">
        <div class="layui-card-body1">
            <div style="padding-bottom: 25px;">
                <input type="hidden" value="{{ csrf_token() }}" id="token">
                <button class="layui-btn layuiadmin-btn-list" data-type="locale_add">{{ __('添加') }}</button>
                <button class="layui-btn layuiadmin-btn-list" data-type="locale_sync">{{ __('更新语言代码') }}</button>
            </div>
            <blockquote class="layui-elem-quote seo-template">
                <p>
                    <span style="color: red">{{ __('注意:语言代码请按') }}<a href="https://zh.wikipedia.org/wiki/ISO_639-1">{{ __('标准') }}</a>{{ __('设置') }}</span>
                </p>
                <p>
                    <span style="color: #1E9FFF">{{ __('提示：如果不需要翻译的语种，请将排序设置为44即可跳过翻译') }}</span>
                </p>
            </blockquote>
            <table class="my-special-table" id="LAY-app-locale-content-list" lay-filter="LAY-app-locale-content-list"></table>
            <script type="text/html" id="table-content-list">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="icon-edit02"></i>{{ __('编辑') }}</a>
            </script>
            <script type="text/html" id="productThumb">
                <img src="/@{{d.path}}" alt="">
            </script>
        </div>
    </div>
</div>