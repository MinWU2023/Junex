<x-layui-layout>
    <body>
    <div class="layui-fluid pf-page">
        <div class="layui-card">
            <div class="layui-card-body">
                @include('Product.Views.productFaq._styles')

                <div class="pf-hero">
                    <div class="pf-hero-main">
                        <span class="pf-hero-kicker"><i class="layui-icon layui-icon-edit"></i>{{ __('编辑') }} #{{ $model->id }}</span>
                        <h1 class="pf-hero-title">{{ __('编辑产品Faqs') }}</h1>
                        <p class="pf-hero-desc">
                            {{ \Illuminate\Support\Str::limit(strip_tags((string)$model->subject), 80) }}
                            @if($model->source_faq_id)
                                · {{ __('同步自 Faqs') }} #{{ $model->source_faq_id }}
                            @endif
                        </p>
                    </div>
                    <div class="pf-hero-actions">
                        <a class="layui-btn pf-btn pf-btn-ghost" href="{{ route('admin.productFaq.index') }}">{{ __('返回列表') }}</a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="pf-alert pf-alert-error">
                        <i class="layui-icon layui-icon-close-fill"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form class="layui-form" method="post" action="{{ route('admin.productFaq.update', $model->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="pf-form-section">
                        <div class="pf-form-section-title"><i class="layui-icon layui-icon-set"></i>{{ __('基础设置') }}</div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="sort" value="{{ old('sort', $model->sort) }}" class="layui-input" autocomplete="off" style="max-width:200px;border-radius:8px;">
                                <p class="pf-form-hint">{{ __('数字越大越靠前') }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('启用') }}</label>
                            <div class="layui-input-block">
                                <input type="checkbox" name="active" value="1" lay-skin="switch" lay-text="ON|OFF" @if(old('active', $model->active)) checked @endif>
                            </div>
                        </div>
                    </div>

                    <div class="pf-form-section">
                        <div class="pf-form-section-title"><i class="layui-icon layui-icon-fonts-strong"></i>{{ __('多语言内容') }}</div>
                        <x-admin.multilingualism
                            :translateField="config('multilingual.productFaq.value.translateField')"
                            :value="$model"
                        />
                    </div>

                    @include('Product.Views.productFaq._relation_fields')

                    <div class="pf-footer-actions">
                        <a class="layui-btn pf-btn pf-btn-ghost" href="{{ route('admin.productFaq.index') }}">{{ __('取消') }}</a>
                        <button class="layui-btn pf-btn pf-btn-primary" type="submit" style="background:#656EE6!important;border-color:#656EE6!important;color:#fff!important;">
                            <i class="layui-icon layui-icon-ok"></i> {{ __('保存修改') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            layui.use(['form', 'element', 'jquery', 'layer'], function () {
                layui.form.render();
                layui.element.render();
            });
        </script>
        @include('Product.Views.productFaq._relation_scripts')
    @endsection
    </body>
</x-layui-layout>
