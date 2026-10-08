<x-layui-layout>

    <body>
        <div class="layui-fluid">
            <div class="layui-card">
                <div class="layui-tab layui-tab-card" lay-filter="setting-tabs">
                    {{-- Tab 标题 --}}
                    <ul class="layui-tab-title">
                        <li class="layui-this">{{ __('基本设置') }}</li>
                        <li>{{ __('水印设置') }}</li>
                        @role('超级管理员')
                        <li>{{ __('安全设置') }}</li>
                        <li>{{ __('邮件配置') }}</li>
                        @endrole
                        <li lay-id="banner">{{ __('Banner设置') }}</li>
                        @role('超级管理员')
                        <li lay-id="locale">{{ __('多语言设置') }}</li>
                        <li lay-id="slogan">{{ __('slogan设置') }}</li>
                        @endrole
                        @hasanyrole('超级管理员|网站管理员')
                        @php
                            $hasSeoTemplate = auth()->user()->hasRole('超级管理员') || 
                                $setting->product_list_seo_show || 
                                $setting->product_category_seo_show || 
                                $setting->product_detail_seo_show || 
                                $setting->product_tag_seo_show || 
                                $setting->article_category_seo_show || 
                                $setting->article_detail_seo_show || 
                                $setting->blog_category_seo_show || 
                                $setting->blog_detail_seo_show || 
                                $setting->blog_tag_seo_show;
                        @endphp
                        @if($hasSeoTemplate)
                        <li>{{ __('seo模板设置') }}</li>
                        @endif
                        <li>{{ __('相关数量设置') }}</li>
                        @endhasanyrole
                        @role('超级管理员')
                        <li>{{ __('询盘敏感词过滤&&相关位置') }}</li>
                        <li>{{ __('whatApp相关设置') }}</li>
                        <li>{{ __('seo设置权限') }}</li>
                        @endrole
                    </ul>

                    {{-- Tab 内容 --}}
                    <div class="layui-tab-content tips-to-help">
                        {{-- 基本设置 --}}
                        @include('Setting.Views.setting.tabs.basic', ['setting' => $setting, 'tr_success_at' => $tr_success_at ?? '', 'robots' => $robots ?? ''])

                        {{-- 水印设置 --}}
                        @include('Setting.Views.setting.tabs.watermark', ['setting' => $setting])

                        @role('超级管理员')
                        {{-- 安全设置 --}}
                        @include('Setting.Views.setting.tabs.security', ['setting' => $setting])

                        {{-- 邮件配置 --}}
                        @include('Setting.Views.setting.tabs.email', ['setting' => $setting])
                        @endrole

                        {{-- Banner设置 --}}
                        @include('Setting.Views.setting.tabs.banner')

                        @role('超级管理员')
                        {{-- 多语言设置 --}}
                        @include('Setting.Views.setting.tabs.locale')

                        {{-- Slogan设置 --}}
                        @include('Setting.Views.setting.tabs.slogan')
                        @endrole

                        @hasanyrole('超级管理员|网站管理员')
                        {{-- SEO模板设置 --}}
                        @php
                            $hasSeoTemplate = auth()->user()->hasRole('超级管理员') || 
                                $setting->product_list_seo_show || 
                                $setting->product_category_seo_show || 
                                $setting->product_detail_seo_show || 
                                $setting->product_tag_seo_show || 
                                $setting->article_category_seo_show || 
                                $setting->article_detail_seo_show || 
                                $setting->blog_category_seo_show || 
                                $setting->blog_detail_seo_show || 
                                $setting->blog_tag_seo_show;
                        @endphp
                        @if($hasSeoTemplate)
                        @include('Setting.Views.setting.tabs.seo-template')
                        @endif

                        {{-- 相关数量设置 --}}
                        @include('Setting.Views.setting.tabs.numbers', ['setting' => $setting, 'nums' => $nums ?? []])
                        @endhasanyrole

                        @role('超级管理员')
                        {{-- 询盘敏感词过滤 --}}
                        @include('Setting.Views.setting.tabs.filters', [
                        'sensitive_words' => $sensitive_words ?? '[]',
                        'banner_areas' => $banner_areas ?? '[]',
                        'allow_ips' => $allow_ips ?? '[]',
                        'ban_ips' => $ban_ips ?? '[]',
                        'ban_emails' => $ban_emails ?? '[]',
                        'ban_access_ips' => $ban_access_ips ?? '[]'
                        ])

                        {{-- WhatsApp设置 --}}
                        @include('Setting.Views.setting.tabs.whatsapp', ['setting' => $setting])

                        {{-- SEO权限设置 --}}
                        @include('Setting.Views.setting.tabs.seo-permissions', ['setting' => $setting])
                        @endrole
                    </div>
                </div>
            </div>
        </div>

        @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ mix('/js/admin/admin.setting.js') }}"></script>
        @endsection

        @section('css')
        <link rel="stylesheet" href="{{ mix('/css/admin/admin.form.css') }}" media="all">
        @endsection
    </body>
    <style>
        .care-tips {
            color: #FF5722 !important
        }
    </style>
</x-layui-layout>